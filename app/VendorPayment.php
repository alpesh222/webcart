<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorPayment extends Model
{
    protected $fillable = ['vendor_id', 'amount', 'currency', 'payment_id', 'payment_status', 'payment_method'];

    public function vendor() {
        return $this->belongsTo('App\Vendor');
    }

    public function vendor_amounts() {
		return $this->hasMany('App\VendorAmount');
    }
}
