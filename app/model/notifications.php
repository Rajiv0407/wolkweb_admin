<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class notifications extends Model
{
    protected $table = 'notification';
	public $timestamps = false;

	 protected $fillable = [
        	'Title','Content','CreateDate'
    ];
}
