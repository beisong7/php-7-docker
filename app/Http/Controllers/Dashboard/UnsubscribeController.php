<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Unsubscribe;
use App\Traits\General\Cryption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UnsubscribeController extends Controller
{
    use Cryption;
    //
    public function terminate($key){
        try{
            $email = $this->my_decrypt($key);
            //add to ignore list
            $data['email'] = $email;
            DB::beginTransaction();
            Unsubscribe::create($data);
            DB::commit();
            return redirect('https://irecharge.ng');
        }catch (\Exception $e){
            return redirect('https://irecharge.ng');
        }
    }
}
