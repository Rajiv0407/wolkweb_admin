<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class vehicle_features extends Model
{
     protected $table = 'vehicle_feature';
	public $timestamps = false;

	 protected $fillable = [
        	'id','title','icon'
    ];
}
