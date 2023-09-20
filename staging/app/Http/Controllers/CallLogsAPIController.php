<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CallLogsAPIController extends Controller
{

    public function addCallLogAPI(Request $request){
        $data = array();
        $data['firstName'] = $request->firstName;
        $data['lastName'] = $request->lastName;
        $data['property_link'] = $request->property_link;
        $data['user_group'] = $request->user_group;
        $data['feedback'] = $request->feedback;
        $data['date_of_call'] = date('Y-m-d H:i:s');
        $addCallLogAPI = DB::table('call_logs')->insert($data);

        if($addCallLogAPI){
            return redirect('https://rentsmallsmall.io/add-property-success');
        }else {
            return redirect('https://rentsmallsmall.io/add-property-failed');
        }
    }
    
    public function propertyAPI($id=null){
        if($id){
            $property = DB::table('property_tbl')->where('id',$id)->get();
        }else {
            $property = DB::table('property_tbl')->get();
        }
        
        return $property;
    }

   
    
}
