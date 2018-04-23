<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePermissionRequest extends FormRequest
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
        $permissionEdit = !empty($this->permission) ? $this->permission->id : "";

        $validateArr = array(
            'name' => 'required|string|max:190|unique:permissions,name'
        );
        if (!empty($permissionEdit)) {
            $validateArr['name'] .= ",$permissionEdit";
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
            'name.required' => __('permission.name_required'),
            'name.string' => __('permission.name_string'),
            'name.max' => __('permission.name_max', array("number" => 190)),
            'name.unique' => __('permission.name_unique')
        ];
    }
}
