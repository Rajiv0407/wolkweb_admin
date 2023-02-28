<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class bookings extends Model
{
     protected $table = 'booking';
	public $timestamps = false;

	 protected $fillable = [
        	'userId','user_name','user_email','vehicleId','pickupTo',	'returnTo','bookingDate','returnDate','amount',	'paymentType','paymentStatus','txnId','createdOn','latitude','longitude','rateAmount','chargeType','destination_latitude' , 'destination_longitude'
    ];

     public function vehicle()
    {
        return $this->hasOne('App\model\vehicles','id','vehicleId');
    }

    public function vehicle_image()
    {
        return $this->hasOne('App\model\vehicle_images','vehicleId','vehicleId');
    }


    
}
