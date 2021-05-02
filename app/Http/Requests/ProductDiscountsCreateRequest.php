<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductDiscountsCreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'starts_at' => 'date|required',
            'expires_at' => 'date|required',
            'product' => 'required'
        ];
    }
}
