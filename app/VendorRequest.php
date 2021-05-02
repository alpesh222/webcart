<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorRequest extends Model
{
    protected $fillable = ['message', 'is_processed', 'processed_date', 'vendor_id'];

    public function vendor() {
    	return $this->belongsTo('App\Vendor');
    }
}
