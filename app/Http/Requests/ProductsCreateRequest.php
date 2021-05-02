<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductsCreateRequest extends FormRequest
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
        $data['model'] = trim($data['model']);
        $data['sku'] = trim($data['sku']);
        $data['hsn'] = trim($data['hsn']);
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
            'name'=>'required|max:191',
            'model'=>'nullable|max:191',
            'sku'=>'nullable|max:150',
            'hsn'=>'nullable|max:150',
            'in_stock'=>'required_without:virtual|numeric|min:0|nullable',
            'qty_per_order'=>'required_without:virtual|numeric|min:0|nullable',
            'price'=>'required|regex:/^\d*(\.\d{1,2})?$/|min:0',
            'regular_price'=>'regex:/^\d*(\.\d{1,2})?$/|min:0|nullable',
            'photo'=>'image',
            'tax_rate'=>'nullable|min:0|max:100',
            'file'=>'required_with:downloadable|mimes:zip,rar,7z',
            'downloadable'=>'required_with:virtual,file',
            'meta_desc' => 'max:300',
            'meta_title' => 'max:70'
        ];
    }

    public function messages()
    {
        return [
            'photo.image' => 'The photo is invalid.',
            'in_stock.min'=>'The stock must be at least 0.'
        ];
    }
}
