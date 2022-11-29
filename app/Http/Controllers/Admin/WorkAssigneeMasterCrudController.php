<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\MstClass;
use App\Models\MstSchool;
use App\Models\ReviewProfile;
use App\Base\BaseCrudController;
use App\Models\WorkAssigneeMaster;
use App\Http\Requests\WorkAssigneeMasterRequest;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class WorkAssigneeMasterCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class WorkAssigneeMasterCrudController extends BaseCrudController
{

    public function setup()
    {
        CRUD::setModel(WorkAssigneeMaster::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/workassigneemaster');
        CRUD::setEntityNameStrings('Work Assignment Record', 'Work Assignment Record');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $cols = [
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
                'name'=>'school_id',
                'type'=>'select',
                'label'=>trans('School'),
                'entity'=>'schoolEntity',
                'model'=>MstSchool::class,
                'attribute'=>'name_lc',
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
                'label' => trans('No of copies'),
                'type' => 'number',
                'name' => 'no_of_copies',
            ],
            [
                'label' => trans('Date Time'),
                'type' => 'datetime',
                'name' => 'date_time',
            ],

            [
                'name'=>'assigned_by',
                'type'=>'select',
                'label'=>trans('Assigned By'),
                'entity'=>'assignedByEntity',
                'model'=>User::class,
            ],
            [
                'name'=>'assigned_to',
                'type'=>'select',
                'label'=>trans('Assigned To'),
                'entity'=>'assignedToEntity',
                'model'=>User::class,
            ],

        ];

        $this->crud->addColumns(array_filter($cols));
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(WorkAssigneeMasterRequest::class);

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
                'name'=>'school_id',
                'type'=>'select2',
                'label'=>trans('School'),
                'entity'=>'schoolEntity',
                'model'=>MstSchool::class,
                'attribute'=>'name_lc',
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
                    'class' => 'form-group col-md-4',
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
                'label' => trans('No of copies'),
                'type' => 'number',
                'name' => 'no_of_copies',
                'wrapper' => [
                    'class' => 'form-group col-md-4'
                ],
                'default'=>0,
            ],
            [
                'label' => trans('Date Time'),
                'type' => 'datetime',
                'name' => 'date_time',
                'wrapper' => [
                    'class' => 'form-group col-md-4'
                ],
                'default'=>Carbon::now()->todateTimeString(),
            ],

            [
                'name'=>'assigned_by',
                'type'=>'select2',
                'label'=>trans('Assigned By'),
                'entity'=>'assignedByEntity',
                'model'=>User::class,
                'attribute'=>'name',
                'attributes'=>[
                    'required' => 'required',
                ],
                'wrapper' => [
                    'class' => 'form-group col-md-4',
                ],
            ],
            [
                'name'=>'assigned_to',
                'type'=>'select2',
                'label'=>trans('Assigned To'),
                'entity'=>'assignedToEntity',
                'model'=>User::class,
                'attribute'=>'name',
                'attributes'=>[
                    'required' => 'required',
                ],
                'wrapper' => [
                    'class' => 'form-group col-md-4',
                ],
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
}
