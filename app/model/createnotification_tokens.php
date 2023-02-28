<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class createnotification_tokens extends Model
{
    protected $table = 'createnotification_token';
	public $timestamps = false;

	 protected $fillable = [
        	'deviceToken','deviceType','userId','isNotify'
    ];
}
