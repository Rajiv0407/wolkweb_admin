<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class transmission_types extends Model
{
    protected $table = 'transmission_type';
	public $timestamps = false;

	 protected $fillable = [
        	'id','title'
    ];
}
