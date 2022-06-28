<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 29/12/2020
 * Time: 7:53 AM
 */

namespace App\Services\Automate;


use App\Models\Automate;
use App\Models\MailList;
use App\Models\MailListItem;
use App\Models\Member;
use App\Models\Stage;
use App\Services\MailList\ProcessRecipientService;
use App\Services\MailList\SentService;
use App\Traits\General\Utility;
use App\Traits\Search\MemberSearch;
use Illuminate\Support\Facades\DB;

class RunAutoListService
{
    use MemberSearch, Utility;

    protected $mailService, $mailSent, $automateService;

    public function __construct(ProcessRecipientService $service, SentService $sentService, AutomateServices $automateServices)
    {
        $this->mailService = $service;
        $this->mailSent = $sentService;
        $this->automateService = $automateServices;
    }

    /**
     * Begin process
     */
    function runProcess(Automate $automate, Stage $stage, MailList $list){
        $day = strtolower(date('l'));

        $complete = false;


        //get round

        DB::beginTransaction();
        if(!empty($list['email'])){
            $list_items = MailListItem::where('mail_list_id', $list->uuid)
                ->where('email', '!=', null)
                ->where('first_name', '!=', null)
                ->where('round', '<', $list->round)
                ->take(50)
                ->get();


            $sent = 0;
            foreach ($list_items as $recipient){
                //dd($recipient);
                try{
                    $this->mailService->processOne($recipient, $list);
                }catch (\Exception $e){
                    //dd($e->getMessage());
                }
                $sent++;
            }

            //update sent
            $this->mailSent->updateSent($sent);

            //handle after email send actions
            $pending_items = $list->pendingItems;
            if($pending_items < 1){

                $listUpdate['status'] = 'pending';
                $listUpdate["{$day}_run"] = true;
                $listUpdate['round'] = $automate->round;
                $list->update($listUpdate);
                //set completed
                $complete = true;


            }else{
                $listUpdate['status'] = 'ongoing';
                $list->update($listUpdate);
            }
        }else{
            $err_data['active'] = false;
            $err_data['status'] = 'inactive';
            $list->update($err_data);
        }

        DB::commit();
//            dd($sent);


        if($complete){
            //update maillist
            DB::beginTransaction();
            $mailData['round'] = $automate->round;
            $list->update($mailData);

            //update stage
            $stageData['round'] = $automate->round;
            $stage->update($stageData);

            DB::commit();
        }

    }

    public function buildList(Stage $stage){

        //delete all members from list
        $this->emptyList($stage->mailList);

        //rebuild new list
        $list = $this->generateMembers($stage->list_filter);

        //add list to mail list
        $this->addListToMailList($list, $stage->mailList->uuid);

    }

    function emptyList(MailList $mailList){
        MailListItem::where('mail_list_id', $mailList->uuid)->delete();
    }

    function generateMembers($filter){
        $query = Member::where('id', '!=', null)->select(['first_name', 'email', 'last_name', 'uuid', 'created_at']);
        $query = $this->exportType($query, $filter);
        $data = $query->orderBy('created_at', 'desc')->get();
        return $data;
    }

    function addListToMailList($recipient_object, $list_id){
        foreach ($recipient_object as $recipient){
            //check that the user does not exist in group already
            if(empty(MailListItem::where('mail_list_id', $list_id)->where('email', $recipient->email)->first())){
                //add user
                $data['uuid'] = $this->makeUuid();
                $data['mail_list_id'] = $list_id;
                $data['email'] = $recipient->email;
                $data['first_name'] = $recipient->first_name;
                $data['round'] = 0;
                DB::beginTransaction();
                MailListItem::create($data);
                DB::commit();

            }
        }
    }



    public function addToList(MailList $mailList){

    }

}