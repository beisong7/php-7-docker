<?php

namespace App\Traits\Role;

use Illuminate\Support\Facades\Auth;

trait Privilege{

    public function hasAccess($action, $route = null){
        $access = Auth::user()->roles->where('active', true)->where($this->action($action), true)->first();
        return !empty($access)?true:false;
    }

    public function verifyAccess($action, $route = null){
        $access = Auth::user()->roles->where('active', true)->where($this->action($action), true)->first();
        if(empty($access)){
            abort(302, 'Access Denied. Contact Administrator.', ['Location'=>!empty($route)?$route:route('admin.dashboard')]);
        }
        return true;
    }

    public function canSee($action){
        $access = Auth::user()->roles->where($this->action($action), true)->first();
        return !empty($access)?true:false;
    }

    public function action($act){
        switch ($act){


            case 'admin':
                return 'modify_admin';
                break;
            case 'role':
                return 'modify_roles';
                break;
            case 'registration':
                return 'modify_reg';
                break;
            case 'pages':
                return 'modify_pages';
                break;
            case 'blog':
                return 'modify_blog';
                break;
            case 'slider':
                return 'modify_sliders';
                break;
            case 'fund':
                return 'view_fund';
                break;
            case 'unique':
                return 'modify_unique';
                break;
            case 'member_plan':
                return 'member_plan';
                break;
            case 'business_type':
                return 'bus_type';
                break;
            case 'members':
                return 'manage_members';
                break;
            case 'manage_channels':
                return 'manage_channels';
                break;
            case 'split_payment':
                return 'manage_split_pay';
                break;
            case 'emails':
                return 'manage_email_sending';
                break;
            case 'modify_state':
                return 'modify_state';
                break;
            default:
                return '';
                break;
        }
    }
}