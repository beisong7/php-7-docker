<?php


namespace App\Services\MailList;


use App\Models\MailList;
use App\Models\MailListItem;
use App\Traits\General\Utility;

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
}
