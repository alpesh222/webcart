<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Page extends Model
{
    use Sluggable;

    protected $fillable = [
        'title', 'content', 'is_active', 'slug', 'meta_desc', 'meta_keywords', 'meta_title', 'priority', 'show_in_menu', 'show_in_footer'
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title',
                'reserved' => ['cart', 'contact-us', 'account-overview', 'orders', 'addresses', 'laravel-filemanager']
            ],
        ];
    }
}
