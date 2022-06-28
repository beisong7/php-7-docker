<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 29/12/2020
 * Time: 7:53 AM
 */

namespace App\Services\Automate;


use App\Models\Automate;
use App\Models\Stage;

class AutomateServices
{
    protected $activityServices;

    public function __construct(ActivityServices $activityServices)
    {
        $this->activityServices = $activityServices;
    }

    public function resetAutomateCycle(Automate $automate){
        //check if all stages are complete and increase round
        if(!empty($automate)){
            $complete = true;
            foreach ($automate->stages as $stage){
                if(!$this->activityServices->checkStageCompletion($stage)){
                    $complete = false;
                }
            }

            if($complete){
                //update round;
                $automate->increment('round');
            }
        }
        return $automate;
    }

    public function initNextAutomateStage(Automate $automate, Stage $stage){
        $stages = Stage::where('automate_id', $automate->uuid)->orderBy('position', 'asc')->get();
        $takeActionPos = null;
        foreach ($stages as $aStage){

            if($aStage->uuid===$stage->uuid){
                $takeActionPos = $stage->position + 1;
            }
            if($aStage->position===$takeActionPos){
//                $data['round']
            }
        }
        return $automate;
    }

}