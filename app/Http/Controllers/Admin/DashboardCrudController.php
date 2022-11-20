<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Member;
use App\Models\PtProject;
use App\Models\AppSetting;
use Illuminate\Http\Request;
use App\Models\MstFiscalYear;
use App\Models\MstFedDistrict;
use App\Models\MstFedProvince;
use App\Base\BaseCrudController;
use App\Models\MstFedLocalLevel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Backpack\CRUD\app\Library\Widget;
use Illuminate\Support\Facades\Session;


/**
 * Class DashboardCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class DashboardCrudController extends BaseCrudController
{
    protected $user;
    public function index()
    {
        $this->user = backpack_user();

        if($this->user->isClientUser()){
            // $this->getDashboardDataForClient();
        }
    return view('admin.dashboard',$this->data);
    }

      /**
     * default load
     */
    public function getNepalMapdata(Request $request){
        ini_set( 'precision', 17 );
        ini_set( 'serialize_precision', -1 );

        $db_data=DB::table('mst_fed_coordinates')->where('level',0)->get();
        
        $to_return_array=[];
        $to_return_array['type']='FeatureCollection';
        $features=[];
        foreach($db_data as $key=> $dt){
            $province=DB::table('mst_fed_province')->where('code',$dt->code)->first();
            $features_one['type']="Feature";
            $features_one['geometry']['type']="Polygon";
            $features_one['properties']['Province']=$province->id;
            $features_one['properties']['TARGET']=$province->name_en;
            $features_one['properties']['Level']=0;
            $features_one['properties']['PROVINCE_NAME']=$province->name_en;

            // string geo point to array
            $exploded_array=explode("],",$dt->coordinates);
            $formatted_gis_data=[];
            $remove_arr=array("[","]");
            foreach($exploded_array as $ea){
                $lat_long=explode(",",$ea);
                $lat=floatval(str_replace($remove_arr,"", $lat_long[0]));
                $long=floatval($lat_long[1]);
                array_push($formatted_gis_data,[$lat,$long]);
            }
            $features_one['geometry']['coordinates']=[$formatted_gis_data];

            array_push($features,$features_one);
        }
        $to_return_array['features']=$features;

        $to_return_array=json_encode($to_return_array);
        return response()->json($to_return_array);
    }

      /**
     * province data on click
     */
    public function getProvinceData(Request $request){
        ini_set( 'precision', 17 );
        ini_set( 'serialize_precision', -1 );

        $db_data=DB::table('mst_fed_coordinates')
                    ->leftjoin('mst_fed_district','mst_fed_district.code','mst_fed_coordinates.code')
                    ->where([['mst_fed_coordinates.level',1],['mst_fed_district.province_id',$request->id]])->get();
        $to_return_array=[];
        $to_return_array['type']='FeatureCollection';

        $features=[];
        foreach($db_data as $key=> $dt){
            $district=DB::table('mst_fed_district')->where('code',$dt->code)->first();

            $features_one['type']="Feature";
            $features_one['geometry']['type']="Polygon";
            $features_one['properties']['District']=$district->id;
            $features_one['properties']['TARGET']=$district->name_en;
            $features_one['properties']['Level']=1;
            $features_one['properties']['DISTRICT_NAME']=$district->name_en;

            // string geo point to array
            $exploded_array=explode("],",$dt->coordinates);
            $formatted_gis_data=[];
            $remove_arr=array("[","]");
            foreach($exploded_array as $ea){
                $lat_long=explode(",",$ea);
                $lat=floatval(str_replace($remove_arr,"", $lat_long[0]));
                $long=floatval($lat_long[1]);
                array_push($formatted_gis_data,[$lat,$long]);
            }
            $features_one['geometry']['coordinates']=[$formatted_gis_data];

            array_push($features,$features_one);
        }
        $to_return_array['features']=$features;

        $to_return_array=json_encode($to_return_array);
        return response()->json($to_return_array);
       
    }


    /**
     * district data on click
     */
    public function getDistrictData(Request $request){
        ini_set( 'precision', 17 );
        ini_set( 'serialize_precision', -1 );
        
        $db_data=DB::table('mst_fed_coordinates')
        ->leftjoin('mst_fed_local_level','mst_fed_local_level.code','mst_fed_coordinates.code')
        ->where([['mst_fed_coordinates.level',2],['mst_fed_local_level.district_id',$request->id]])->get();

        $to_return_array=[];
        $to_return_array['type']='FeatureCollection';

        $features=[];
        foreach($db_data as $key=> $dt){
            $local_level=DB::table('mst_fed_local_level')->where('code',$dt->code)->first();
            $features_one['type']="Feature";
            $features_one['geometry']['type']="Polygon";
            $features_one['properties']['Locallevel']=$local_level->id;
            $features_one['properties']['TARGET']=$local_level->name_en;
            $features_one['properties']['Level']=2;
            $features_one['properties']['LOCALLEVEL_NAME']=$local_level->name_en;

            // string geo point to array
            $exploded_array=explode("],",$dt->coordinates);
            $formatted_gis_data=[];
            $remove_arr=array("[","]");
            foreach($exploded_array as $ea){
                $lat_long=explode(",",$ea);
                $lat=floatval(str_replace($remove_arr,"", $lat_long[0]));
                $long=floatval($lat_long[1]);
                array_push($formatted_gis_data,[$lat,$long]);
            }
            $features_one['geometry']['coordinates']=[$formatted_gis_data];

            array_push($features,$features_one);
        }
        $to_return_array['features']=$features;
        $to_return_array=json_encode($to_return_array);
        return response()->json($to_return_array);

    }

    /**
     * project data on click
     */
    public function getMembersData(Request $request)
    {

        $level = $request->level;
        $province_clause = '1=1';
        $district_clause = '1=1';
        $local_level_clause = '1=1';

        if($level == '0'){
            $province_clause = 'm.province_id='.$request->area_id;
        }else if($level == '1'){
            $district_clause = 'mfd.id='.$request->area_id;
        }else if($level == '2'){
            $local_level_clause = 'mfll.id='.$request->area_id;
        }

        $members =  DB::table('members as m')
                        ->join('mst_fed_district as mfd', 'm.district_id','mfd.id')
                        ->join('mst_fed_province as mfp','m.province_id','mfp.id')
                        ->join('mst_fed_local_level as mfll','m.local_level_id','mfll.id')
                        ->join('mst_gender as mg','m.gender_id','mg.id')
                        ->select('m.id','mfp.name_en as province','mfd.name_en as district','m.full_name','mg.name_en as gender',
                        'mfll.gps_lat as lat','mfll.gps_long as long')
                        ->whereRaw($province_clause)
                        ->whereRaw($district_clause)
                        ->whereRaw($local_level_clause)
                        ->where('m.status',3)
                        ->get();

        $members = json_encode($members);

        return response()->json($members);
    }


    /**
     * getting data according to level
     */
    public function getGeoData(Request $request){

        $data=[];
        if($request->level=="-1"){
            $data=$this->getNepalGeoData($request);
        }
        else if($request->level=="0"){
            $data=$this->getProvinceGeoData($request);
        }
        else if($request->level=="1"){
            $data=$this->getDistrictGeoData($request);
        }
        else if($request->level=="2"){
            $data=$this->getLocalLevelGeoData($request);
        }
        else {
            $data=[];
        }
        return response()->json($data);
    }

    //get nepal data
    public function getNepalGeoData($request)
    {
        $data['level'] = -1;


        $districts =DB::table('mst_fed_local_level')->distinct('district_id')->pluck('district_id');
        $local_level=DB::table('mst_fed_local_level')->whereIn('district_id',$districts)->pluck('level_type_id')->toArray();
        $count = array_count_values($local_level);

        //count of districts, Metro/Sub-metro/Rural Mun
        $data['count']['districts_count']=$districts->count();
        $data['count']['rural_mun_count']=$count[1];
        $data['count']['mun_count']=$count[2];
        $data['count']['sub_metro_count']=array_key_exists(3,$count)?$count[3]:0;
        $data['count']['metro_count']=array_key_exists(4,$count)?$count[4]:0;
        $data['count']['total_local_level_count']=count($local_level);

        return $data;
    }

    //get Province Data
    public function getProvinceGeoData($request)
    {
        $province_id = $request->id;
        $data['level'] = 0;

        $districts =DB::table('mst_fed_district')->whereProvinceId($province_id)->pluck('id');


        $local_level=DB::table('mst_fed_local_level')->whereIn('district_id',$districts)->pluck('level_type_id')->toArray();
        $count = array_count_values($local_level);

        //count of districts, Metro/Sub-metro/Rural Mun
        $data['count']['districts_count']=$districts->count();
        $data['count']['rural_mun_count']=$count[1];
        $data['count']['mun_count']=$count[2];
        $data['count']['sub_metro_count']=array_key_exists(3,$count)?$count[3]:0;
        $data['count']['metro_count']=array_key_exists(4,$count)?$count[4]:0;
        $data['count']['total_local_level_count']=count($local_level);

        return $data;
    }

    //get District Data
    public function getDistrictGeoData($request)
    {
        $district_id = $request->id;
        $data['level'] = 1;


        $local_level=DB::table('mst_fed_local_level')->where('district_id',$district_id)->pluck('level_type_id')->toArray();
        $count = array_count_values($local_level);

        //count of districts, Metro/Sub-metro/Rural Mun
        $data['count']['rural_mun_count']=$count[1];
        $data['count']['mun_count']=array_key_exists(2,$count)?$count[2]:0;
        $data['count']['sub_metro_count']=array_key_exists(3,$count)?$count[3]:0;
        $data['count']['metro_count']=array_key_exists(4,$count)?$count[4]:0;
        $data['count']['total_local_level_count']=count($local_level);
        return $data;
    }
    //get District Data
    public function getLocalLevelGeoData($request)
    {
       $data = [];  

        return $data;
    }

}