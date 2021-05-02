<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Customer extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'address',
        'city',
        'state',
        'zip',
        'country',
        'phone',
        'email',
        'user_id'
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function orders() {
        return $this->hasMany('App\Order');
    }

    public function addCustomerShippingAddress($input){
        $customer = Auth::user()->customers()->save(
            new Customer([
                "first_name"=> $input["first_name"],
                "last_name" => $input["last_name"],
                "address"   => $input["address"],
                "city"      => $input["city"],
                "state"     => $input["state"],
                "zip"       => $input["zip"],
                "country"   => $input["country"],
                "phone"     => $input["phone"],
                "email"     => $input["email"]
            ]));
        return $customer;
    }
}
