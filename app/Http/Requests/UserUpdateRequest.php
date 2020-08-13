<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserUpdateRequest extends Request
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
        $id = $this->get('id');
        if(empty($id)){
            $id = (int)auth('web')->user()->id;
        }
        return [
            'name'      => 'required|max:255',
            //'email'     => 'required|email|unique:users,email,' . $this->get('id') . '|max:255',
            'password'  => 'confirmed|min:6|max:50',
            'sex'       => 'required|in:0,1',
            'mobile'    => 'required|unique:users,mobile,' . $id . '|min:10|max:10',
            'id_number' => 'required|unique:users,id_number,' . $id . '|min:10|max:10',
            'birthday'  => 'required|min:10|max:10',
            'counties'  => 'required',
            'town'      => 'required',
            'marriage'  => 'required|in:0,1',
            //'status'    => 'required|in:0,1',
        ];
    }
}
