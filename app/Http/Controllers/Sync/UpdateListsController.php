<?php

namespace App\Http\Controllers\Sync;

use App\Http\Controllers\Controller;
use App\Services\Automate\MemberService;
use App\Traits\General\HttpTrait;
use Illuminate\Http\Request;

class UpdateListsController extends Controller
{
    use HttpTrait;
    public function intervalSync(){
        //use last member email to get new emails
        $last = MemberService::lastItem();
        $body = [
            'last_email'=>$last->email
        ];
        $url = "";
        $res = $this->makeRequest("POST", $url, $body);
        if($res[0]){
            MemberService::handleSync($res['data']);
        }
    }
}
