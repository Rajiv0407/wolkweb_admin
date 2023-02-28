<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class cities extends Model
{
    protected $table = 'city';
	public $timestamps = false;

    protected $fillable = [
        'countryId','stateId','title','status'
    ];

      public function state()
    {
        return $this->hasOne('App\model\states','id','stateId');
    }

      public function country()
    {
        return $this->hasOne('App\model\countries','id','countryId');
    }




}
