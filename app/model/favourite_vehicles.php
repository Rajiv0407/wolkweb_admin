<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class favourite_vehicles extends Model
{
    protected $table = 'favourite_vehicle';
	public $timestamps = false;

    protected $fillable = [
        'id','vehicleId', 'userId'
    ];

}
