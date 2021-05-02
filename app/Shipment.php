<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
	protected $fillable = ['name', 'address', 'city', 'state', 'zip', 'country'];

    public function orders() {
        return $this->belongsToMany('App\Order')->withTimestamps()->withPivot(['user_id']);
    }

    public function users() {
        return $this->belongsToMany('App\User')->withTimestamps();
    }
}
