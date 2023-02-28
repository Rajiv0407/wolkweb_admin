<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class mailboxs extends Model
{
    protected $table = 'mailbox';
	public $timestamps = false;

	protected $fillable = [
        	'MailConversationId','UserId','Subject','Body','SendBy'
    ];

    
}
