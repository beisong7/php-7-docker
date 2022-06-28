<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Email;
use App\Models\MailList;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard(){
        $mail_lists = MailList::orderBy('updated_at','desc');
        $lists  = $mail_lists->take(10)->get();
        $pending = $mail_lists
            ->where('status', 'pending')
            ->get()->count();
        $ongoing = MailList::where('status', 'ongoing')->get()->count();

        $api_email = Email::where('admin_id', 'api-service')->select(['id', 'sent']);
        $all_api = $api_email->get()->count();
        $sent_api = $api_email->where('sent', true)->get()->count();

        return view('dashboard.home.index')
            ->with(
                [
                    'lists'=>$lists,
                    'pending'=>$pending,
                    'ongoing'=>$ongoing,
                    'all_api'=>$all_api,
                    'sent_api'=>$sent_api,
                ]
            );
    }

    public function tasks(Request $request){
        $mail_lists = MailList::orderBy('updated_at','desc')->paginate(50);
        return view('dashboard.tasks.index')
            ->with(
                [
                    'lists'=>$mail_lists,
                ]
            );
    }
}
