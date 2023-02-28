<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class vehicles extends Model
{
    protected $table = 'vehicle';
	public $timestamps = false;

	 protected $fillable = [
        'userId','manufacturer','model','nSeat','nDoor','fuelType','transmissionType',	'bodyType','status','priceType','price'
    ];

     public function body_type()
    {
        return $this->hasOne('App\model\body_types','id','bodyType');
    }
 
	public function transmission_type()
	{
	  return $this->hasOne('App\model\transmission_types','id','transmissionType');
	}

	public function fuel_type()
	{
	  return $this->hasOne('App\model\fuel_types','id','fuelType');
	}

}
