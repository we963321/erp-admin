<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserCreateRequest extends Request
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
            'name'      => 'required|max:255',
            'email'     => 'required|unique:users|email|max:255',
            'password'  => 'required|confirmed|min:6|max:50',
            'sex'       => 'required|in:0,1',
            'mobile'    => 'required|unique:users|min:10|max:10',
            'id_number' => 'required|unique:users|min:10|max:10',
            'birthday'  => 'required|min:10|max:10',
            'counties'  => 'required',
            'town'      => 'required',
            'marriage'  => 'required|in:0,1',
        ];
    }
}
