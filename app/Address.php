<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'address',
        'city',
        'state',
        'zip',
        'country',
        'phone',
        'email',
        'user_id'
    ];
}
