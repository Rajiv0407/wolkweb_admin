<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class fuel_types extends Model
{
    protected $table = 'fuel_type';
	public $timestamps = false;

	 protected $fillable = [
        	'id','title'
    ];
}
