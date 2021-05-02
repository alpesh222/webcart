<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComparisionGroup extends Model
{
	protected $fillable = ['title', 'comparision_groups'];

	public function product() {
		return $this->hasMany('App\Product');
	}

    public function specificationTypes() {
        return $this->hasMany('App\SpecificationType');
    }

    public function photo() {
        return $this->belongsTo('App\Photo');
    }

    public static function getSpecificationTypeById($id){
	    $specification_type_data = SpecificationType::where('id',$id)->first();
	    $name = ! empty( $specification_type_data->name ) ? $specification_type_data->name : '';
	    return $name;
    }

    public static function getPhotoNameById($id){
	    $photo_data = Photo::where('id',$id)->first();
	    $names = ! empty( $photo_data->name ) ? explode('/',$photo_data->name) : array();
	    $image_name = end($names);
	    return $image_name;
    }
}
