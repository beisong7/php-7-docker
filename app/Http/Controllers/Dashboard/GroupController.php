<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Member;
use App\Services\Automate\MemberService;
use App\Traits\General\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    use Utility;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Request $request)
    {

        $group = Group::orderBy('id','desc')->paginate(30);
        return view('dashboard.group.index')->with(
            [
                'data'=>$group,
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(empty($request->name)){
            return back()->withErrors(['Missing name']);
        }

        $exist = Group::where('name', $request->name)->first();
        if(!empty($exist)){
            return back()->withErrors(['name already exist']);
        }

        $data['uuid'] = $this->makeUuid();
        $data['name'] = $request->name;
        $data['unique_key'] = $request->unique_key;
        $data['info'] = $request->info;
        $data['is_active'] = true;

        Group::create($data);

        return back()->withMessage("One group item created");

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * delete a group item
     * @param $uuid
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($uuid){
        $group = Group::whereUuid($uuid)->first();
        if(!empty($group)){
            DB::beginTransaction();
            foreach ($group->anchors as $anchor){
                $anchor->delete();
            }
            $group->delete();
            DB::commit();
            return back()->withMessage("One item deleted");
        }
        return back();
    }

    /**
     * add a particular member to selected groups
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function prepForGroup(Request $request){
        if(!empty($request->selection)){
            if(count($request->selection)>0){
                $member = Member::where('uuid', $request->member_id)->first();
                if(!empty($member)){
                    foreach ($request->selection as $group_id){
                        MemberService::addMemberToGroup($member->uuid, $group_id);
                    }
                    return back()->withMessage("Added to selected groups");
                }
            }
        }
        return back()->withErrors(['No selected group']);
    }

    /**
     * list the members of a group
     * @param $uuid
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function members($uuid){
        $group = Group::whereUuid($uuid)->first();
        if(!empty($group)){
            return view('dashboard.group.members')->with([
                'members'=>$group->members,
                'group'=>$group
            ]);
        }
        return back();
    }

    public function removeMember($id, $member_id){
        $group = Group::whereUuid($id)->first();
        if(!empty($group)){
            $member = Member::whereUuid($member_id)->first();
            if(!empty($member)){
                MemberService::removeMemberFromGroup($member_id, $group->uuid);
                return response()->json(['successful'=>'yes'], 200);
            }
        }
        return response()->json(['successful'=>'no'], 401);
    }
}
