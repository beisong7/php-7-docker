<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Email;
use App\Services\MailList\ProcessRecipientService;
use App\Services\MailList\SentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrivateMailController extends Controller
{
    protected $mailService, $mailSent;

    public function __construct(ProcessRecipientService $service, SentService $sentService)
    {
        $this->mailService = $service;
        $this->mailSent = $sentService;
    }

    public function index(){
        $emails = Email::where('private', true)->orderBy('updated_at', 'desc')->paginate(50);
        return view('dashboard.private_mail.index')
            ->with([
                'emails'=>$emails
            ]);
    }

    public function sendService(){
        $emails = Email::where('sent', false)->take(25)->get();
        foreach ($emails as $email){
            $this->processSend($email);
        }
    }

    public function send($uuid){
        $email = Email::whereUuid($uuid)->first();
        if(!empty($email)){
            $this->processSend($email);
            return back()->withMessage('One item Sent');
        }

        return back()->withErrors(['Resource not found']);
    }

    public function processSend($email){
        DB::beginTransaction();
        //send email

        try{
            $this->mailService->handleOne($email);
        }catch (\Exception $e){
            //dd($e->getMessage());
        }
        $this->mailSent->updateSent(1);
        $data['sent'] = true;
        $email->update($data);
        DB::commit();
    }
}
