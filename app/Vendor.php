<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Vendor extends Model
{
    use Sluggable;

    protected $fillable = ['name', 'shop_name', 'address', 'city', 'state', 'phone', 'description', 'amount_percentage', 'profile_completed', 'approved', 'user_id', 'slug'];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'shop_name',
                'onUpdate' => false
            ]
        ];
    }

    public function user() {
    	return $this->belongsTo('App\User');
    }

    public function products() {
        return $this->hasMany('App\Product');
    }

    public function vendor_settings() {
        return $this->hasMany('App\VendorSetting');
    }

    public function vendor_payments() {
        return $this->hasMany('App\VendorPayment');
    }

    public function vendor_amounts() {
        return $this->hasMany('App\VendorAmount');
    }

    public function vendor_requests() {
        return $this->hasMany('App\VendorRequest');
    }
}
