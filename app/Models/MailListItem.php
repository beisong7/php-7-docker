<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MailListItem extends Model
{
    protected $fillable = [
        'uuid',
        'mail_list_id',
        'email',
        'first_name',
        'round',
    ];

    public $timestamps = false;

    public function maillist(){
        return $this->belongsTo(MailList::class, 'mail_list_id', 'uuid');
    }
}
