<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class notification_types extends Model
{
    protected $table = 'pe_announcement_master';
	public $timestamps = false;

	 protected $fillable = [
        	'title','status'
    ];
}
