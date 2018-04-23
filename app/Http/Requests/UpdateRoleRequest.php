<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $roleEdit = !empty($this->role) ? $this->role->id : "";

        $validateArr = array(
            'name' => 'required|string|max:190|unique:roles,name',
            'weight' => 'required|integer|min:1|unique:roles,weight'
        );
        if (!empty($roleEdit)) {
            $validateArr['name'] .= ",$roleEdit";
            $validateArr['weight'] .= ",$roleEdit";
        }

        return $validateArr;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => __('role.name_required'),
            'name.string' => __('role.name_string'),
            'name.max' => __('role.name_max', array("number" => 190)),
            'name.unique' => __('role.name_unique'),
            'weight.required' => __('role.weight_required'),
            'weight.integer' => __('role.weight_string'),
            'weight.min' => __('role.weight_min', array("number" => 1)),
            'weight.unique' => __('role.weight_unique')
        ];
    }
}
