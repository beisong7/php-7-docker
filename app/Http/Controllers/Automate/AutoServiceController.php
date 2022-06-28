<?php

namespace App\Http\Controllers\Automate;

use App\Http\Controllers\Controller;
use App\Models\Automate;
use App\Models\MailList;
use App\Models\Stage;
use App\Services\Automate\AutomateServices;
use Illuminate\Http\Request;

class AutoServiceController extends Controller
{
    protected $automateServices;

    public function __construct(AutomateServices $automateServices)
    {
        $this->automateServices = $automateServices;
    }

    public function runReset(){
        $automates = Automate::where('active', true)->get();
        foreach ($automates as $auto){
            $this->manageStages($auto, "reset");
        }
        return response()->json(['action complete']);
    }

    function manageStages(Automate $automate, $action){
        //reset checks that a complete cycle for an automate is completed on all stages
        //it then increases the round value and the next cycle begins with that new value
        if($action==="reset"){
            $this->automateServices->resetAutomateCycle($automate);
        }
    }
}
