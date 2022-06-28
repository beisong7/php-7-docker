<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 29/12/2020
 * Time: 7:53 AM
 */

namespace App\Services\Automate;

use App\Models\Stage;

class ActivityServices
{

    public function checkStageCompletion(Stage $stage){
        if(!empty($stage)){
            $round = $stage->round;
            if(!empty($stage->mailList)){
                if($round===$stage->mailList->round){
                    return $stage->mailList->roundCompleted;
                }
            }
            return false;
        }
    }
}