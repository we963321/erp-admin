<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProductUpdateRequest extends Request
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
        return [
            'product_category_id'    => 'required',
            'code'                   => 'required|unique:product,code,' . $id . '|max:4',
            'name'                   => 'required|max:50',
            'status'                 => 'required|in:-1,0,1',
            'description'            => 'max:400',
            'remark'                 => 'max:400',
        ];
    }
}
