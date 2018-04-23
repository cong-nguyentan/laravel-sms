<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Acl;

class UpdateAclRequest extends FormRequest
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
        return [
            'permission_id' => 'required|integer|min:1|exists:permissions,id',
            'controller' => 'required|string|max:190',
            'action' => 'required|string|max:190'
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $aclEdit = !empty($this->acl) ? $this->acl->id : "";

        $validator->after(function ($validator) use($aclEdit) {
            $request = request();

            $checkExisted = Acl::where(array(
                'controller' => $request->controller,
                'action' => $request->action
            ));
            if (!empty($aclEdit)) {
                $checkExisted = $checkExisted->where("id", "<>", $aclEdit);
            }
            $checkExisted = $checkExisted->get();

            if (!$checkExisted->isEmpty()) {
                $validator->errors()->add('controller_action', __('acl.controller_action_unique'));
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
            'permission_id.required' => __('acl.permission_required'),
            'permission_id.integer'  => __('acl.permission_integer'),
            'permission_id.min' => __('acl.permission_min', array("number" => 1)),
            'permission_id.exists'  => __('acl.permission_exists'),
            'controller.required' => __('acl.controller_required'),
            'controller.string' => __('acl.controller_string'),
            'controller.max' => __('acl.controller_max', array("number" => 190)),
            'action.required' => __('acl.action_required'),
            'action.string' => __('acl.action_string'),
            'action.max' => __('acl.action_max', array("number" => 190))
        ];
    }
}
