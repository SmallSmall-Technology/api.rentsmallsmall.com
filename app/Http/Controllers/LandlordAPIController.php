<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LandlordAPIController extends Controller
{
    public function landlordAPI($id=null){
        if($id){
            $landlord = DB::table('user_tbl')->where('user_type','landlord')->where('id',$id)->get();
        }else {
            $landlord = DB::table('user_tbl')->where('user_type','landlord')->get();
        }
        
        return $landlord;
    }

    public function landlordCountAPI($id=null){
        if($id){
            $landlordCount = DB::table('user_tbl')->where('user_type','landlord')->where('id',$id)->count();
        }else {
            $landlordCount = DB::table('user_tbl')->where('user_type','landlord')->count();
        }
        
        return $landlordCount;
    }

    public function addLandlordAPI(Request $request){
        $data = array();
        
        $image_one = $request->file('profile_picture');
        
        

        if($image_one){
            $image_name = date('dmy_H_s_i');
            $rand = mt_rand(1000,10000000);
            $ext = strtolower($image_one->getClientOriginalExtension());
            $image_full_name = $image_name . $rand . '.' . $ext;
            $upload_path = 'public/profile_picture/';
            $image_url = $upload_path . $image_full_name;
            
            $data['profile_picture'] = $image_full_name;
            $data['userID'] = mt_rand(1000000, 99999999999);
            $data['user_type'] = 'landlord';
            $data['firstName'] = $request->firstName;
            $data['lastName'] = $request->lastName;
            $data['email'] = $request->email;
            $data['phone'] = $request->phone;
            $data['password'] = md5($request->password);
            $data['income'] = $request->income;
            $data['referral'] = $request->referral;
            $data['status'] = 'Active';
            $data['verified'] = $request->verified;
            // $data['profile_picture'] = $request->profile_picture;
            $data['interest'] = $request->interest;
            $data['regDate'] = date('Y-m-d H:i:s');
            $data['referral_code'] = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
            // $data['available_date'] = date('Y-m-d');
            // $data['dateOfEntry'] = date('Y-m-d H:i:s');
            $addLandlord = DB::table('user_tbl')->insert($data);
            
            if($addLandlord){
                $success = $image_one->move($upload_path, $image_full_name);
                // redirect('https://rentsmallsmall.io/add-landlord-success');
                return redirect('https://rentsmallsmall.io/add-landlord-success');
                // return redirect()->back();
            }else {
                return redirect('https://rentsmallsmall.io/add-landlord-failed');
            }
        }else{
            $data['profile_picture'] = '';
            $data['userID'] = mt_rand(1000000, 99999999999);
            $data['user_type'] = 'landlord';
            $data['firstName'] = $request->firstName;
            $data['lastName'] = $request->lastName;
            $data['email'] = $request->email;
            $data['phone'] = $request->phone;
            $data['password'] = md5($request->password);
            $data['income'] = '1000';
            $data['referral'] = 'nil';
            $data['status'] = 'Active';
            $data['verified'] = 'verified';
            $data['landlord_status'] = $request->landlord_status;
            $data['interest'] = 'interest';
            $data['regDate'] = date('Y-m-d H:i:s');
            // $data['available_date'] = date('Y-m-d');
            // $data['dateOfEntry'] = date('Y-m-d H:i:s');
            $addLandlord = DB::table('user_tbl')->insert($data);
            
            if($addLandlord){
                // redirect('https://rentsmallsmall.io/add-landlord-success');
                return redirect('https://rentsmallsmall.io/add-landlord-success');
                // return redirect()->back();
            }else {
                return redirect('https://rentsmallsmall.io/add-landlord-failed');
            }
        }
        
    }
}
