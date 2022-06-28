<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MailList extends Model
{
    protected $fillable = [
        'uuid',
        'admin_id',
        'email_id',
        'title',
        'status',
        'import_key',
        'daily',
        'type',
        'recursive_day',
        'hour',
        'minute',
        'round',
        'sunday',
        'sunday_run',
        'monday',
        'monday_run',
        'tuesday',
        'tuesday_run',
        'wednesday',
        'wednesday_run',
        'thursday',
        'thursday_run',
        'friday',
        'friday_run',
        'saturday',
        'saturday_run',
        'active',
    ];

    public function email(){
        return $this->hasOne(\App\Models\Email::class, 'uuid', 'email_id');
    }

    public function getConfigAttribute(){
        return $this->daily?"runs daily":"runs once";
    }

    public function listItems(){
        return $this->hasMany(MailListItem::class, 'mail_list_id', 'uuid');
    }

    public function getRecipientsAttribute(){
        return MailListItem::where('mail_list_id',$this->uuid)->select(['id'])->get()->count();
    }

    public function getPendingItemsAttribute(){
        return DB::table('mail_list_items')
            ->where('mail_list_id', $this->uuid)
            ->where('round', '<', $this->round)
            ->get()
            ->count();

    }

    public function getProgressAttribute(){
        $a = DB::table('mail_list_items')
            ->where('mail_list_id', $this->uuid)
            ->where('round', '=', $this->round)
            ->get()
            ->count();
        $b = DB::table('mail_list_items')
            ->where('mail_list_id', $this->uuid)
            ->get()
            ->count();

        return $b>0?intval(($a/$b)*100):0;
    }

    public function getBadgeAttribute(){
        switch ($this->status){
            case 'inactive':
                return 'red';
                break;
            case 'ongoing':
                return 'cyan';
                break;
            case 'completed':
                return 'cyan';
                break;
            default:
                return 'blue';
                break;
        }

    }

    public function getbgColorAttribute(){
        switch ($this->status){
            case 'inactive':
                return 'danger';
                break;
            case 'completed':
                return 'success';
                break;
            case 'ongoing':
                return 'success';
                break;
            default:
                return 'primary';
                break;
        }

    }

    public function stage(){
        return $this->belongsTo(Stage::class,'uuid','mail_list_id');
    }

    public function getRoundCompletedAttribute(){
//        $listItem = MailListItem::where('mail_list_id', $this->uuid)->select(['round'])->get();
//        $round = $this->round;
//        foreach ($listItem as $item){
//            if($round!==$item->round){
//                return false;
//            }
//        }
//        return true;
        $listItem = MailListItem::where('mail_list_id', $this->uuid)->where('round', '<', $this->round)->first();
        if(!empty($listItem)){
            return false;
        }
        return true;
    }




}
