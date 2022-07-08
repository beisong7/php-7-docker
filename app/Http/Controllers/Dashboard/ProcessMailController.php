<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\MailList;
use App\Models\MailListItem;
use App\Services\MailList\ProcessRecipientService;
use App\Services\MailList\SentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProcessMailController extends Controller
{
    protected $mailService, $mailSent;

    public function __construct(ProcessRecipientService $service, SentService $sentService)
    {
        $this->mailService = $service;
        $this->mailSent = $sentService;
    }

    public function processDaily(){
        //note, set status to ongoing once the process has started
        $day = strtolower(date('l'));
        $hour = intval(date('G'));
        $minute = intval(date('i'));
        $mail_lists = MailList::where('daily', true)
            ->where(function ($query) use ($hour, $minute, $day) {
                $query->where('hour', '<=',  $hour)
                    ->where('active', true)
                    ->where("{$day}_run", false)
                    ->where($day, true)
                    ->where('minute', '<=',  $minute);
            })
            ->orWhere(function ($query) use ($hour, $minute, $day) {
                $query->where('daily', true)
                    ->where('status', 'ongoing')
                    ->where('active', true);
            })
            ->with(['email'])
            ->get();

//        dd($mail_lists, $hour, $minute);

        $this->runProcess($mail_lists);



//        $query = MailListItem::whereIn('mail_list_item.mail_list_id', function($q){
//
//            $q->from('mail_lists')
//                ->select('mail_lists.uuid')
//                ->where('active', true)
//                ->where('sunday', $day)
//                ->orWhere('monday', $day)
//                ->orWhere('tuesday', $day)
//                ->orWhere('wednesday', $day)
//                ->orWhere('thursday', $day)
//                ->orWhere('friday', $day)
//                ->orWhere('saturday', $day)
//                ->where('hour', '>=',  $hour)
//                ->where('minute', '>=',  $minute);
//        });
    }

    public function processOnce(){

        //note, set status to ongoing once the process has started
        $day = strtolower(date('l'));
        $hour = intval(date('G'));
        $minute = intval(date('i'));

        $mail_lists = MailList::where('daily', false)
            ->where(function ($query) use ($hour, $minute, $day) {
                $query->where('hour', '<=',  $hour)
                    ->where('active', true)
                    ->where("{$day}_run", false)
                    ->where($day, true)
                    ->where('minute', '<=',  $minute);
            })
            ->orWhere(function ($query) use ($hour, $minute, $day) {
                $query->where('daily', false)
                    ->where('status', 'ongoing')
                    ->where('active', true);
            })
            ->with(['email'])
            ->get();

//        dd($mail_lists, $hour, $minute);

        $this->runProcess($mail_lists, "once");

    }

    private function runProcess($mail_lists, $type = null){



        $day = strtolower(date('l'));

        foreach ($mail_lists as $list){

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
//                        dd($e->getMessage());
                    }
                    $sent++;
                }

                //update sent
                $this->mailSent->updateSent($sent);

                //handle after email send actions
                $pending_items = $list->pendingItems;
                if($pending_items < 1){
                    if($list->daily){
                        $listUpdate['status'] = 'pending';
                        $listUpdate["{$day}_run"] = true;
                        $listUpdate['round'] = $list->round + 1;
                        $list->update($listUpdate);
                    }else{
                        $listUpdate['status'] = 'completed';
                        $listUpdate['round'] = $list->round + 1;
                        $listUpdate["{$day}_run"] = true;
                        $listUpdate['active'] = false;
                        $list->update($listUpdate);
                    }

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
        }
        //dd($mail_lists->count());
    }

    //this process gets tasks set to be processed
    public function readyTaskRun(){
        $day = strtolower(date('l', strtotime('yesterday')));
        $hour = intval(date('G'));
        $minute = intval(date('i'));
        $mail_lists = MailList::where('daily', true)
            ->where(function ($query) use ($day) {
                $query->where('active', true)
                    ->where("{$day}_run", true)
                    ->where($day, true);
            })->take(20)->get();
        foreach ($mail_lists as $list){
            DB::beginTransaction();
            $update["{$day}_run"] = false;
            $list->update($update);
            DB::commit();
        }
    }
}
