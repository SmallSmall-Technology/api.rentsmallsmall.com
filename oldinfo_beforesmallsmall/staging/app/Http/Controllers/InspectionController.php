<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InspectionController extends Controller
{
    public function allInspections(){
                
        //landlord
        $responseInspection = Http::get("https://api.rentsmallsmall.com/api/inspection-api");
        //$responseLandlord->body();
        $allInspections = $responseInspection->json();

        return view('allInspections',['allInspections'=>$allInspections]);
    }

    public function inspection($id){
        // $fullname = DB::table('user_tbl')->where('userID',$id)->select('firstName')->get();
        $responseSingleInspection = Http::get("https://api.rentsmallsmall.com/api/inspection-api/".$id);
        //$responseLandlord->body();
        $singleInspection = $responseSingleInspection->json();
        
        return view('inspection', ['singleInspection' => $singleInspection]);

    }

    public function inspectionUpdateSuccess(){
        return view('inspectionUpdateSuccess');
    }

    
    
}
