<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class contacts extends Model
{
	protected $table = 'contactus';
	public $timestamps = true;

    protected $fillable = [
        'email', 'subject', 'message'
    ];


    
}
