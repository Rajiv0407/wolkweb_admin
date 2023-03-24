<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class soical extends Model
{
    protected $table = 'social_media_weightage';
	public $timestamps = false;

    protected $fillable = [
        'id','title','weightage','status'
    ];

}
