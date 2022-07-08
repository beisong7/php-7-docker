<?php

namespace App\Traits\General;

use Illuminate\Support\Facades\Mail;

trait Mailer{

    public function sendMail($title, $to, $subject, $first_name, $data, $view, array $attachment=null){

        try{
            $from = env('MAIL_FROM_ADDRESS','test@example.com');
            Mail::send($view, $data, function ($mail) use ($from, $to, $title, $subject, $first_name, $attachment) {
                $mail->from($from, $title);
                $mail->to($to, $first_name)->subject($subject);

                if(!empty($attachment)){
                    foreach ($attachment as $file){
                        $mail->attach($file);
                    }
                }

            });
        }catch (\Exception $e){
//            dd($e->getMessage());
        }

    }
}
