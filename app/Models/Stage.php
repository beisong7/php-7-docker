<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    protected $fillable = [
        'uuid',
        'admin_id',
        'title',
        'automate_id',
        'mail_list_id',
        'rebuild_round',
        'round',
        'position',
        'list_filter',
        'process',
        'active',
    ];

    public function automate(){
        return $this->belongsTo(Automate::class, 'automate_id', 'uuid');
    }

    public function mailList(){
        return $this->hasOne(MailList::class, 'uuid', 'mail_list_id');
    }
}
