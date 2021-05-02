<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TestimonialsCreateRequest extends FormRequest
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
        $data['author'] = trim($data['author']);

        $this->getInputSource()->replace($data);

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
            'author' => 'required|max:191',
            'designation' => 'nullable|max:191',
            'review' => 'required',
            'priority'=>'numeric',
        ];
    }
}
