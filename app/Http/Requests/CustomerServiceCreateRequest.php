<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CustomerServiceCreateRequest extends Request
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
            'customer_category_id'   => 'required',
            'code'                   => 'required|unique:customer_service|max:4',
            'name'                   => 'required|max:40',
            'status'                 => 'required|in:-1,0,1',
            'description'            => 'max:400',
        ];
    }
}
