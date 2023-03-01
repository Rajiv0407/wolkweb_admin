<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class post_comment extends Model
{
    use HasFactory;
    public $timestamps = false;

     protected $fillable = [
        'id','postId', 'comment','userId'
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

    public function posts(){
        return $this->belongsTo(Post::class,'postId','id');
    }
}
