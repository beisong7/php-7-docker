<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //

    protected $fillable = [
        'uuid',
        'name',
        'modify_admin',
        'modify_roles',
        'modify_reg',
        'modify_pages',
        'modify_blog',
        'modify_sliders',
        'view_fund',
        'modify_unique',
        'member_plan',
        'bus_type',
        'manage_members',
        'manage_channels',
        'manage_split_pay',
        'manage_email_sending',
        'main_role',
        'modify_state',
        'active',
    ];

    public function users(){
        return $this->hasManyThrough(User::class, AdminRoles::class, 'role_id','uuid', 'uuid', 'admin_id');
    }

    public function getUsersCountAttribute(){
        return $this->users->count();
    }
}
