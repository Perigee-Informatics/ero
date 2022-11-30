<?php

namespace App\Http\Controllers\Admin;

use App\Models\MstClass;
use App\Models\MstSchool;
use App\Models\MstQuestion;
use App\Models\QuestionGroup;
use App\Models\ReviewProfile;
use App\Models\MstSubQuestion;
use App\Base\BaseCrudController;
use App\Models\MstQuestionOption;
use App\Models\WorkAssigneeMaster;
use Illuminate\Support\Facades\DB;
use Prologue\Alerts\Facades\Alert;
use App\Http\Requests\MstQuestionRequest;
use App\Models\MstGender;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class MstQuestionCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class MstQuestionCrudController extends BaseCrudController
{
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(MstQuestion::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/mstquestion');
        CRUD::setEntityNameStrings('Question Master', 'Question Master');

        $this->data['script_js'] = $this->getScriptJs();
    }

    public function getScriptJs()
    {
        return "
            $(document).ready(function(){
                hideOrShowSub();
                hideOrShowOptions();

                function hideOrShowSub(){
                    if($('#has_sub_questions').is(':checked')){
                        $('#sub_questions_row').show();
                    }else{
                        $('#sub_questions_row').hide();
                    }
                }
                function hideOrShowOptions(){
                    if($('#has_options').is(':checked')){
                        $('#options_row').show();
                    }else{
                        $('#options_row').hide();
                    }
                }

             $('#has_sub_questions').change(function(){
                hideOrShowSub();
             });

             $('#has_options').change(function(){
                hideOrShowOptions();
             });
            });
        ";
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
            $this->addRowNumberColumn(),
            [
                'name'=>'review_profile_id',
                'type'=>'select',
                'label'=>trans('Review Profile'),
                'entity'=>'reviewProfileEntity',
                'model'=>ReviewProfile::class,
                'attribute'=>'program_name_lc',
            ],
            [
                'name'=>'subject',
                'type'=>'select_from_array',
                'label'=>trans('Subject'),
                'options'=>MstClass::$subjects,
            ],
            [
                'name'=>'class_id',
                'type'=>'select',
                'label'=>trans('Class'),
                'entity'=>'classEntity',
                'model'=>MstClass::class,
                'attribute'=>'code',
            ],
       
            [
                'name'=>'group_id',
                'type'=>'select',
                'label'=>trans('Question Group'),
                'entity'=>'groupEntity',
                'model'=>QuestionGroup::class,
                'attribute'=>'title_lc',
            ],
         
            [
                'name'=>'question_no',
                'type'=>'text',
                'label'=>trans('Question no.'),
            ],
            [
                'name'=>'title',
                'type'=>'textarea',
                'label'=>trans('Question'),
            ],
            [
                'name'=>'has_sub_questions',
                'type'=>'radio',
                'label'=>trans('Sub-questions'),
                'options'=>[
                    true=>'Yes',
                    false=>'No',
                ],
            ],
            [
                'name'=>'has_options',
                'type'=>'radio',
                'label'=>trans('Options'),
                'options'=>[
                    true=>'Yes',
                    false=>'No',
                ],
            ],
            [
                'name'=>'allow_multiple_options',
                'type'=>'check',
                'label'=>trans('Allow multiple option selection'),
            ],
            [
                'name'=>'is_evaluation_type',
                'type'=>'check',
                'label'=>trans('Evaluation Type Question'),
            ],
            $this->addDisplayOrderColumn(),
        ];

        $this->crud->addColumns(array_filter($arr));
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(MstQuestionRequest::class);

        $arr = [
            [
                'name'=>'review_profile_id',
                'type'=>'select2',
                'label'=>trans('Review Profile'),
                'entity'=>'reviewProfileEntity',
                'model'=>ReviewProfile::class,
                'attribute'=>'program_name_lc',
                'attributes'=>[
                    'required' => 'required',
                ],
                'wrapper' => [
                    'class' => 'form-group col-md-6',
                ],
            ],
            [
                'name'=>'subject',
                'type'=>'select_from_array',
                'label'=>trans('Subject'),
                'options'=>MstClass::$subjects,
                'attributes'=>[
                    'required' => 'required',
                ],
                'wrapper' => [
                    'class' => 'form-group col-md-6',
                ],
            ],
       
            [
                'name'=>'class_id',
                'type'=>'select2',
                'label'=>trans('Class'),
                'entity'=>'classEntity',
                'model'=>MstClass::class,
                'attribute'=>'code',
                'attributes'=>[
                    'required' => 'required',
                ],
                'wrapper' => [
                    'class' => 'form-group col-md-4',
                ],
            ],
            [
                'name'=>'group_id',
                'type'=>'select2',
                'label'=>trans('Question Group'),
                'entity'=>'groupEntity',
                'model'=>QuestionGroup::class,
                'attribute'=>'title_lc',
                'attributes'=>[
                    'required' => 'required',
                ],
                'wrapper' => [
                    'class' => 'form-group col-md-4',
                ],
            ],
           
            [
                'name'=>'question_no',
                'type'=>'number',
                'label'=>trans('Question no.'),
                'attributes'=>[
                    'required' => 'required',
                ],
                'wrapper' => [
                    'class' => 'form-group col-md-4',
                ],
            ],
            [
                'name'=>'title',
                'type'=>'textarea',
                'label'=>trans('Question'),
                'attributes'=>[
                    'required' => 'required',
                    'rows'=>2
                ],
                'wrapper' => [
                    'class' => 'form-group col-md-12',
                ],
            ],
            [
                'name'=>'allow_multiple_options',
                'type'=>'checkbox',
                'label'=>trans('<b>&nbsp;Allow multiple option selection.</b>'),
                'attributes'=>[
                    'id'=>'allow_multiple_options'
                ],
                'wrapper' => [
                    'class' => 'form-group col-md-6',
                ],
            ],
            [
                'name'=>'is_evaluation_type',
                'type'=>'checkbox',
                'label'=>trans('<b>&nbsp;Evaluation Type Question</b>'),
                'attributes'=>[
                    'id'=>'is_evaluation_type'
                ],
                'wrapper' => [
                    'class' => 'form-group col-md-6',
                ],
            ],
            [
                'name'=>'custom_html_1',
                'type'=>'custom_html',
                'value'=>'<hr/>'
            ],

            [
                'name'=>'has_sub_questions',
                'type'=>'checkbox',
                'label'=>trans('<b class="text-primary">&nbsp; ADD SUB-QUESTIONS</b>'),
                'attributes'=>[
                    'id'=>'has_sub_questions'
                ],
            ],
            [
                'name'=>'sub_questions',
                'type'=>'custom.sub_questions',
            ],
            [
                'name'=>'custom_html_2',
                'type'=>'custom_html',
                'value'=>'<hr/>'
            ],
            [
                'name'=>'has_options',
                'type'=>'checkbox',
                'label'=>trans('<b class="text-primary">&nbsp;ADD OPTIONS</b>'),
                'attributes'=>[
                    'id'=>'has_options'
                ],
            ],
            [
                'name'=>'options',
                'type'=>'custom.options',
            ],
            $this->addDisplayOrderField(),
            
        ];

        $this->crud->addFields(array_filter($arr));
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

    public function store()
    {
        $this->crud->hasAccessOrFail('create');

        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();

        DB::beginTransaction();
        try { 

            // insert item in the db
            $item = $this->crud->create($this->crud->getStrippedSaveRequest());
            $this->data['entry'] = $this->crud->entry = $item;
            if($item){
                if($request->has_sub_questions == '1' && isset($request->sub_questions)){
                    foreach($request->sub_questions as $q){
                        if($q !=''){
                        MstSubQuestion::create(['question_id'=>$item->id,'title'=>$q]);
                        }
                    }
                }
                if($request->has_options == '1' && isset($request->options)){
                    foreach($request->options as $q){
                        if($q !=''){
                        MstQuestionOption::create(['question_id'=>$item->id,'title'=>$q]);
                        }
                    }
                }
            }

            // show a success message
            \Alert::success(trans('backpack::crud.insert_success'))->flash();

            // save the redirect choice for next time
            $this->crud->setSaveAction();

            DB::commit();

        } catch (\Throwable $th) {
            dd($th);
            DB::rollback();
        }

        return $this->crud->performSaveAction($item->getKey());
    }

    public function update()
    {
        $this->crud->hasAccessOrFail('update');

        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();
        DB::beginTransaction();
        try { 
            $item = $this->crud->update($request->get($this->crud->model->getKeyName()),$this->crud->getStrippedSaveRequest());
            $this->data['entry'] = $this->crud->entry = $item;
            if($item){
                if(isset($request->sub_questions)){
                    $insert_skeys = [];
                    foreach($request->sub_questions['serial'] as $key=>$q){
                        if($request->sub_questions['title'][$key] !=''){
                            $insert_skeys[]=$key;
                            MstSubQuestion::updateOrCreate(
                                ['id'=>$key,'serial'=>$request->sub_questions['serial'][$key]],
                                ['question_id'=>$item->id,'serial'=>$request->sub_questions['serial'][$key],'title'=>$request->sub_questions['title'][$key],'display_order'=>$request->sub_questions['display_order'][$key]]);
                        }
                    }
                    MstSubQuestion::where('question_id',$item->id)->whereNotIn('id',$insert_skeys)->delete();
                }
                if(isset($request->options)){
                    $insert_okeys = [];
                    foreach($request->options['serial'] as $key=>$q){
                        if($request->options['title'][$key] !=''){
                            $insert_okeys[]=$key;
                            MstQuestionOption::updateOrCreate(
                                ['id'=>$key,'serial'=>$request->options['serial'][$key]],
                                ['question_id'=>$item->id,'serial'=>$request->options['serial'][$key],'title'=>$request->options['title'][$key],'display_order'=>$request->options['display_order'][$key]]);
                        }
                    }
                    MstQuestionOption::where('question_id',$item->id)->whereNotIn('id',$insert_okeys)->delete();
                }
            }
            // show a success message
            \Alert::success(trans('backpack::crud.update_success'))->flash();

            // save the redirect choice for next time
            $this->crud->setSaveAction();

            DB::commit();

        } catch (\Throwable $th) {
            dd($th);
            DB::rollback();
        }

        return $this->crud->performSaveAction($item->getKey());
    }

    //list questions
    public function questionsLists()
    {
        $data=[];
        if(backpack_user()->hasAnyRole('superadmin|admin') == false){
            $data['question_lists'] = WorkAssigneeMaster::select('review_profile_id','subject','school_id','class_id')
                                                    ->where('assigned_to',backpack_user()->id)
                                                    ->groupBy('review_profile_id')
                                                    ->groupBy('school_id')
                                                    ->groupBy('class_id')
                                                    ->groupBy('subject')
                                                    ->get();
        }else{
            $data['question_lists'] = WorkAssigneeMaster::select('review_profile_id','subject','class_id')
                                                    ->groupBy('review_profile_id')
                                                    ->groupBy('class_id')
                                                    ->groupBy('subject')
                                                    ->get();
        }
        return view('admin.questions_lists',$data);
    }

    public function prepareSheet($program_id,$school_id,$subject,$class_id)
    {
        $data['program_name'] = ReviewProfile::find($program_id)->program_name_lc;
        $data['school_name'] = MstSchool::find($school_id)->name_lc;
        $data['subject_name'] = MstClass::$subjects[$subject];
        $data['class'] = MstClass::find($class_id)->code;
        $data['gender'] = MstGender::all();
        $questions = MstQuestion::where('review_profile_id',$program_id)
                                    ->where('subject',$subject)
                                    ->where('class_id',$class_id)
                                    ->orderby('display_order')
                                    ->get();
        $groups_order = QuestionGroup::orderby('display_order')->get()->pluck('title_lc')->toArray();                            
        $question_groups = [];
        $question_groups_temp = [];
        foreach($questions as $qs)
        {
            $question_groups_temp[$qs->groupEntity->title_lc][] =$qs;
        }
         // for ordering group wise data                
        foreach($groups_order as $go){
         if(array_key_exists($go,$question_groups_temp)){
            $question_groups[$go]=$question_groups_temp[$go];
         }
        }
        $data['question_groups'] =$question_groups;

        return view('admin.answer-sheet-entry',$data);

    }
}
