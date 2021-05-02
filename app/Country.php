<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = ['country_name','country_status'];

    public function states(){
        return $this->hasMany('App\State');
    }

    public static function getAllActiveCountries(){
        $countries = Country::where([
            ['country_status','=','1'],
            ['deleted_at','=',NULL],
        ])->get()->toArray();
        return $countries;
    }
}
