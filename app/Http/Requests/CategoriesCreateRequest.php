<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoriesCreateRequest extends FormRequest
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

    protected function getValidatorInstance()
    {
        $data = $this->all();
        $data['name'] = trim($data['name']);
        $data['meta_desc'] = trim($data['meta_desc']);
        $data['meta_keywords'] = trim($data['meta_keywords']);
        $data['meta_title'] = trim($data['meta_title']);
        $this->getInputSource()->replace($data);

        /*modify data before send to validator*/

        return parent::getValidatorInstance();
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
            'photo'=>'image',
            'priority'=>'numeric',
            'meta_desc' => 'max:300',
            'meta_title' => 'max:70'
        ];
    }
}
