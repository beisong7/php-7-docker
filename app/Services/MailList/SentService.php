<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 06/12/2020
 * Time: 7:09 AM
 */

namespace App\Services\MailList;


use App\Models\MailList;
use App\Models\MailListItem;
use App\Models\Member;
use App\Models\Send;
use App\Traits\General\Mailer;
use App\Traits\General\Utility;
use App\Traits\Search\MemberSearch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SentService
{

    public function updateSent($count){
        $date = date('Y-m-d');
        $sent = Send::where('date', $date)->first();
        DB::beginTransaction();
        if(empty($sent)){
            $data['date'] = $date;
            $data['count'] = $count;
            Send::create($data);
        }else{
            $sent->increment('count', $count);
            //$data['count'] = $sent->count + $count;
            //$sent->update($data);
        }
        DB::commit();
    }
}