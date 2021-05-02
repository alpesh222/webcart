<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Category extends Model
{
    use Sluggable;
    
    protected $fillable = [
        'name', 'is_active', 'category_id', 'slug', 'location_id', 'photo_id', 'meta_desc', 'meta_keywords', 'meta_title', 'priority', 'show_in_menu', 'show_in_footer', 'show_in_slider'
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    // Parent Category
    public function category() {
        return $this->belongsTo('App\Category');
    }

    // Sub Categories
    public function categories() {
        return $this->hasMany('App\Category');
    }

    public function products() {
        return $this->hasMany('App\Product');
    }

    public function location() {
        return $this->belongsTo('App\Location');
    }

    public function photo() {
        return $this->belongsTo('App\Photo');
    }

    public function specificationTypes() {
        return $this->belongsToMany('App\SpecificationType');
    }

    public function banners() {
        return $this->hasMany('App\Banner');
    }

    public function sections() {
        return $this->hasMany('App\Section');
    }

    public function all_products()
    {
        $products = [];
        $categories = [$this];
        while(count($categories) > 0){
            $nextCategories = [];
            foreach ($categories as $category) {
                $products = array_merge($products, $category->products->all());
                $nextCategories = array_merge($nextCategories, $category->categories->all());
            }
            $categories = $nextCategories;
        }
        return new Collection($products);
    }
}