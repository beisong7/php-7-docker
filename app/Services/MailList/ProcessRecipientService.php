<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 06/12/2020
 * Time: 7:09 AM
 */

namespace App\Services\MailList;



use App\Models\Unsubscribe;
use App\Traits\Campaign\UnsubLink;
use App\Traits\General\Mailer;


class ProcessRecipientService
{
    use Mailer, UnsubLink;

    public function processOne($recipient, $mail_list){

        $email = $mail_list['email'];
        $body = $email->body;
        $body = str_replace('__name__', $recipient->first_name, $body);
        $body = str_replace('__email__', $recipient->email, $body);
        $body = str_replace('__year__', date('Y'), $body);
        $unlink = $this->generate($email);
        $body = str_replace('http://__unsubscribe__', $unlink, $body);

//        dd($recipient);

        $data = [
            'body'=>$body
        ];

        $title = !empty($email->sender)?$email->sender:'NYCC Membership';

        //check if item is in unsubscribe list
        $fail_send = Unsubscribe::where('email', $email)->first();
        if(empty($fail_send)){
            $this->sendMail("{$title}", $recipient->email, $email->subject, $recipient->first_name, $data, "emails.body");
        }

        $rec['round'] = $mail_list->round;
        $recipient->update($rec);

    }

    public function handleOne($email){

        $body = $email->body;
        $body = str_replace('__year__', date('Y'), $body);
        $unlink = $this->generate($email->recipient);
        $body = str_replace('http://__unsubscribe__', $unlink, $body);
        $data = [
            'body'=>$body
        ];
        $title = !empty($email->sender)?$email->sender:'NYCC Membership';

        $fail_send = Unsubscribe::where('email', $email->recipient)->first();
        if(empty($fail_send)){
            $this->sendMail("{$title}", $email->recipient, $email->subject, "", $data, "emails.body");
        }
    }
}