<?php


namespace App\Services\Newsletter;


use App\Models\Email;
use App\Models\Group;
use App\Models\MailListItem;
use App\Services\MailList\MailListService;
use App\Traits\General\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewsletterService
{
    public static function createNewsletter(Request $request){

        $type = "newsletter";
        $email_id = Utility::generateID();
        $email['uuid'] = $email_id;
        $email['admin_id'] = $request->user()->uuid;
        $email['subject'] = $request->input('subject');
        $email['title'] = $request->input('title');
        $email['sender'] = empty($request->input('sender'))?"IRecharge":$request->input('sender');
        $email['recipient'] = $request->input('email');
        $email['body'] = $request->input('body');
        $start_sending = $request->input('start_sending');
        $email['private'] = false;
        $email['active'] = true;

        if($start_sending !== 'on'){
            //ensure that a send date is selected
            if(
                $request->sunday !== 'on' &&
                $request->monday !== 'on' &&
                $request->tuesday !== 'on' &&
                $request->wednesday !== 'on' &&
                $request->thursday !== 'on' &&
                $request->friday !== 'on' &&
                $request->saturday !== 'on'
            ){
                return back()
                    ->withErrors(['Since you are not sending the email once, ensure that a start day is selected.'])
                    ->withInput();
            }

        }

        DB::beginTransaction();

        $email = Email::create($email);

        //create maillist
        $mldata['email_id'] = $email_id;
        $mldata['start_sending'] = $start_sending;

//        dd($request->all());

        $mail_list = MailListService::create($request, $mldata);
        $selections = [];

        //add groups into mail-list
        if(!empty($request->selection)){
            if(count($request->selection)>0){
                $selections = $request->selection;

                foreach ($selections as $item){
                    $group = Group::where('uuid', $item)->first();
                    if(!empty($group)){
                        //get members in group
                        foreach ($group->members as $member){
                            $exist = MailListItem::where('email', $member->email)
                                ->where('mail_list_id', $mail_list->uuid)->first();
                            if(empty($exist)){
                                $mld['uuid'] = Utility::generateID();
                                $mld['mail_list_id'] = $mail_list->uuid;
                                $mld['email'] = $member->email;
                                $mld['first_name'] = $member->first_name;
                                $mld['round'] = 0;
                                MailListItem::insertOrIgnore($mld);
                            }
                        }
                    }
                }
            }
        }

        //handle inclusive list
        if(!empty($request->inclusive)){
            $inclusive = explode(",", $request->inclusive);
            if(count($inclusive)>0){
                foreach ($inclusive as $item){
                    $exist = MailListItem::where('email', $item)->first();
                    if(empty($exist)){
                        $mld['uuid'] = Utility::generateID();
                        $mld['mail_list_id'] = $mail_list->uuid;
                        $mld['email'] = $item;
                        $mld['first_name'] = "";
                        $mld['round'] = 0;
                        MailListItem::insertOrIgnore($mld);
                    }

                }
            }
        }

        //handle exclusive list
        if(!empty($request->exclusive)){
            $exclusive = explode(",", $request->exclusive);
            if(count($exclusive)>0){
                foreach ($exclusive as $item){
                    $exist = MailListItem::where('email', $item)->first();
                    if(empty($exist)){
                        $exist->delete();
                    }
                }
            }
        }

        DB::commit();
        return true;
    }
}
