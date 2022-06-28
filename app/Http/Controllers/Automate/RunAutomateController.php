<?php

namespace App\Http\Controllers\Automate;

use App\Http\Controllers\Controller;
use App\Models\Automate;
use App\Models\MailList;
use App\Models\MailListItem;
use App\Models\Member;
use App\Models\Stage;
use App\Services\Automate\RunAutoListService;
use App\Traits\Search\MemberSearch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RunAutomateController extends Controller
{
    use MemberSearch;

    protected $automateService;

    public function __construct(RunAutoListService $autoListService)
    {
        $this->automateService = $autoListService;
    }

    /**
     * Initiate start at the automate level
     */
    public function initiate(){
        $automates = Automate::where('active', true)->get();

        foreach ($automates as $automate){
            $this->begin($automate);
        }

        return response()->json(['action completed']);
    }

    /**
     * @param Automate $automate
     * starts at the stage level, runs the first stage that is still below the current round process
     */
    function begin(Automate $automate){
        if($automate->stages->count() > 0){
            $stage = Stage::where('automate_id', $automate->uuid)
                ->where('active', true)
                ->where('round', '<', $automate->round)
                ->orderBy('position', 'asc')
                ->first();

            if(!empty($stage)){

                $this->stagePhase($automate, $stage);
            }
        }
    }

    /**
     * @param Automate $automate
     * @param Stage $stage
     * checks that stages' mail list has recipients, generates recipient if stages' mail list has no recipient
     */
    function stagePhase(Automate $automate,Stage $stage){
        // get maillist
        $maillist = $stage->mailList;
        if(!empty($maillist)){
            if($maillist->listItems->count() > 0){
                if($maillist->roundCompleted){
                    //rebuild
                    $this->automateService->buildList($stage);
//                    dd('rebuilding new round');

                }else{
                    //continue existing job
                    $this->mailListPhase($automate, $stage);
//                    dd('running existing job');
                }
            }else{
                //generate list
                //todo - generate list from stage settings
                $this->automateService->buildList($stage);
//                dd("generated list");
            }
        }
        // get maillistitem
    }

    /**
     * @param Automate $automate
     * @param Stage $stage
     * Runs the mail on the day and time set by the mail list. does nothing if it is not the day or time has not passed.
     */
    public function mailListPhase(Automate $automate, Stage $stage){


        $day = strtolower(date('l'));
        $hour = intval(date('G'));
        $minute = intval(date('i'));

        $mail_list = MailList::where('type', 'automated')
            ->where('uuid', $stage->mail_list_id)
            ->where(function ($query) use ($hour, $minute, $day) {
                $query->where('hour', '<=',  $hour)
                    ->where('active', true)
                    ->where("{$day}_run", false)
                    ->where($day, true)
                    ->where('minute', '<=',  $minute);
            })
            ->orWhere(function ($query) use ($hour, $minute, $day) {
                $query->where('type', 'automated')
                    ->where('status', 'ongoing')
                    ->where('active', true);
            })
            ->with(['email'])
            ->first();


        if(!empty($mail_list)){
            $this->automateService->runProcess($automate, $stage, $mail_list);
        }

    }
}
