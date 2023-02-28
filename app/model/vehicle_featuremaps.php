<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class vehicle_featuremaps extends Model
{
    //

    protected $table = 'vehicle_featuremap';
	public $timestamps = false;
			
	 protected $fillable = [
        	'vehicleId','featureId','isSelected'
    ];
}
