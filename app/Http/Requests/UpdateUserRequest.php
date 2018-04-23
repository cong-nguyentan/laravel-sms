<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        $userEdit = !empty($this->user) ? $this->user->id : "";

        $validateArr = array(
            'name' => 'required|string|max:190|unique:users,name',
            'email' => 'required|string|max:190|email|unique:users,email',
            'password' => '',
            'role' => 'required|integer|min:1|exists:roles,id'
        );
        if (!empty($userEdit)) {
            $validateArr['name'] .= ",$userEdit";
            $validateArr['email'] .= ",$userEdit";
            $validateArr['password'] = 'nullable';
        } else {
            $validateArr['password'] = 'required';
        }
        $validateArr['password'] .= '|string|max:50|confirmed';

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
            'name.required' => __('user.name_required'),
            'name.string' => __('user.name_string'),
            'name.max' => __('user.name_max', array("number" => 190)),
            'name.unique' => __('user.name_unique'),
            'email.required' => __('user.email_required'),
            'email.string' => __('user.email_string'),
            'email.max' => __('user.email_max', array("number" => 190)),
            'email.email' => __('user.email_invalid'),
            'email.unique' => __('user.email_unique'),
            'password.required' => __('user.password_required'),
            'password.string' => __('user.password_string'),
            'password.max' => __('user.password_max', array("number" => 50)),
            'password.confirmed' => __('user.password_confirmed'),
            'role.required' => __('user.role_required'),
            'role.integer' => __('user.role_integer'),
            'role.min' => __('user.role_min', array("number" => 1)),
            'role.exists' => __('user.role_exists')
        ];
    }
}
