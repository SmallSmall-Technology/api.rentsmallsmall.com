<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Psr\Log\NullLogger;

class StaffTSRAPIController extends Controller
{
    public function staffTSRAPI($id=null){
        if($id){
            $staffTSR = DB::table('admin_tbl')->where('staff_dept','tsr')->where('adminID',$id)->get();
        }else {
            $staffTSR = DB::table('admin_tbl')->where('staff_dept','tsr')->get();
        }
        
        return $staffTSR;
    }

}
