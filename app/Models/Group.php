<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        "uuid",
        "name",
        "unique_key",
        "info",
        "is_active",
    ];

    public function members(){
        return $this->hasManyThrough(
            Member::class,
            GroupMember::class,
            "group_id",
            "uuid",
            "uuid",
            "member_id"
        );
    }

    public function anchors(){
        return $this->hasMany(GroupMember::class, 'uuid', 'group_id');
    }
}
