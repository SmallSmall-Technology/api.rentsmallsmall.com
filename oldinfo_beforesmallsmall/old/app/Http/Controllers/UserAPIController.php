<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Psr\Log\NullLogger;

class UserAPIController extends Controller
{
    public function userAPI($id=null){
        if($id){
            $user = DB::table('user_tbl')->where('userID',$id)->get();
        }else {
            $user = DB::table('user_tbl')->get();
        }
        
        return $user;
    }

    public function userCountAPI($id=null){
        if($id){
            $userCount = DB::table('user_tbl')->where('userID',$id)->count();
        }else {
            $userCount = DB::table('user_tbl')->count();
        }
        
        return $userCount;
    }

    public function userCXAPI($id=null){
        if($id){
            $userCX = DB::table('user_tbl')->where('staff_dept', 'cx')->where('userID',$id)->select('firstName','lastName', 'userID')->get();
        }else {
            $userCX = DB::table('user_tbl')->where('staff_dept', 'cx')->select('firstName','lastName', 'userID', 'id')->get();
        }
        
        return $userCX;
    }

    

}
