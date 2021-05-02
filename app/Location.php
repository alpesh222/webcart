<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Location extends Model
{
    use Sluggable;

    protected $fillable = ['name', 'address', 'contact_number', 'slug', 'location_id'];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function users() {
        return $this->hasMany('App\User');
    }

    public function products() {
        return $this->hasMany('App\Product');
    }
}
