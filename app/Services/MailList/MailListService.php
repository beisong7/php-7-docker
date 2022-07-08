<?php


namespace App\Services\MailList;


use App\Models\MailList;
use App\Models\MailListItem;
use App\Traits\General\Utility;
use Illuminate\Http\Request;

class MailListService
{
    use Utility;
    public static function find($val, $key = 'uuid'){
        return MailList::where($key, $val)->first();
    }

    public static function addToList($list_id, $email, $first_name){
        MailListItem::create(
            [
                'uuid' => Utility::generateID(),
                'mail_list_id' => $list_id,
                'email' => $email,
                'first_name' => $first_name,
            ]
        );
    }

    public static function create(Request $request, $data){
        $title = $request->input('title');

//        $titleExist = MailList::where('title', $title)->first();
//        if(!empty($titleExist)){return back()->withErrors(['Title already exists'])->withInput();}
        $occurrence_type = $request->input('occurrence_type');
        $hour = $request->input('hour');
        $minutes = $request->input('minutes');
        $email_id = $data['email_id'];

        $mail_list['sunday'] = $request->input('sunday')==='on'?true:false;
        $mail_list['sunday_run'] = false;

        $mail_list['monday'] = $request->input('monday')==='on'?true:false;
        $mail_list['monday_run'] = false;

        $mail_list['tuesday'] = $request->input('tuesday')==='on'?true:false;
        $mail_list['tuesday_run'] = false;

        $mail_list['wednesday'] = $request->input('wednesday')==='on'?true:false;
        $mail_list['wednesday_run'] = false;

        $mail_list['thursday'] = $request->input('thursday')==='on'?true:false;
        $mail_list['thursday_run'] = false;

        $mail_list['friday'] = $request->input('friday')==='on'?true:false;
        $mail_list['friday_run'] = false;

        $mail_list['saturday'] = $request->input('saturday')==='on'?true:false;
        $mail_list['saturday_run'] = false;

        $start_sending = $data['start_sending'];
        $mail_list['active'] = true;
        $mail_list['status'] = $start_sending==='on'?'ongoing':'active';
        $mail_list['round'] = 1;
        $mail_list['uuid'] = Utility::generateID();
        $mail_list['admin_id'] = $request->user()->uuid;
        $mail_list['email_id'] = $email_id;
        $mail_list['title'] = $title;
        $mail_list['daily'] = $occurrence_type==='daily'?true:false;
        $mail_list['type'] = $occurrence_type;
        $mail_list['hour'] = $hour;
        $mail_list['minute'] = $minutes;

        $mail_list = MailList::create($mail_list);
        return $mail_list;
    }
}
