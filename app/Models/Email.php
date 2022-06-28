<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $fillable = [
        'uuid',
        'admin_id',
        'sender',
        'subject',
        'title',
        'recipient',
        'body',
        'active',
        'private',
        'sent',
        'status',
        'error_message',
    ];

    public function author(){
        return $this->hasOne(User::class, 'uuid', 'admin_id');
    }
}
