<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Brand extends Model
{
    use Sluggable;

    protected $fillable = [
        'name', 'is_active', 'photo_id', 'slug', 'location_id', 'meta_desc', 'meta_keywords', 'meta_title', 'priority', 'show_in_menu', 'show_in_footer', 'show_in_slider'
      ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function products() {
        return $this->hasMany('App\Product');
    }

    public function photo() {
        return $this->belongsTo('App\Photo');
    }

    public function location() {
        return $this->belongsTo('App\Location');
    }

    public function banners() {
        return $this->hasMany('App\Banner');
    }

    public function sections() {
        return $this->hasMany('App\Section');
    }
}
