<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VendorsCreateRequest extends FormRequest
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
            'name'=>'required|max:50',
            'company_name'=>'required|max:191',
            'phone'=>'required|regex:/^\+(?:[0-9] ?){6,14}[0-9]$/',
            'amount_percentage_per_sale'=>'required|numeric|regex:/^\d*(\.\d{1,2})?$/|min:0|max:100'
        ];
    }
}
