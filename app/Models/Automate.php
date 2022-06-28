<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Automate extends Model
{
    protected $fillable = [
        'uuid',
        'title',
        'info',
        'admin_id',
        'round',
        'active',
    ];

    public function stages(){
        return $this->hasMany(Stage::class, 'automate_id', 'uuid');
    }

    public function author(){
        return $this->hasOne(User::class, 'uuid', 'admin_id');
    }

    public function getstagesByPosAttribute(){
        $stages = Stage::where('automate_id', $this->uuid)->orderBy('position','asc')->get();
        if($stages->count()<1){
            return [];
        }
        return $stages;
    }
}
