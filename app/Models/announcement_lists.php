<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class announcement_lists extends Model
{
    protected $table = 'pe_announcement_list';
	public $timestamps = false;

	 protected $fillable = [
        	
        	'title','type','nFor','content','deviceType'
    ];
}
