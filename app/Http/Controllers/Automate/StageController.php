<?php

namespace App\Http\Controllers\Automate;

use App\Http\Controllers\Controller;
use App\Models\Automate;
use App\Models\MailList;
use App\Models\Stage;
use App\Traits\General\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StageController extends Controller
{
    use Utility;

    public function stageCreate($uuid){
        $auto = Automate::whereUuid($uuid)->first();
        if(!empty($auto)){

            $query = MailList::orderBy('updated_at','desc');
            foreach ($auto->stages as $stage){
                if(!empty($stage->mailList)){
                    $query = $query->where('uuid', '!=', $stage->mailList->uuid);
                }
            };
            $query = $query->where('type','automated');
            $query = $query->select(['title','uuid', 'updated_at']);
            $data = $query->get();
//            dd($data);

            return view('dashboard.stage.create')
                ->with([
                    'auto'=>$auto,
                    'lists'=>$data
                ]);
        }
        return back()->withErrors(['Resource not found']);
    }

    public function stageStore(Request $request, $uuid){
        $auto = Automate::whereUuid($uuid)->first();
        if(!empty($auto)){

            $pos = intval($auto->stages->count());
            $request->validate([
                'title'=>'required',
                'list_id'=>'required',
                'list_filter'=>'required'
            ]);


            $list_id = $request->input('list_id');
            $exist = Stage::where('mail_list_id', $list_id)->where('automate_id', $auto->uuid)->first();
            if(!empty($exist)){
                return back()->withErrors(["A stage ({$exist->title}) already has the same email list. Delete or Select another option."])->withInput();
            }

            $data['title'] = $request->input('title');
            $data['mail_list_id'] = $list_id;
            $data['list_filter'] = $request->input('list_filter');
            $data['uuid'] = $this->makeUuid();
            $data['admin_id'] = $request->user()->uuid;
            $data['automate_id'] = $auto->uuid;
            $data['rebuild_round'] = 0;
            $data['round'] = 0;
            $data['position'] = $pos+1;
            $data['process'] = 'inactive';
            $data['active'] = false;

            DB::beginTransaction();
            Stage::create($data);
            DB::commit();

            return redirect()->route('automate.manage', $auto->uuid)->withMessage('New stage created');
        }
        return back()->withErrors(['Resource not found']);
    }
    //
    public function stageUpdate(Request $request, $uuid){
        $stage = Stage::whereUuid($uuid)->first();
        $auto = $stage->automate;
        if(!empty($stage) && !empty($auto)){

            $request->validate([
                'title'=>'required',
                'list_id'=>'required',
                'list_filter'=>'required'
            ]);

            $list_id = $request->input('list_id');
            $exist = Stage::where('mail_list_id', $list_id)->where('automate_id', $auto->uuid)->where('uuid', '!=', $stage->uuid)->first();
            if(!empty($exist)){
                return back()->withErrors(["A stage ({$exist->title}) already has the same email list. Delete or Select another option."])->withInput();
            }

            $data['title'] = $request->input('title');
            $data['mail_list_id'] = $request->input('list_id');
            $data['list_filter'] = $request->input('list_filter');

            DB::beginTransaction();
            $stage->update($data);
            DB::commit();

            return back()->withMessage('stage updated');
        }
        return back()->withErrors(['Resource not found']);
    }

    public function stageToggle($uuid){
        $stage = Stage::whereUuid($uuid)->first();
        if(!empty($stage)){
            if($stage->active){
                $msg = "Stage ({$stage->title}) deactivated";
                $stage->active = false;
                $stage->process = "inactive";
            }else{
                $msg = "Stage ({$stage->title}) is now active";
                $stage->active = true;
                $stage->process = "pending";

            }
            $stage->update();
            return back()->withMessage($msg);
        }
        return back()->withErrors(['Resource not found']);
    }

    public function stageEdit($uuid){
        $stage = Stage::whereUuid($uuid)->first();
        if(!empty($stage)){
            $lists = MailList::where('type','automated')->select(['title','uuid', 'updated_at'])->orderBy('updated_at','desc')->get();
            return view('dashboard.stage.edit')
                ->with([
                    'stage'=>$stage,
                    'lists'=>$lists
                ]);
        }
        return back()->withErrors(['Resource not found']);
    }

    public function stageDelete($uuid){
        $stage = Stage::whereUuid($uuid)->first();
        $auto = $stage->automate;
        if(!empty($stage)){
            $stage->delete();
            return redirect()->route('automate.manage', $auto->uuid)->withMessage("Automated Stage Object deleted.");
        }
        return back()->withErrors(['Resource not found']);
    }
}
