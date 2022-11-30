<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class QuestionGroupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id_check = $this->request->get('id') ? ",".$this->request->get('id') : "";
        return [
            'code'=>'max:20',
            'title_lc'=>'required|max:200|unique:question_groups,title_lc'.$id_check,
            'title_en'=>'max:200|unique:question_groups,title_en'.$id_check,
            'display_order'=>'required',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title_en.unique'=> trans('validationMessage.name_en'),
            'title_lc.unique'=>trans('validationMessage.name_lc'),
            'title_lc.required'=>'Title(Nepali) is required !!',
        ];
    }
}
