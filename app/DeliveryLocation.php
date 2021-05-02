<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeliveryLocation extends Model
{
    use SoftDeletes;
    protected $fillable = ['country','state','city','pincode','status'];

    public function orders(){
        return $this->belongsToMany('App\Order')->withTimestamps()->withPivot(['user_id']);
    }

    public static function getAllActiveDeliveryLocations(){
        $delivery_locations = DeliveryLocation::where([
            ['deleted_at','=',NULL],
        ])->get();
        return $delivery_locations;
    }
}
