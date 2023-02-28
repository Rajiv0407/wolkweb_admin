<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class notification_fors extends Model
{
     protected $table = 'pe_announcement_for';
	public $timestamps = false;

	 protected $fillable = [
        	'title','status'
    ];
}
