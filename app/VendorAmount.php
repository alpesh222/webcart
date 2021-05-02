<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorAmount extends Model
{
    public $timestamps = false;

    protected $dates = ['outstanding_date', 'earned_date', 'payment_date', 'cancel_date'];

	protected $fillable = ['product_id', 'vendor_id', 'order_id', 'product_name', 'product_quantity', 'unit_price', 'total_price', 'vendor_amount', 'currency', 'status', 'outstanding_date', 'earned_date', 'payment_date', 'vendor_payment_id', 'cancel_date', 'processed'];

	public function product() {
		return $this->belongsTo('App\Product');
	}

	public function order() {
		return $this->belongsTo('App\Order');
	}

	public function vendor_payment() {
		return $this->belongsTo('App\VendorPayment');
	}
}
