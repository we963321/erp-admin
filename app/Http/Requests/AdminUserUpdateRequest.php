<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AdminUserUpdateRequest extends Request
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
            'name'      => 'required|unique:admin_users,name,' . $this->get('id') . '|max:255',
            'email'     => 'required|email|unique:admin_users,email,' . $this->get('id') . '|max:255',
            'password'  => 'confirmed|min:6|max:50',
            'mobile'    => 'required|unique:admin_users,mobile,' . $this->get('id') . '|min:10|max:10',
            'id_number' => 'required|unique:admin_users,id_number,' . $this->get('id') . '|min:10|max:10',
            'birthday'  => 'required|min:10|max:10',
            'status'    => 'required|in:0,1',
            //'roles'     => 'required',
        ];
    }
}
