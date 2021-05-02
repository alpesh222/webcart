<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Product extends Model
{
    use Sluggable;

    protected $fillable = [
        'name', 'is_active', 'in_stock', 'price', 'old_price', 'model', 'user_id', 'category_id', 'brand_id', 'description', 'photo_id', 'tax_rate', 'barcode', 'qty_per_order', 'location_id', 'slug', 'voucher_id', 'file_id', 'virtual', 'downloadable', 'sku', 'hsn', 'meta_desc', 'meta_keywords', 'meta_title', 'custom_fields', 'vendor_id', 'variants', 'comp_group_id'
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function vendor() {
        return $this->belongsTo('App\Vendor');
    }

    public function category() {
        return $this->belongsTo('App\Category');
    }

    public function brand() {
        return $this->belongsTo('App\Brand');
    }

    public function orders() {
        return $this->belongsToMany('App\Order')->withPivot(['quantity', 'total', 'unit_price', 'spec']);
    }

    public function photo() {
        return $this->belongsTo('App\Photo');
    }

    public function photos() {
        return $this->hasMany('App\Photo');
    }

    public function sales() {
        return $this->hasMany('App\Sale');
    }

    public function location() {
        return $this->belongsTo('App\Location');
    }

	public function voucher() {
		return $this->belongsTo('App\Voucher');
	}

    public function reviews() {
        return $this->hasMany('App\Review');
    }

    public function deals() {
        return $this->belongsToMany('App\Deal');
    }

    public function specificationTypes() {
        return $this->belongsToMany('App\SpecificationType')->withPivot(['value', 'unit']);
    }

    public function comparisionGroup() {
        return $this->belongsTo('App\ComparisionGroup');
    }

    public function file() {
        return $this->belongsTo('App\File');
    }

    public function related_products() {
        return $this->belongsToMany('App\Product', 'related_products', 'product_id', 'related_product_id');
    }

    public function favourites() {
        return $this->morphToMany('App\User', 'favouriteable');
    }

    public function favouritedBy(User $user) {
        return $this->favourites->contains($user);
    }

    public function vendor_amounts() {
        return $this->hasMany('App\VendorAmount');
    }

    public function decreaseStock($stock, $order_id = null) {
        $product = Product::findOrFail($this->id);
        if($product->virtual) {
            $product->sales++;
        } else {
            $product->in_stock -= $stock;
            $product->sales += $stock;
        }
        $product->save();
        $product->sales()->create(['date' => Carbon::now(), 'sales' => $stock, 'order_id' => $order_id]);
    }

    public static function isStockAvailable($products) {
        foreach($products as $product) {
            $product->in_stock -= $product->pivot->quantity;
            if($product->in_stock < 0) {
                return false;
            }
        }
        return true;
    }

    public function increaseStock($stock, $order_id = null) {
        $product = Product::findOrFail($this->id);
        if($product->virtual) {
            $product->sales--;
        } else {
            $product->in_stock += $stock;
            $product->sales -= $stock;
        }
        $product->save();
        $total_sales = Product::sum('sales');
        $product->sales()->where('order_id', $order_id)->where('product_id', $product->id)->delete();
    }

    public function price_with_tax($add_price = 0) {
        $price = $this->price;
        $price += $add_price;
        return $price + ($price * $this->tax_rate) / 100;
    }

    public function price_with_discount($add_price = 0) {
        $price = $this->price;
        $price += $add_price;
        if($this->voucher && Carbon::now()->gte(Carbon::parse($this->voucher->starts_at)) && Carbon::now()->lte(Carbon::parse($this->voucher->expires_at))) {
            return $price - ($price * $this->voucher->discount_amount) / 100;
        } else {
            return $price;
        }
    }

    public function discount_percentage() {
        if($this->voucher) {
            return $this->voucher->discount_amount;
        } else {
            return 0;
        }
    }

    public function price_with_tax_and_discount($add_price = 0) {
        $price = $this->price;
        $price += $add_price;
        if($this->voucher && Carbon::now()->gte(Carbon::parse($this->voucher->starts_at)) && Carbon::now()->lte(Carbon::parse($this->voucher->expires_at))) {
            return ($price - (($price * $this->voucher->discount_amount) / 100) + (($price * $this->tax_rate) / 100));
        } else {
            return $price + (($price * $this->tax_rate) / 100);
        }
    }
}
