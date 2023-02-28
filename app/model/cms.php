<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class cms extends Model
{
    
	protected $table = 'cms';
	public $timestamps = false;

    protected $fillable = [
    	'Content_type','Content_title','Description'       
    ];
}
