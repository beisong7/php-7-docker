<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $connection = 'nycc_site';
    protected $fillable = [
        'uuid',
        'member_id',
        'plan_id',
        'type',
        'issue_date',
        'expire_date',
        'current',
        'start_reminder_date',
        'active',
    ];

    public function member(){
        return $this->belongsTo(Member::class, 'member_id', 'uuid');
    }
}
