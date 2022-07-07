<?php


namespace App\Services\Automate;


use App\Models\Group;
use App\Models\GroupMember;
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
                            $group = Group::where("unique_key", $list_key)->first();
                            // UPDATE THE ABOVE QUERY TO DB::RAW FOR PERFORMANCE
                            if(!empty($group)){
                                MemberService::addMemberToGroup($member->uuid, $group->uuid);
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
        // UPDATE THE ABOVE ELOQUENT TO DB::RAW QUERY FOR PERFORMANCE

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

    /**
     * add a member to a group
     * @param $member_id
     * @param $group_id
     */
    public static function addMemberToGroup($member_id, $group_id){
        $exist = GroupMember::where('group_id', $group_id)->where('member_id', $member_id)->first();
        if(empty($exist)){
            GroupMember::create(
                [
                    "group_id"=>$group_id,
                    "member_id"=>$member_id,
                ]
            );
        }
    }

    public static function removeMemberFromGroup($member_id, $group_id){
        $exist = GroupMember::where('group_id', $group_id)->where('member_id', $member_id)->first();
        if(!empty($exist)){
            $exist->delete();
        }
    }
}
