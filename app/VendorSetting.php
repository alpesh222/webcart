<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorSetting extends Model
{
    protected $fillable = ['vendor_id', 'key', 'value'];

    public function vendor() {
        return $this->belongsTo('App\Vendor');
    }
}
