<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class body_types extends Model
{
    protected $table = 'body_type';
	public $timestamps = false;

	 protected $fillable = [
        	'id','title','icon'
    ];
}
