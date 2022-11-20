<?php

namespace App\Http\Controllers\Admin;

use App\Models\MstSchool;
use App\Models\MstFedDistrict;
use App\Models\MstFedProvince;
use App\Base\BaseCrudController;
use App\Models\MstFedLocalLevel;
use App\Http\Requests\MstSchoolRequest;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class MstSchoolCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class MstSchoolCrudController extends BaseCrudController
{
    public function setup()
    {
        CRUD::setModel(MstSchool::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/mstschool');
        CRUD::setEntityNameStrings('Schools', 'Schools');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $arr = [
            $this->addCodeColumn(),
            [
                'name'=>'province_id',
                'type'=>'select',
                'label'=>trans('Province'),
                'entity'=>'provinceEntity',
                'model'=>MstFedProvince::class,
                'attribute'=>'name_en',
            ],
            [
                'name'=>'district_id',
                'label'=>trans('District'),
                'type'=>'select',
                'model'=>MstFedDistrict::class,
                'entity'=>'districtEntity',
                'attribute'=>'name_en',
            ],
            [
                'name'=>'local_level_id',
                'label'=>trans('Local Level'),
                'type'=>'select',
                'model'=>MstFedLocalLevel::class,
                'entity'=>'localLevelEntity',
                'attribute'=>'name_en',
            ],
            [
                'name' => 'name_lc',
                'label' => trans('School Name'),
                'type' => 'text',
            ],
            [
                'label' => trans('fedLocalLevel.gps_lat'),
                'type' => 'text',
                'name' => 'gps_lat',
            ],
            [
                'label' => trans('fedLocalLevel.gps_long'),
                'type' => 'text',
                'name' => 'gps_long',
            ],
            $this->addDisplayOrderColumn(),
        ];
        $arr = array_filter($arr);
        $this->crud->addColumns($arr);

    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(MstSchoolRequest::class);
        $arr = [
            $this->addCodeField(),
            $this->addPlainHtml(),
            [
                'name'=>'province_id',
                'type'=>'select2',
                'label'=>trans('Province'),
                'entity'=>'provinceEntity',
                'model'=>MstFedProvince::class,
                'attribute'=>'name_en',
                'attributes'=>[
                    'required' => 'required',
                ],
                'wrapper' => [
                    'class' => 'form-group col-md-4',
                ],
            ],
            [
                'name'=>'district_id',
                'label'=>trans('District'),
                'type'=>'select2_from_ajax',
                'model'=>MstFedDistrict::class,
                'entity'=>'districtEntity',
                'attribute'=>'name_en',
                'data_source' => url("api/district/province_id"),
                'placeholder' => "Select District",
                'minimum_input_length' => 0,
                'dependencies'         => ['province_id'],
                'include_all_form_fields'=>true,
                'method'=>'POST',
                'wrapper' => [
                    'class' => 'form-group col-md-4',
                ],
                'attributes'=>[
                    'required' => 'required',
                ],
            ],
            [
                'name'=>'local_level_id',
                'label'=>trans('Local Level'),
                'type'=>'select2_from_ajax',
                'model'=>MstFedLocalLevel::class,
                'entity'=>'localLevelEntity',
                'attribute'=>'name_en',
                'data_source' => url("api/locallevel/district_id"),
                'placeholder' => "Select Local Level",
                'minimum_input_length' => 0,
                'dependencies'         => ['district_id'],
                'include_all_form_fields'=>true,
                'method'=>'POST',
                'wrapper' => [
                    'class' => 'form-group col-md-4',
                ],
                'attributes'=>[
                    'required' => 'required',
                ],
            ],
            [
                'name' => 'name_lc',
                'label' => trans('School Name (Nepali)'),
                'type' => 'text',
                'attributes'=>[
                    'required' => 'required',
                    'max-length'=>200,
                ],
                'wrapper' => [
                    'class' => 'form-group col-md-6',
                ],
            ],
            [
                'name' => 'name_en',
                'label' => trans('School Name (English)'),
                'type' => 'text',
                'attributes'=>[
                    'max-length'=>200,
                ],
                'wrapper' => [
                    'class' => 'form-group col-md-6',
                ],
            ],
            [
                'label' => trans('fedLocalLevel.gps_lat'),
                'type' => 'text',
                'name' => 'gps_lat',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4'
                ],
            ],
            [
                'label' => trans('fedLocalLevel.gps_long'),
                'type' => 'text',
                'name' => 'gps_long',
                'wrapper' => [
                    'class' => 'form-group col-md-4'
                ],
            ],
            $this->addDisplayOrderField(),
        ];
        $arr = array_filter($arr);
        $this->crud->addFields($arr);
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
