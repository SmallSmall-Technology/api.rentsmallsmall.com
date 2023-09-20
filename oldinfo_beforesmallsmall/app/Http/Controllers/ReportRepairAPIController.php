<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class ReportRepairAPIController extends Controller
{
    public function allRepairAPI($id=null){
        if($id){
            $repair = DB::table('repairs')->where('id',$id)->get();
        }else {
            $repair = DB::table('repairs')->get();
        }
        
        return $repair;
    }

    public function reportRepairAPI(Request $request){
        $data = array();

        $data['type_of_repair'] = $request->type_of_repair;
        $data['details'] = $request->details;
        $data['repair_date'] = now();
        $data['userId'] = $request->userId;
        
        $reportRepair = DB::table('repair_request')->insert($data);
        if($reportRepair){
            return response(['Message'=>'Saved Successfully'], 201);
                // return redirect()->back();
        }else {
            return response(['Message'=>'Failed'], 400);
        }
           
    }
}
