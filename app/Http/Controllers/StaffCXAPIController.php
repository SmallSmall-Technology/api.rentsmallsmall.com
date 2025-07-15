<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Psr\Log\NullLogger;

class StaffCXAPIController extends Controller
{
    public function staffCXAPI($id=null){
        if($id){
            $staffCXAPI = DB::table('admin_tbl')->where('staff_dept','cx')->where('adminID',$id)->get();
        }else {
            $staffCXAPI = DB::table('admin_tbl')->where('staff_dept','cx')->get();
        }
        
        return $staffCXAPI;
    }

}
