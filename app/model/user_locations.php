<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class user_locations extends Model
{
     protected $table = 'user_location';
	public $timestamps = false;

	 protected $fillable = [
        	'Id','UserId','Latitude' , 'Longitude'
    ];
}


