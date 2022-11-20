<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class ReviewProfileRequest extends FormRequest
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
            'program_year'=>'required',
            'exam_duration'=>'required',
            'program_name_lc'=>'required|max:200|unique:review_profile_master,program_name_lc'.$id_check,
            'program_name_en'=>'max:200|unique:review_profile_master,program_name_en'.$id_check,
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
            'program_name_lc.unique'=>trans('validationMessage.name_lc'),
            'program_name_lc.required'=>'School Name(Nepali) is required !',
            'program_year.required'=>'Program Year is required !',
            'exam_duration.required'=>'Exam duration is required !',
        ];
    }
}
