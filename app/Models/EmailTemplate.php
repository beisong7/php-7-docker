<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    protected $fillable = [
        'uuid',
        'admin_id',
        'title',
        'body',
        'current',
        'active',
    ];

    public function author(){
        return $this->hasOne(User::class, 'uuid', 'admin_id');
    }
}
