<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BrandsUpdateRequest;

class BannersCreateRequest extends FormRequest
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
            'photo'=>'image',
            'priority'=>'numeric',
            'link'=>'url|nullable'
        ];
    }

    public function messages()
    {
        return [
            'photo.image' => 'The image is invalid.',
            'link.url' => 'Please enter valid url.'
        ];
    }
}
