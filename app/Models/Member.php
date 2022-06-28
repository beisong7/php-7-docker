<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    //
    protected $fillable = [
        'uuid',
        'first_name',
        'last_name',
        'email',
    ];

    public function getNamesAttribute(){
        return "{$this->first_name} {$this->last_name}";
    }
}
