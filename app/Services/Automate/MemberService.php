<?php


namespace App\Services\Automate;


use App\Models\Member;
use App\Services\MailList\MailListService;
use App\Traits\General\Utility;
use Illuminate\Http\Request;

class MemberService
{
    /**
     * handles the sync of members from main DB to in-app db, accepts data in the format below
     * [
     *    [
     *      'first_name'=>'john',
     *      'last_name'=>'doe',
     *      'email'=>'johndoe@example.com',
     *      'mail_lists'=>['list-one','list-two','list-three'],
     *    ],
     *    [...],
     *    [...]
     * ]
     * The 'mail_lists' is an array of special or unique names which should exist on the system
     * #the mail list specifies the existing list this account belongs to
     *
     * @param $payload
     */
    public static function handleSync($payload){
        if(is_array($payload)){
            foreach ($payload as $data){
                $first_name = $data['first_name'];
                $last_name = $data['last_name'];
                $email = $data['email'];
                $member = self::createMember($first_name, $last_name, $email);
                if(!empty($member)){
                    $mail_lists = $data['mail_lists'];
                    if(is_array($mail_lists)){
                        foreach ($mail_lists as $list_key){
                            $list = MailListService::find($list_key, 'import_key');
                            if(!empty($list)){
                                MailListService::addToList($list->uuid, $email, $first_name);
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * Creates a member in the general list after checking if it is not already existing
     * @param $first_name
     * @param $last_name
     * @param $email
     * @return |null
     */
    public static function createMember($first_name, $last_name, $email){
        //check if exist already
        $exist = Member::where('email', $email)->first();
        if(empty($exist)){
            return Member::create(
                [
                    'uuid' => Utility::generateID(),
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'email' => $email,
                ]
            );
        }
        return null;

    }

    /**
     * @param $val
     * @param string $key
     * @return mixed
     */
    public static function find($val, $key = 'uuid'){
        return Member::where($key, $val)->first();
    }


    public static function lastItem($selection = ['email']){
        return Member::orderBy('id','desc')->select($selection)->first();
    }
}