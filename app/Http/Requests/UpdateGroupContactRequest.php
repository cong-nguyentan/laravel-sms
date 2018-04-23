<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\GroupContact;

class UpdateGroupContactRequest extends FormRequest
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
        $validateArr = array(
            'name' => 'required|string|max:190',
            'description' => 'required|string'
        );

        return $validateArr;
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $groupContactEdit = !empty($this->group_contact) ? $this->group_contact : "";
        $that = $this;

        $validator->after(function ($validator) use($groupContactEdit, $that) {

            $request = request();

            if (!$that->_checkGroupContactUnique($request->name, $groupContactEdit)) {
                $validator->errors()->add('contact_unique', __('group_contact.unique'));
            }

        });
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => __('group_contact.name_required'),
            'name.string' => __('group_contact.name_string'),
            'name.max' => __('group_contact.name_max', array("number" => 190)),
            'description.required' => __('group_contact.description_required'),
            'description.string' => __('group_contact.description_string')
        ];
    }

    private function _checkGroupContactUnique($name, $groupContactEdit = false, $userCreate = false)
    {
        $userLogged = getCurrentUser();
        if (!empty($groupContactEdit)) {
            $userCreate = $groupContactEdit->user_id;
        } elseif (empty($userCreate)) {
            $userCreate = $userLogged->id;
        }

        $checkExisted = GroupContact::where(array(
            'user_id' => $userCreate,
            'name' => $name
        ));

        if (!empty($groupContactEdit)) {
            $checkExisted = $checkExisted->where("id", "<>", $groupContactEdit->id);
        }

        $checkExisted = $checkExisted->get();

        return $checkExisted->isEmpty();
    }
}
