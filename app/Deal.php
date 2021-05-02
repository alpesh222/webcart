<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Deal extends Model
{
    use Sluggable;

    protected $fillable = ['name', 'description', 'priority', 'is_active', 'slug', 'location_id', 'meta_desc', 'meta_keywords', 'meta_title', 'show_in_menu', 'show_in_footer'];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function products() {
        return $this->belongsToMany('App\Product');
    }

    public function location() {
        return $this->belongsTo('App\Location');
    }
}
