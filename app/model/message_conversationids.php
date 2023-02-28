<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;
use mailboxs ;
class message_conversationids extends Model
{
    protected $table = 'message_conversationid';
	public $timestamps = false;

	 protected $fillable = [
        	'senderId','receiverId','conversationId','lastMessage',	'status'
    ];


    // public function mailboxs()
    // { 
    //     return $this->hasMany(mailboxs::class,'MailConversationId','id');
    // }

}
