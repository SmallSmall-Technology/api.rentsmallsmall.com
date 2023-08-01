<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        $data['apartment_owner_id'] = $request->apartment_owner_id;
        $data['items_repaired'] = $request->items_repaired;
        $data['repair_amount'] = $request->repair_amount;
        $data['repair_status'] = $request->repair_status;
        $data['repair_done_by'] = $request->repair_done_by;
        $data['repair_date'] = $request->repair_date;
        
        $reportRepair = DB::table('repairs')->insert($data);
        if($reportRepair){
            return redirect('https://rentsmallsmall.io/report-repair-success');
                // return redirect()->back();
        }else {
            return redirect('https://rentsmallsmall.io/report-repair-failed');
        }
           
    }
}
