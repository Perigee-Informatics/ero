<?php

namespace App\Http\Controllers\Admin;

use App\Models\MstYear;
use App\Models\ReviewProfile;
use App\Base\BaseCrudController;
use App\Http\Requests\ReviewProfileRequest;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ReviewProfileCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ReviewProfileCrudController extends BaseCrudController
{
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(ReviewProfile::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/reviewprofile');
        CRUD::setEntityNameStrings('Review Profile Master', 'Review Profile Master');
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
            $this->addCodeField(),
            [
                'name' => 'program_name_lc',
                'label' => trans('Program Name (Nepali)'),
                'type' => 'text',
            ],
            [
                'name'=>'program_year',
                'type'=>'select',
                'label'=>trans('Program Year'),
                'entity'=>'yearEntity',
                'model'=>MstYear::class,
                'attribute'=>'code',
            ],
            [
                'label' => trans('Exam Duration'),
                'type' => 'text',
                'name' => 'exam_duration',
            ],
        ];

        $this->crud->addColumns(\array_filter($arr));
        
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ReviewProfileRequest::class);

        $arr = [
            $this->addCodeField(),
            $this->addPlainHtml(),
            [
                'name' => 'program_name_lc',
                'label' => trans('Program Name (Nepali)'),
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
                'name' => 'program_name_en',
                'label' => trans('Program Name (English)'),
                'type' => 'text',
                'attributes'=>[
                    'max-length'=>200,
                ],
                'wrapper' => [
                    'class' => 'form-group col-md-6',
                ],
            ],
            [
                'name'=>'program_year',
                'type'=>'select2',
                'label'=>trans('Program Year'),
                'entity'=>'yearEntity',
                'model'=>MstYear::class,
                'attribute'=>'code',
                'attributes'=>[
                    'required' => 'required',
                ],
                'wrapper' => [
                    'class' => 'form-group col-md-4',
                ],
            ],
            [
                'label' => trans('Exam Duration'),
                'type' => 'number',
                'name' => 'exam_duration',
                'wrapper' => [
                    'class' => 'form-group col-md-4'
                ],
                'default'=>0,
            ],
        ];

        $this->crud->addFields(\array_filter($arr));
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
