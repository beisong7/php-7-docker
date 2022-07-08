<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Email;
use App\Models\EmailTemplate;
use App\Models\Group;
use App\Models\MailList;
use App\Services\Newsletter\NewsletterService;
use App\Traits\General\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmailController extends Controller
{
    use Utility;
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $emails = Email::orderBy('id', 'desc')->where('admin_id', '!=', 'api-service')->paginate(50);
        return view('dashboard.email.index')->with(
            [
                'emails'=>$emails
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $templates = EmailTemplate::select(['title', 'body'])->orderBy('updated_at', 'desc')->get();
        $dTemplate = EmailTemplate::where('current', true)->first();
        $template = " ";
        if(!empty($dTemplate)){
            $template=$dTemplate->body;
        }

        return view('dashboard.email.create')->with([
            'templates'=>$templates,
            'template'=>$template
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject'=>'required',
            'title'=>'required',
            'body'=>'required',
            'type'=>'required',
        ]);

        $type = $request->input('type');
        if($type==='private'){
            $email['sent'] = false;
            if(empty($request->input('email'))){
                return back()->withErrors(['Recipient email cannot be empty if the email is private'])->withInput();
            }
        }
        $email['uuid'] = $this->makeUuid();
        $email['admin_id'] = $request->user()->uuid;
        $email['subject'] = $request->input('subject');
        $email['title'] = $request->input('title');
        $email['sender'] = $request->input('sender');
        $email['recipient'] = $request->input('email');
        $email['body'] = $request->input('body');
        $activate = $request->input('activate');
        $email['private'] = $type==='private'?true:false;

        $email['active'] = $activate==='on'?true:false;

        DB::beginTransaction();

        Email::create($email);

        DB::commit();
        return redirect()->route('email.index')->withMessage('New email item created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function show(Email $email)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Email  $email
     */
    public function edit($uuid)
    {
        $email = Email::whereUuid($uuid)->first();
        $templates = EmailTemplate::select(['title', 'body'])->orderBy('updated_at', 'desc')->get();
        if(!empty($email)){
            return view('dashboard.email.edit')->with([
                'email'=>$email,
                'templates'=>$templates
            ]);
        }

        return back()->withErrors(['Resource not found']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uuid)
    {
        $email = Email::whereUuid($uuid)->first();
        if(!empty($email)){
            $request->validate([
                'subject'=>'required',
                'title'=>'required',
                'body'=>'required',
                'type'=>'required',
            ]);

            $type = $request->input('type');
            if($type==='private'){
                //$email['sent'] = false;
                if(empty($request->input('email'))){
                    return back()->withErrors(['Recipient email cannot be empty if the email is private'])->withInput();
                }
            }

            $data['subject'] = $request->input('subject');
            $data['title'] = $request->input('title');
            $data['sender'] = $request->input('sender');
            $data['recipient'] = $request->input('email');
            $data['body'] = $request->input('body');

            $data['private'] = $type==='private'?true:false;

            DB::beginTransaction();

            $email->update($data);

            DB::commit();
            return back()->withMessage("Email updated");
        }

        return back()->withErrors(['Resource not found']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function destroy(Email $email)
    {
        //
    }

    public function pop($uuid){
        $email = Email::whereUuid($uuid)->first();
        if(!empty($email)){
            $email->delete();
            return back()->withMessage('One item deleted');
        }

        return back()->withErrors(['Resource not found']);
    }

    public function toggle($uuid){
        $email = Email::whereUuid($uuid)->first();
        if(!empty($email)){
            if($email->active){
                $msg = "one email Seactivated";
                $email->active = false;
            }else{
                $msg = "one email Activated";
                $email->active = true;
            }
            $email->update();
            return back()->withMessage($msg);
        }
        return back()->withErrors(['Resource not found.']);
    }

    /**
     * Create newsletter
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function newsletter(){
        $templates = EmailTemplate::select(['title', 'body'])->orderBy('updated_at', 'desc')->get();
        $dTemplate = EmailTemplate::where('current', true)->first();
        $groups = Group::get();
        $template = " ";
        if(!empty($dTemplate)){
            $template=$dTemplate->body;
        }

        return view('dashboard.email.create_newsletter')->with([
            'templates'=>$templates,
            'template'=>$template,
            'groups'=>$groups
        ]);
    }

    public function createNewsletter(Request $request){
//        dd($request->all());
        $request->validate([
            'subject'=>'required',
            'title'=>'required',
            'body'=>'required',
            'hour'=>'required',
            'minutes'=>'required',
        ]);
        $res = NewsletterService::createNewsletter($request);
        if($res){
            return redirect()->route('maillist.index')->withMessage("New newsletter created");
        }
        return back()->withErrors(['Could not complete. Try again'])->withInput();


    }
}
