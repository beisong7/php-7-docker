<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Email;
use App\Models\MailList;
use App\Models\MailListItem;
use App\Services\MailList\AddRecipientService;
use App\Traits\General\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MailListController extends Controller
{
    use Utility;

    protected $addService;

    public function __construct(AddRecipientService $addService)
    {
        $this->addService = $addService;
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $lists = MailList::orderBy('updated_at', 'desc')->paginate(50);
        return view('dashboard.mail_list.index')->with(
            [
                'lists'=>$lists
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        $mails = Email::where('active', true)->select(['uuid', 'subject', 'title', 'created_at'])->orderBy('updated_at','desc')->get();
        return view('dashboard.mail_list.create')->with(
            [
                'mails'=>$mails
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate(
            [
                'title'=>'required',
                'occurrence_type'=>'required',
                'hour'=>'required',
                'minutes'=>'required',
                'email_id'=>'required',
            ]
        );


        $title = $request->input('title');
        $titleExist = MailList::where('title', $title)->first();
        if(!empty($titleExist)){return back()->withErrors(['Title already exists'])->withInput();}
        $occurrence_type = $request->input('occurrence_type');
        $hour = $request->input('hour');
        $minutes = $request->input('minutes');
        $email_id = $request->input('email_id');

        $mail_list['sunday'] = $request->input('sunday')==='on'?true:false;
        $mail_list['monday'] = $request->input('monday')==='on'?true:false;
        $mail_list['tuesday'] = $request->input('tuesday')==='on'?true:false;
        $mail_list['wednesday'] = $request->input('wednesday')==='on'?true:false;
        $mail_list['thursday'] = $request->input('thursday')==='on'?true:false;
        $mail_list['friday'] = $request->input('friday')==='on'?true:false;
        $mail_list['saturday'] = $request->input('saturday')==='on'?true:false;
        $mail_list['active'] = false;
        $mail_list['round'] = 1;
        $mail_list['uuid'] = $this->makeUuid();
        $mail_list['admin_id'] = $request->user()->uuid;
        $mail_list['email_id'] = $email_id;
        $mail_list['title'] = $title;
        $mail_list['status'] = 'inactive';
        $mail_list['daily'] = $occurrence_type==='daily'?true:false;
        $mail_list['type'] = $occurrence_type;
        $mail_list['hour'] = $hour;
        $mail_list['minute'] = $minutes;

        DB::beginTransaction();
        MailList::create($mail_list);
//        dd($mail_list);
        DB::commit();
        return redirect()->route('maillist.index')->withMessage('New mail list created. add recipients to list to enable');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MailList  $mailList
     * @return \Illuminate\Http\Response
     */
    public function show(MailList $mailList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MailList  $mailList
     */
    public function edit($uuid)
    {
        $mail_list = MailList::whereUuid($uuid)->first();
        if(!empty($mail_list)){
            $mails = Email::where('active', true)->select(['uuid', 'subject', 'title', 'created_at'])->orderBy('updated_at','desc')->get();
            return view('dashboard.mail_list.edit')->with(
                [
                    'mails'=>$mails,
                    'list'=>$mail_list
                ]
            );
        }

        return redirect()->route('maillist.index')->withErrors(['Resource not found']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MailList  $mailList
     */
    public function update(Request $request, $uuid)
    {
        $mail_list = MailList::whereUuid($uuid)->first();
        if(!empty($mail_list)){

            $request->validate(
                [
                    'title'=>'required',
                    'occurrence_type'=>'required',
                    'hour'=>'required',
                    'minutes'=>'required',
                    'email_id'=>'required',
                ]
            );


            $title = $request->input('title');
            if($title!==$mail_list->title){
                $titleExist = MailList::where('title', $title)->first();

                if(!empty($titleExist)){return back()->withErrors(["New title ({$title}) already exists"])->withInput();}
            }

            $occurrence_type = $request->input('occurrence_type');
            $hour = $request->input('hour');
            $minutes = $request->input('minutes');
            $email_id = $request->input('email_id');

            $data['sunday'] = $request->input('sunday')==='on'?true:false;
            $data['monday'] = $request->input('monday')==='on'?true:false;
            $data['tuesday'] = $request->input('tuesday')==='on'?true:false;
            $data['wednesday'] = $request->input('wednesday')==='on'?true:false;
            $data['thursday'] = $request->input('thursday')==='on'?true:false;
            $data['friday'] = $request->input('friday')==='on'?true:false;
            $data['saturday'] = $request->input('saturday')==='on'?true:false;

            $data['sunday_run'] = false;
            $data['monday_run'] = false;
            $data['tuesday_run'] = false;
            $data['wednesday_run'] = false;
            $data['thursday_run'] = false;
            $data['friday_run'] = false;
            $data['saturday_run'] = false;

            $data['email_id'] = $email_id;
            $data['title'] = $title;
            $data['daily'] = $occurrence_type==='daily'?true:false;
            $data['type'] = $occurrence_type;
            $data['hour'] = $hour;
            $data['minute'] = $minutes;

            DB::beginTransaction();
            $mail_list->update($data);
//        dd($mail_list);
            DB::commit();

            return back()->withMessage("Mail list has been updated");
        }

        return redirect()->route('maillist.index')->withErrors(['Resource not found']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MailList  $mailList
     * @return \Illuminate\Http\Response
     */
    public function destroy(MailList $mailList)
    {
        //
    }

    public function addRecipient($uuid){
        $list = MailList::whereUuid($uuid)->first();
        return view('dashboard.mail_list.add_recipient')->with(
            [
                'list'=>$list
            ]
        );
    }

    public function storeRecipient(Request $request){
        dd($request->all());
        return redirect()->route('maillist.index')->withMessage('Recipients added to mail lists.');
    }

    public function addRecipientToList(Request $request, $uuid){
        $option = $request->input('option');
        return $this->addService->addOptionToList($option, $uuid);
    }

    public function addRecipientWithSearch(Request $request, $uuid){
        return $this->addService->addFromSearch($request, $uuid);
    }

    public function downloadTemplate(){
        $file = public_path('raw_resource/upload-template.xlsx');
        if(file_exists($file)){
            return response()->download($file, 'upload-template.xlsx');
        }
        return back()->withErrors(['Resource not found']);

    }

    public function simpleAdd(Request $request){
        $uuid = $request->input('list_id');
        $list = MailList::whereUuid($uuid)->first();
        if(!empty($list)){
            $email = $request->input('email');
            if(empty(MailListItem::where('uuid', $uuid)->where('email', $email)->first())){
                $data['uuid'] = $this->makeUuid();
                $data['mail_list_id'] = $uuid;
                $data['email'] = $email;
                $data['first_name'] = $request->input('first_name');
                $data['round'] = 0;
                DB::beginTransaction();
                MailListItem::create($data);
                DB::commit();
                return back()->withMessage('New recipient added.');
            }
        }
        return back()->withErrors(['Resource not found.']);
    }

    public function toggle($uuid){
        $list = MailList::whereUuid($uuid)->first();
        if(!empty($list)){
            if($list->active){
                $msg = "list ({$list->title}) deactivated";
                $list->active = false;
                $list->status = 'inactive';
            }else{
                $msg = "list ({$list->title}) is now active";
                $list->active = true;
                $list->status = 'active';
            }
            $list->update();
            return back()->withMessage($msg);
        }
        return back()->withErrors(['Resource not found.']);
    }

    public function runList($uuid){
        $list = MailList::whereUuid($uuid)->first();
        if(!empty($list)){
            DB::beginTransaction();
            $data['status'] = 'ongoing';
            $list->update($data);
            DB::commit();
            return back()->withMessage("Mail list, {$list->title} now running.");
        }
        return back()->withErrors(['Resource not found.']);
    }

    public function recipients($uuid){
        $list = MailList::whereUuid($uuid)->first();
        if(!empty($list)){
            $recipients = MailListItem::where('mail_list_id', $list->uuid)->orderBy('updated_at', 'desc')->paginate(50);
            return view('dashboard.mail_list.recipients')->with(
                [
                    'list'=>$list,
                    'recipients'=>$recipients
                ]
            );
        }
        return back()->withErrors(['Resource not found.']);
    }

    public function removeRecipient(Request $request){
        $uuid = $request->input('list_id');
        $re_uuid = $request->input('recipient_id');
        $list = MailList::whereUuid($uuid)->first();
        if(!empty($list)){
            $recipient = MailListItem::where('mail_list_id', $list->uuid)->where('uuid', $re_uuid)->first();
            if(!empty($recipient)){
                $recipient->delete();
                return back()->withMessage("Recipient has been removed");
            }
        }
        return back()->withErrors(['Resource not found.']);
    }

    public function removeAllRecipient($list_id){
        $list = MailList::whereUuid($list_id)->first();
        if(!empty($list)){
            $recipients = $list->listItems;
            if($recipients->count()>0){
                MailListItem::where('mail_list_id', $list_id)->delete();
                return back()->withMessage("All Recipients has been removed");
            }
            return back()->withErrors(['List already empty']);
        }
        return back()->withErrors(['Resource not found.']);
    }

    public function addOneToList($uuid){
        $list = MailList::whereUuid($uuid)->first();
        if(!empty($list)){
            return view('dashboard.mail_list.add_one_to_list')->with(
                [
                    'list'=>$list,
                ]
            );
        }
        return back()->withErrors(['Resource not found.']);

    }

}
