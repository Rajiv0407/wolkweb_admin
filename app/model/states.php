<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class states extends Model
{
     protected $table = 'state';
	public $timestamps = false;

    protected $fillable = [
        'countryId','title','status'
    ];

}
