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
use App\Traits\General\Utility;
use App\Traits\Search\MemberSearch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddRecipientService
{

    use MemberSearch, Utility;

    /**
     * @param $option - this is the query options that was used to get the list
     * @param $list_id
     */
    public function addOptionToList($option, $list_id){
        $list = MailList::whereUuid($list_id)->first();
        if(!empty($list)){
            $list_name = $list->title;
            $res = $this->getRecipientsFromOption($option, $list_id);
            if($res[0]){
                $count = $this->createRecipientsForList($res[1], $list_id);
                return redirect()->route('maillist.index')->withMessage("{$count} recipients added to {$list_name} mail-list");
            }
        }
        return back()->withErrors(['Unable to complete. Contact Technical Team']);

    }

    public function addFromSearch($request, $list_id){
        $list = MailList::whereUuid($list_id)->first();
        if(!empty($list)){
            $list_name = $list->title;

            $data = $this->startQuery($request);

            //dd($data);

            $count = $this->createRecipientsForList($data, $list_id);

            return redirect()->route('maillist.index')->withMessage("{$count} recipients added to {$list_name} mail-list");
        }
        return back()->withErrors(['List not found']);
    }



    private function getRecipientsFromOption($option, $list_id){
        try{
            return [true, 'data'];
        }catch (\Exception $e){
            return [false , $e->getMessage()];
        }
    }

    public function createRecipientsForList($recipient_object, $list_id){
        $count = 0;
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
                $count++;
            }
        }
        return $count;
    }
}