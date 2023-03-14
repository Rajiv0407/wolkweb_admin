<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class notification_types extends Model
{
    protected $table = 'notification_type';
	public $timestamps = false;

	 protected $fillable = [
        	'title','status'
    ];
}
