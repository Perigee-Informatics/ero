<?php

namespace App\Http\Controllers\Admin;

use App\Models\MstQuestion;
use App\Models\QuestionGroup;
use App\Models\ReviewProfile;
use App\Base\BaseCrudController;
use Illuminate\Support\Facades\DB;
use Prologue\Alerts\Facades\Alert;
use App\Http\Requests\MstQuestionRequest;
use App\Models\MstQuestionOption;
use App\Models\MstSubQuestion;
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
                    'class' => 'form-group col-md-5',
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
                    'class' => 'form-group col-md-3',
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
                'name'=>'has_sub_questions',
                'type'=>'checkbox',
                'label'=>trans('<b>&nbsp;Has Sub-questions ?</b>'),
                'attributes'=>[
                    'id'=>'has_sub_questions'
                ],
            ],
            [
                'name'=>'sub_questions',
                'type'=>'custom.sub_questions',
            ],
            [
                'name'=>'has_options',
                'type'=>'checkbox',
                'label'=>trans('<b>&nbsp;Has Options ?</b>'),
                'attributes'=>[
                    'id'=>'has_options'
                ],
            ],
            [
                'name'=>'options',
                'type'=>'custom.options',
            ],
            
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
                    foreach($request->sub_questions as $key=>$q){
                        if($q !=''){
                            MstSubQuestion::updateOrCreate(['id'=>$key],['question_id'=>$item->id,'title'=>$q]);
                        }
                    }
                }
                if(isset($request->options)){
                    foreach($request->options as $key=>$q){
                        if($q !=''){
                            MstQuestionOption::updateOrCreate(['id'=>$key],['question_id'=>$item->id,'title'=>$q]);
                        }
                    }
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
}
