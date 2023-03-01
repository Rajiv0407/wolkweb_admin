<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB ;

class post_like extends Model
{
    use HasFactory;
     public $timestamps = false;
      protected $fillable = [
        'id', 'post_id'  ,'user_id','isLike'
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

    public function getTotalLike($postId){
    	return DB::table('post_likes')->where('post_id',$postId)->count()	;
    }
}
