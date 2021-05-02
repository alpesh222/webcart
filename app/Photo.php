<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    public static $directory = '/img/';
    private static $defaultUserPhoto = '/img/default-user-photo.png';
    private static $directoryName = 'img';

    protected $fillable = [
        'name', 'product_id'
    ];

    public function getNameAttribute($value) {
        return url('/').self::$directory.$value;
    }

    public function getPath() {
        return public_path().self::$directory.$this->getOriginal('name');
    }

    public static function getPhotoDirectory() {
        return url('/').self::$directory;
    }

    public static function getDefaultUserPhoto() {
        return url('/').self::$defaultUserPhoto;
    }

    public static function getPhotoDirectoryName() {
        return self::$directoryName;
    }

    public function product() {
        return $this->belongsTo('App\Product');
    }

    public function comparisionGroup() {
        return $this->belongsTo('App\ComparisionGroup');
    }
}
