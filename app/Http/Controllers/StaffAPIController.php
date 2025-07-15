<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Psr\Log\NullLogger;

class StaffAPIController extends Controller
{
    public function staffAPI($id=null){
        if($id){
            $staffFX = DB::table('admin_tbl')->where('role','FX')->where('adminID',$id)->get();
        }else {
            $staffFX = DB::table('admin_tbl')->where('role','FX')->get();
        }
        
        return $staffFX;
    }

}
