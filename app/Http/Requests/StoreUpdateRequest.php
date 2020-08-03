<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreUpdateRequest extends Request
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
            'admin_user_id'     => 'required',
            'name'              => 'required|unique:store,name,' . $this->get('id') . '|min:2|max:50',
            'short_name'        => 'required|unique:store,short_name,' . $this->get('id') . '|min:2|max:10',
            'mobile'            => 'required|unique:store,mobile,' . $this->get('id') . '|min:10|max:10',
            'counties'          => 'required',
            'town'              => 'required',
            'status'            => 'required|in:0,1',
        ];
    }
}
