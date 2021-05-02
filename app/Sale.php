<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    public $timestamps = false;

    protected $fillable = ['product_id', 'order_id', 'date', 'sales'];

    public function product() {
        return $this->belongsTo('App\Product');
    }
}
