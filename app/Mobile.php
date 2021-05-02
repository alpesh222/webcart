<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mobile extends Model
{
    protected $fillable = [
        'number', 'user_id', 'verified'
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }
}
