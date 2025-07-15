<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Psr\Log\NullLogger;
use Exception;

class UserAPIController extends Controller
{
    public function userAPI($id=null){
        try {
            if($id){
                $user = DB::table('user_tbl')->where('userID',$id)->get();
            }else {
                $user = DB::table('user_tbl')->get();
            }
            
            return response()->json([
                'status' => 'success',
                'data' => $user ?? [],
                'count' => $user ? $user->count() : 0
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Database error occurred',
                'data' => [],
                'count' => 0
            ], 500);
        }
    }

    public function userCountAPI($id=null){
        try {
            if($id){
                $userCount = DB::table('user_tbl')->where('userID',$id)->count();
            }else {
                $userCount = DB::table('user_tbl')->count();
            }
            
            return response()->json([
                'status' => 'success',
                'count' => $userCount ?? 0,
                'data' => ['count' => $userCount ?? 0]
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Database error occurred',
                'count' => 0,
                'data' => ['count' => 0]
            ], 500);
        }
    }

    public function userCXAPI($id=null){
        try {
            if($id){
                $userCX = DB::table('admin_tbl')->where('staff_dept', 'cx')->where('adminID',$id)->select('firstName','lastName', 'adminID', 'email')->get();
            }else {
                $userCX = DB::table('admin_tbl')->where('staff_dept', 'cx')->select('firstName','lastName', 'adminID', 'email')->get();
            }
            
            return response()->json([
                'status' => 'success',
                'data' => $userCX ?? [],
                'count' => $userCX ? $userCX->count() : 0
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Database error occurred',
                'data' => [],
                'count' => 0
            ], 500);
        }
    }

    

}
