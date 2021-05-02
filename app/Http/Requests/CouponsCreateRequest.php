<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CouponsCreateRequest extends FormRequest
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
            'code' => 'required|unique:vouchers',
            'name' => 'required',
            'discount_amount' => 'required|min:0',
            'max_uses' => 'min:0',
            'max_uses_user' => 'min:0',
            'starts_at' => 'date|required',
            'expires_at' => 'date|required',
            'valid_above_amount' => 'min:0'
        ];
    }
}
