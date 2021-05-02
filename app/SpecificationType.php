<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpecificationType extends Model
{
	protected $fillable = ['name', 'location_id'];

	public function products() {
		return $this->belongsToMany('App\Product')->withPivot(['value', 'unit']);
	}

	public function categories() {
		return $this->belongsToMany('App\Category');
	}

    public function location() {
        return $this->belongsTo('App\Location');
    }
}
