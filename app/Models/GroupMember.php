<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupMember extends Model
{
    protected $fillable = [
        "group_id",
        "member_id",
    ];

    public function member(){
        return $this->hasOne(Member::class, 'uuid', 'member_id');
    }

    public function group(){
        return $this->hasOne(Group::class, 'uuid', 'group_id');
    }
}
