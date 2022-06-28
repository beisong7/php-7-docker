<?php

namespace App\Http\Controllers\Automate;

use App\Http\Controllers\Controller;
use App\Models\Automate;
use App\Models\MailList;
use App\Models\Stage;
use App\Traits\General\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AutoController extends Controller
{
    use Utility;
    public function index(){
        $automates = Automate::paginate(50);
        return view('dashboard.automate.index')->with(['automates'=>$automates]);
    }

    public function create(){
        return view('dashboard.automate.create');
    }

    public function store(Request $request){
        $request->validate([
            'title'=>'required|unique:automates',
            'info'=>'required'
        ]);

        $data['uuid'] = $this->makeUuid();
        $data['title'] = $request->input('title');
        $data['info'] = $request->input('info');
        $data['admin_id'] = $request->user()->uuid;
        $data['round'] = 1;
        $data['active'] = false;

        DB::beginTransaction();
        $auto = Automate::create($data);
        DB::commit();
        //open automated item to add stages
        return redirect()->route('automate.manage', $auto->uuid)->withMessage('New automate item created. Add stages to proceed.');
    }

    public function update(Request $request, $uuid){
        $auto = Automate::whereUuid($uuid)->first();
        if(!empty($auto)){
            $title = $request->input('title');
            $exist_title = Automate::where('title', $title)->where('uuid', '!=', $uuid)->first();
            if(!empty($exist_title)){
                return back()->withErrors(['Title is already in use by another auto list.']);
            }

            $data['title'] = $request->input('title');
            $data['info'] = $request->input('info');
            DB::beginTransaction();
            $auto->update($data);
            DB::commit();
            return back()->withMessage('Auto list updated');

        }
        return back()->withErrors(['Resource not found']);
    }

    public function edit($uuid){
        $auto = Automate::whereUuid($uuid)->first();
        if(!empty($auto)){
            return view('dashboard.automate.edit')->with(['auto'=>$auto]);
        }
        return back()->withErrors(['Resource not found']);
    }

    public function toggle($uuid){
        $auto = Automate::whereUuid($uuid)->first();
        if(!empty($auto)){
            if($auto->active){
                $msg = "Auto list ({$auto->title}) deactivated";
                $auto->active = false;
            }else{
                $msg = "Auto list ({$auto->title}) is now active";
                $auto->active = true;

            }
            $auto->update();
            return back()->withMessage($msg);
        }
        return back()->withErrors(['Resource not found']);
    }

    public function toggleAll($uuid, $action){
        $auto = Automate::whereUuid($uuid)->first();
        $msg = "Oops. Nothing happened";
        if(!empty($auto)){
            if($action==='disable'){
                $msg = "All stage to ({$auto->title}) deactivated";
                DB::beginTransaction();
                foreach ($auto->stages as $stage){
                    $data['active'] = false;
                    $data['process'] = 'inactive';
                    $stage->update($data);
                }
                DB::commit();
            }
            if($action==='enable'){
                $msg = "All stage to ({$auto->title}) is now active";
                DB::beginTransaction();
                foreach ($auto->stages as $stage){
                    $data['active'] = true;
                    $data['process'] = 'pending';
                    $stage->update($data);
                }
                DB::commit();
            }
            return back()->withMessage($msg);
        }
        return back()->withErrors(['Resource not found']);
    }

    public function manage($uuid){
        $auto = Automate::whereUuid($uuid)->first();
        if(!empty($auto)){
            return view('dashboard.automate.manage')->with(['auto'=>$auto]);
        }
        return back()->withErrors(['Resource not found']);
    }

    public function autoDelete($uuid){
        $auto = Automate::whereUuid($uuid)->first();
        if(!empty($auto)){
            $count = 0;
            foreach ($auto->stages as $stage){
                $stage->delete();
                $count++;
            }
            $auto->delete();
            return redirect()->route('automate')->withMessage("Automated Object deleted with {$count} stage(s).");
        }
        return back()->withErrors(['Resource not found']);
    }
}
