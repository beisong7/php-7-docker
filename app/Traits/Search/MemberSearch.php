<?php

namespace App\Traits\Search;

use App\Models\Member;
use Illuminate\Http\Request;

trait MemberSearch {
    public function startQuery(Request $request, $page = false){
        $type = $request->input('type');
        $start = $request->input('start');
        $end = $request->input('end');
        $data = [];
        $query = Member::where('id', '!=', null);
        if(!$page){
            $query->select(['first_name', 'email', 'last_name', 'uuid', 'created_at']);
        }

        $query = $this->exportType($query, $type);

//        dd($request->input('type'));
        if(empty($start) and empty($end)){
            //  dd('empties');

        }else{
            //major logic
            if(!empty($start) and empty($end)){
                $query = $query->where('created_at', '>=', $start);
            }elseif (!empty($end) and empty($start)){
                $nend = $end."T23:59";
                $query = $query->where('created_at', '<', $nend);
            }else{
                $nend = $end."T23:59";
                $query = $query->where('created_at', '>=', $start)->where('created_at', '<', $nend);
            }
        }

        $data = $page?$query->orderBy('created_at', 'desc')->paginate(50):$query->orderBy('created_at', 'desc')->get();

        return $data;
    }

    public function exportType($query, $filter){
        if($filter==='active'){
            $query = $query->where('active', true);
        }

        if($filter==='inactive'){
            $query = $query->where('active', false);
        }

        if($filter==='member'){
            $query = $query->whereIn('members.uuid', function($q){
                $q->from('subscriptions')
                    ->select('subscriptions.member_id')
                    ->where('expire_date', '>=', time())
                    ->where('active', true);
            });
        }

        if($filter==='non member'){

            $query = $query->where(function ($q)  {
                $q->whereDoesntHave('subscription')
                ->orWhere(function ($qu) {
                    $qu->whereIn('members.uuid', function ($que) {
                        $que->from('subscriptions')
                            ->select('subscriptions.member_id')
                            ->where('expire_date', '<', time());
                    });
                });
            });

//            $query = $query->where(function ($q)  {
//                $q->whereDoesntHave('subscription');
//            })->orWhere(function ($q) {
//                $q->whereIn('members.uuid', function ($qu) {
//                    $qu->from('subscriptions')
//                        ->select('subscriptions.member_id')
//                        ->where('expire_date', '<', time());
//                });
//            });

        }

        if($filter==='v non-member'){

            $query = $query->where('active', true)
                ->where(function ($q)  {
                $q->whereDoesntHave('subscription')
                ->orWhere(function ($qu) {
                    $qu->whereIn('members.uuid', function ($que) {
                        $que->from('subscriptions')
                            ->select('subscriptions.member_id')
                            ->where('expire_date', '<', time());
                    });
                });
            });
        }


        return $query;
    }
}