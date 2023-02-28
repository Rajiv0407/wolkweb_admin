<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class vehicle_images extends Model
{
    protected $table = 'vehicle_image';
	public $timestamps = false;

	 protected $fillable = [
       'id','vehicleId','image','isFeatured','bigImage'
    ];



}
