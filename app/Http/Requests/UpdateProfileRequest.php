<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
        $request = request();
        $validateArr = array();

        if ($request->isMethod('post')) {
            $currentUser = getCurrentUser();

            $validateArr = array(
                'name' => 'required|string|max:190|unique:users,name,' . $currentUser->id,
                'password' => 'nullable|string|max:50|confirmed'
            );
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
            'name.required' => __('user.name_required'),
            'name.string' => __('user.name_string'),
            'name.max' => __('user.name_max', array("number" => 190)),
            'name.unique' => __('user.name_unique'),
            'password.string' => __('user.password_string'),
            'password.max' => __('user.password_max', array("number" => 50)),
            'password.confirmed' => __('user.password_confirmed')
        ];
    }
}
