<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use App\Traits\General\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmailTemplateController extends Controller
{
    use Utility;
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $templates = EmailTemplate::orderBy('updated_at', 'desc')->paginate(50);
        return view('dashboard.email_template.index')->with([
            'templates'=>$templates
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.email_template.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required:email_templates:unique',
            'content'=>'required',
        ]);

        $data['uuid'] = $this->makeUuid();
        $data['admin_id'] = $request->user()->uuid;
        $data['body'] = $request->input('content');
        $data['title'] = $request->input('title');
        $data['current'] = false;
        $data['active'] = true;
        DB::beginTransaction();
        EmailTemplate::create($data);
        DB::commit();
        return redirect()->route('template.index')->withMessage('New template created');
    }

    public function make(Request $request)
    {
        $request->validate([
            'title'=>'required:email_templates:unique',
            'content'=>'required',
        ]);

        $data['uuid'] = $this->makeUuid();
        $data['admin_id'] = $request->user()->uuid;
        $data['body'] = $request->input('content');
        $data['title'] = $request->input('title');
        $data['current'] = false;
        $data['active'] = true;
        DB::beginTransaction();
        EmailTemplate::create($data);
        DB::commit();
        return response()->json([
            'success'=>true,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EmailTemplate  $emailTemplate
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {

    }


    public function edit($uuid)
    {
        $template = EmailTemplate::whereUuid($uuid)->first();
        if(!empty($template)){
            return view('dashboard.email_template.edit')->with(['template'=>$template]);
        }
        return back()->withErrors(['Resource not found.']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EmailTemplate  $emailTemplate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uuid)
    {
        $template = EmailTemplate::whereUuid($uuid)->first();
        if(!empty($template)){
            $data = $request->all();
            DB::beginTransaction();
            $data['body'] = $request->input('content');
            $data['title'] = $request->input('title');
//            dd($data);
            $template->update($data);
            DB::commit();

            return back()->withMessage('Template updated!');
        }
        return back()->withErrors(['Resource not found.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EmailTemplate  $emailTemplate
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmailTemplate $emailTemplate)
    {
        //
    }

    public function toggle($uuid){
        $template = EmailTemplate::whereUuid($uuid)->first();
        if(!empty($template)){
            $msg = "";
            if(!$template->current){
                //remove any which is currently the default
                $default = EmailTemplate::where('current', true)->first();
                if(!empty($default)){
                    if($default->uuid !== $uuid){
                        $default->current = false;
                        $default->update();
                    }
                }
                $msg = "Template ({$template->title}) now set to default";
                $template->current = true;
                $template->update();

            }else{
                $msg = "Template ({$template->title}) now un-set from default";
                $template->current = false;
                $template->update();
            }
            return back()->withMessage($msg);
        }
        return back()->withErrors(['Resource not found.']);
    }

    public function pop($uuid){
        $template = EmailTemplate::whereUuid($uuid)->first();
        if(!empty($template)){
            $template->delete();
            return back()->withMessage('One item deleted');
        }
        return back()->withErrors(['Resource not found.']);
    }
}
