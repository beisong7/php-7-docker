<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Send;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function respond(){
        $data = Send::orderBy('date', 'asc')->take(11)->get();
        $days = [];
        $values = [];
        foreach ($data as $sent){
            array_push($days, date('j M', strtotime($sent->date)));
            array_push($values, $sent->count);
        }
        return response()->json([
            'days'=>$days,
            'count'=>$values
        ], 200);
    }
}
