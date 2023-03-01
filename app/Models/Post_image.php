<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB ;

class post_image extends Model
{
    use HasFactory;

    public $timestamps = false;

     protected $fillable = [
        'id','postId','image'
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

    public function getPostImage($postId='')
    {    
        //$baseUrl = URL::to('/') ;
        $imagePath=config('constants.post_image').$postId.'/';
        return DB::table('post_images')->select('id',DB::raw('CONCAT("'.$imagePath.'",image) as image'))->where('postId',$postId)->get() ;  
    }
}
