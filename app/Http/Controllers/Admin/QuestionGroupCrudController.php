<?php

namespace App\Http\Controllers\Admin;

use App\Models\QuestionGroup;
use App\Base\BaseCrudController;
use App\Http\Requests\QuestionGroupRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class QuestionGroupCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class QuestionGroupCrudController extends BaseCrudController
{
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(QuestionGroup::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/questiongroup');
        CRUD::setEntityNameStrings('Question Groups', 'Question Groups');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $cols=[
            $this->addRowNumberColumn(),
            [
                'name' => 'title_lc',
                'label' => trans('Title (Nepali)'),
                'type' => 'text',
            ],
            [
                'name' => 'title_en',
                'label' => trans('Title (English)'),
                'type' => 'text',
            ],
        ];
        $this->crud->addColumns($cols);
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(QuestionGroupRequest::class);

        $arr = [
            [
                'name' => 'title_lc',
                'label' => trans('Title (Nepali)'),
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
                'name' => 'title_en',
                'label' => trans('Title (English)'),
                'type' => 'text',
                'attributes'=>[
                    'max-length'=>200,
                ],
                'wrapper' => [
                    'class' => 'form-group col-md-6',
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
