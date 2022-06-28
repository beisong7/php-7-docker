<?php

namespace App\Traits\Role;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

trait RoleList{
    public function roleItems(){
        return [
            'modify_admin',
            'modify_roles',
            'modify_reg',
            'modify_pages',
            'modify_blog',
            'modify_sliders',
            'modify_state',
            'view_fund',
            'modify_unique',
            'member_plan',
            'bus_type',
            'manage_members',
            'manage_channels',
            'manage_split_pay',
            'manage_email_sending',
        ];
    }
}