<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cms extends Model
{
    use HasFactory;
    public $timestamps = false;


     protected $fillable = [
        'id', 'description'  
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */	
    protected $hidden = [
        'status', 'createdOn'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
      
    ];

}
