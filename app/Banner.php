<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = ['title', 'description', 'link', 'photo_id', 'is_active', 'position', 'location_id', 'brand_id', 'category_id', 'position_brand', 'position_category', 'priority'];

    public function photo() {
        return $this->belongsTo('App\Photo');
    }

    public function location() {
        return $this->belongsTo('App\Location');
    }

    public function brand() {
        return $this->belongsTo('App\Brand');
    }

    public function category() {
        return $this->belongsTo('App\Category');
    }
}
