<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
	protected $fillable = ['photo_id', 'author', 'review', 'designation', 'is_active', 'priority'];

    public function photo() {
        return $this->belongsTo('App\Photo');
    }
}
