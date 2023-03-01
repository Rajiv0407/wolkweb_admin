<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class post extends Model
{
    use HasFactory;

     public $timestamps = false;

     protected $fillable = [
        'id','userId','message','createdOn'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'createdOn','status'
    ];
		
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [        
    ];

     public function post_images()
    {        
        return $this->hasMany(Post_image::class,'postId','id');
    }

    public function comments(){
        return $this->hasMany(Post_comment::class,'id','postId');
    }

    


}
