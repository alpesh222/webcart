<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = ['content', 'position', 'priority', 'full_width', 'position_category', 'position_brand', 'category_id', 'brand_id', 'location_id', 'is_active'];

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
