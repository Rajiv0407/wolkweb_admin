<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class countries extends Model
{
    protected $table = 'country';
	public $timestamps = false;

    protected $fillable = [
        'title','status'
    ];

}
