<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class MstSchoolRequest extends FormRequest
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
            'province_id'=>'required',
            'district_id'=>'required',
            'local_level_id'=>'required',
            'name_lc'=>'required|max:200|unique:mst_schools,name_lc'.$id_check,
            'name_en'=>'max:200|unique:mst_schools,name_en'.$id_check,
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
            'name_lc.unique'=>trans('validationMessage.name_lc'),
            'name_lc.required'=>'School Name(Nepali) is required !',
        ];
    }
}
