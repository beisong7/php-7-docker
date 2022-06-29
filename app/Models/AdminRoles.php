<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminRoles extends Model
{
    protected $fillable = [
        'uuid',
        'admin_id',
        'role_id',
    ];

    public function role(){
        return $this->hasOne(Role::class, 'uuid', 'role_id');
    }
}
