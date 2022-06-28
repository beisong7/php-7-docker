<?php

namespace App\Http\Controllers;

use App\Models\Email;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function testEmailUi(){
        $email = Email::inRandomOrder()->first();
        if(!empty($email)){
            $body = $email->body;
            $body = str_replace('__name__', 'tester', $body);
            return view('emails.body')->with(
                [
                    'body'=>$body
                ]
            );
        }
        return ['no email found'];
    }
}
