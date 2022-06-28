<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Email;
use App\Traits\General\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InstantMailBuildController extends Controller
{
    use Utility;
    public function queueMail(Request $request){

        $recipient = $request->input('to');
        $body = $request->input('body');
        $subject = $request->input('subject');

        try{
            if(!empty($recipient) || !empty($body) || !empty($subject)){

                $data['uuid'] = $this->makeUuid();
                $data['admin_id'] = 'api-service';
                $data['subject'] =
                $data['recipient'] =
                $data['body'] =
                $data['private'] = true;
                $data['active'] = true;
                $data['sent'] = false;
                $data['status'] = 'pending';

                DB::beginTransaction();
                Email::create($data);
                DB::commit();

            }
        }catch (\Exception $err){

        }

        return response()->json(['message'=>'completed'], 200);
    }
}
