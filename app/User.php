<?php

namespace App;

use App\Models\AdminRoles;
use App\Models\Role;
use App\Traits\Role\Privilege;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    use Notifiable, Privilege;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'title',
        'first_name',
        'last_name',
        'email',
        'phone',
        'image_key',
        'address',
        'office',
        'active',
        'password',
        'role_id',
        'last_seen',
        'dob',
        'countdown_pass',
        'countdown_otp',
        'otp',
        'token',
        'theme_type',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getNamesAttribute(){
        return $this->first_name . " " . $this->last_name;
    }

    public function getImageAttribute(){
        if(file_exists($this->image_key)){
            return url($this->image_key);
        }else{
            return url('img/user.png');
        }
    }

    public function getFirstRoleNameAttribute(){
        $arole = AdminRoles::orderBy('id', 'asc')->where('admin_id', $this->uuid)->first();

        return !empty($arole)?$arole->role->name:'no role';
    }

    public function roles(){
        return $this->hasManyThrough(Role::class, AdminRoles::class, 'admin_id', 'uuid', 'uuid', 'role_id');
    }
}
