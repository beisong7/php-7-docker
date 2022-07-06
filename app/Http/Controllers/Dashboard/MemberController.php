<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\MailList;
use App\Models\Member;
use App\Services\Automate\MemberService;
use App\Services\MailList\AddRecipientService;
use App\Traits\General\Utility;
use App\Traits\Search\MemberSearch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    use MemberSearch, Utility;

    protected $recipientService;

    public function __construct(AddRecipientService $recipientService)
    {
        $this->recipientService = $recipientService;
    }

    public function index(Request $request){

        $data = $this->startQuery($request, true);
        $lists = MailList::select(['uuid', 'title', 'type'])->where('type','!=','automated')->orderBy('id','desc')->get();
        $groups = Group::orderBy('id','desc')->get();
        return view('dashboard.member.index')->with(
            [
                'data'=>$data,
                'type'=>$type = $request->input('type'),
                'start'=>$start = $request->input('start'),
                'end'=>$end = $request->input('end'),
                'groups'=>$groups
            ]
        );
    }

    public function addToList($uuid){
        $member = Member::whereUuid($uuid)->first();
        if(!empty($member)){
            $lists = MailList::orderBy('updated_at', 'desc')->where('type','!=','automated')->select(['title', 'uuid', 'type'])->get();
            return view('dashboard.member.add_to_list')->with(
                [
                    'member'=>$member,
                    'lists'=>$lists
                ]
            );
        }
    }

    public function addToListGroup(Request $request){
        $member_id = $request->input('member_id');
        $list_id = $request->input('list_id');
        $member = Member::whereUuid($member_id)->first();
        $list = MailList::whereUuid($list_id)->first();
        if(!empty($list)){
            if(!empty($member)){
                $count = $this->recipientService->createRecipientsForList([$member], $list_id);
                if($count > 0){
                    return back()->withMessage("One recipient added to {$list->title} list");
                }
            }
        }

        return back()->withErrors(['Recipient may already exist in list']);
    }

    public function storeOneToList(Request $request){
        $request->validate([
            'first_name'=>'required',
            'email'=>'required',
            'list_id'=>'required'
        ]);

        $uuid = $request->input('list_id');
        $list = MailList::whereUuid($uuid)->first();
        if(!empty($list)){
            $member = new Member();
            $member->first_name = $request->input('first_name');
            $member->email = $request->input('email');
            $count = $this->recipientService->createRecipientsForList([$member], $uuid);
            if($count > 0){
                return back()->withMessage("One recipient added to {$list->title} list");
            }
        }
        return back()->withErrors(['Resource not found.']);
    }

    public function create(){
        return view('dashboard.member.create')
            ->with([
                'groups'=>Group::get()
            ]);
    }

    public function store(Request $request){

        if(empty($request->first_name) && empty($request->email)){
            return back()->withErrors(['Missing firstname or email']);
        }

        $exist = Member::where('email', $request->email)->first();
        if(!empty($exist)){
            return back()->withErrors(['Email already existing.']);
        }

        $data['first_name'] = $request->first_name;
        $data['last_name'] = $request->last_name;
        $data['email'] = $request->email;
        $data['uuid'] = $this->makeUuid();



        $member = Member::create($data);

        if(!empty($request->group)){
            if(count($request->group)>0){
                foreach ($request->group as $group_id){
                    $group = Group::whereUuid($group_id)->first();
                    if(!empty($group)){
                        MemberService::addMemberToGroup($member->uuid, $group_id);
                    }
                }
            }
        }
        return back()->withMessage("One item added");
    }
}
