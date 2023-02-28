<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class ratings extends Model
{
     protected $table = 'vehicle_review';
	public $timestamps = false;

	 protected $fillable = [
		'vehicleId','userId','rating','review','status'
    ];
}
