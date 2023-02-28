<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class user_messages extends Model
{
     protected $table = 'user_messages';
	public $timestamps = false;

	 protected $fillable = [
        	'conversationId','senderId','receiverId','message'
    ];
}
