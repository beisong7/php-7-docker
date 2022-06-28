<?php

namespace App\Traits\Campaign;

use App\Traits\General\Cryption;

trait UnsubLink{

    use Cryption;

    public function generate($email){
        try{
            $key = $this->my_encrypt($email);
            return route('unsubscribe', $key);
        }catch (\Exception $e){
            return "http://nyccng.org";
        }

    }
}