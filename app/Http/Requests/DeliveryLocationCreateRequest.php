<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryLocationCreateRequest extends FormRequest
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
        $delivery_location_id = '';
        if(isset($_POST['edit_form']) && !empty($_POST['edit_form'])){
            $delivery_location_id = ','.$_POST['delivery_location_id'];
        }
        return [
            'enable_delivery_location'  => 'required',
            'country'   => 'max:191|required',
            'state'     => 'max:191|required',
            'city'      => 'max:191|required',
            'zip_code'  => 'max:191|required|unique:delivery_locations,pincode'.$delivery_location_id
        ];
    }
}
