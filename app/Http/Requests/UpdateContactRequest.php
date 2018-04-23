<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Contact;

class UpdateContactRequest extends FormRequest
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
            'phone' => array(
                'required',
                'max:20',
                'phone'
            ),
            'groups' => 'nullable|array',
            'groups.*' => 'integer|distinct|exists:group_contacts,id'
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
        $contactEdit = !empty($this->contact) ? $this->contact : "";
        $that = $this;

        $validator->after(function ($validator) use($contactEdit, $that) {

            $request = request();

            if (!$that->_checkContactUnique($request->phone, $contactEdit)) {
                $validator->errors()->add('contact_unique', __('contact.contact_unique'));
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
            'name.required' => __('contact.name_required'),
            'name.string' => __('contact.name_string'),
            'name.max' => __('contact.name_max', array("number" => 190)),
            'phone.required' => __('contact.phone_required'),
            'phone.max' => __('contact.phone_max', array("number" => 20)),
            'phone.phone' => __('contact.phone_numeric'),
            'groups.array' => __('contact.groups_array'),
            'groups.*.integer' => __('contact.groups_integer'),
            'groups.*.distinct' => __('contact.groups_distinct'),
            'groups.*.exists' => __('contact.groups_exists')
        ];
    }

    public function validateContactUnique($dataValidate)
    {
        $uniqueCheck = $this->_checkContactUnique($dataValidate['phone'], $dataValidate['id']);
        return $uniqueCheck ? "" : __('contact.contact_unique');
    }

    private function _checkContactUnique($phone, $contactEdit = false, $userCreate = false)
    {
        $userLogged = getCurrentUser();
        if (!empty($contactEdit)) {
            $userCreate = $contactEdit->user_id;
        } elseif (empty($userCreate)) {
            $userCreate = $userLogged->id;
        }

        $checkExisted = Contact::where(array(
            'user_id' => $userCreate,
            'phone' => $phone
        ));

        if (!empty($contactEdit)) {
            $checkExisted = $checkExisted->where("id", "<>", $contactEdit->id);
        }

        $checkExisted = $checkExisted->get();

        return $checkExisted->isEmpty();
    }
}
