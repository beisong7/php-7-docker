<?php

namespace App\Traits\General;

use Illuminate\Support\Str;

trait Utility{

    public function makeUuid($prefix=null){
        $uuid = (string)Str::uuid();
        return !empty($prefix)?$prefix."-".$uuid:$uuid;
    }

    public static function generateID($prefix=null){
        $uuid = (string)Str::uuid();
        return !empty($prefix)?$prefix."-".$uuid:$uuid;
    }
}
