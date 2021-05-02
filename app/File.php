<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = ['filename', 'mime', 'original_filename'];

    public function product() {
        return $this->hasOne('App\Product');
    }
}
