<?php

namespace App\Http\Controllers;

use App\Mail\InspectionEmail;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class BuySmallSmallInspectionAPIController extends Controller
{
    public function buyInspectionAPI($id=null){
        if($id){
            // $inspections = DB::table('buytolet_inspection')->where('id',$id)->get();
            $buyInspectionAPI = DB::table('buytolet_inspection')
            // ->join('buytolet_users', 'buytolet_inspection.userID', '=', 'buytolet_users.userID')
            ->join('user_tbl', 'buytolet_inspection.userID', '=', 'user_tbl.userID')
            ->join('buytolet_property', 'buytolet_inspection.propertyID', '=', 'buytolet_property.propertyID')
            ->select('buytolet_inspection.userID as userID', 'buytolet_inspection.id as id', 'user_tbl.firstName as firstName', 'user_tbl.lastName as lastName', 'user_tbl.email as email', 'user_tbl.phone as phone', 'buytolet_inspection.inspectionID as inspectionID', 'buytolet_inspection.propertyID as propertyID', 'buytolet_inspection.inspection_date as inspection_date', 'buytolet_inspection.date_of_entry as date_of_entry', 'buytolet_property.property_name as property_name', 'buytolet_inspection.status as status')
            ->where('buytolet_inspection.id',$id)->orderBy('buytolet_inspection.id','desc')->get();
            
        }else {
            $buyInspectionAPI = DB::table('buytolet_inspection')
            ->join('user_tbl', 'buytolet_inspection.userID', '=', 'user_tbl.userID')
            ->join('buytolet_property', 'buytolet_inspection.propertyID', '=', 'buytolet_property.propertyID')
            ->select('buytolet_inspection.userID as userID', 'buytolet_inspection.id as id', 'user_tbl.firstName as firstName', 'user_tbl.lastName as lastName', 'user_tbl.email as email', 'user_tbl.phone as phone', 'buytolet_inspection.inspectionID as inspectionID', 'buytolet_inspection.propertyID as propertyID', 'buytolet_inspection.inspection_date as inspection_date', 'buytolet_inspection.date_of_entry as date_of_entry', 'buytolet_property.property_name as property_name', 'buytolet_inspection.status as status')
            ->orderBy('buytolet_inspection.id','desc')
            ->get();
        }
        //dd($buyInspectionAPI);
        return $buyInspectionAPI;
    }
    
    // public function buySmallSmallAPI($id=null){
    //     if($id){
    //         $buySmallSmallAPI = DB::table('buytolet_request')
    //         ->join('user_tbl', 'buytolet_request.userID', '=', 'user_tbl.userID')
    //         ->select('userID')->distinct()
    //         ->select('user_tbl.id as id', 'user_tbl.firstName as firstName', 'user_tbl.lastName as lastName', 'user_tbl.email as email', 'user_tbl.phone as phone', 'user_tbl.regDate as regDate', 'buytolet_request.occupation as occupation', 'buytolet_request.position as position', 'buytolet_request.company as company', 'buytolet_request.company_address as company_address', 'buytolet_request.income_range as income_range')
    //         ->where('user_tbl.id',$id)
    //         ->orderBy('user_tbl.id','desc')
    //         ->get();

            
    //     }else {
    //         $buySmallSmallAPI = DB::table('buytolet_request')
    //         ->join('user_tbl', 'buytolet_request.userID', '=', 'user_tbl.userID')
    //         ->select('userID')->distinct()
    //         ->select('user_tbl.id as id', 'user_tbl.firstName as firstName', 'user_tbl.lastName as lastName', 'user_tbl.email as email', 'user_tbl.phone as phone', 'user_tbl.regDate as regDate', 'buytolet_request.occupation as occupation', 'buytolet_request.position as position', 'buytolet_request.company as company', 'buytolet_request.company_address as company_address', 'buytolet_request.income_range as income_range')
    //         ->orderBy('user_tbl.id','desc')
    //         ->get();
    //     }

    //     return $buySmallSmallAPI;
    // }
    
    public function buySmallSmallAPI($id=null){
        if($id){
            $buySmallSmallAPI = DB::table('user_tbl')
            ->where('interest', 'Buy')
            ->where('id', $id)
            ->get();
            
        }else {
            $buySmallSmallAPI = DB::table('user_tbl')
            ->where('interest', 'Buy')
            ->orderBy('id', 'desc')
            ->get();
        }

        return $buySmallSmallAPI;
    }
    
    public function buySmallSmallAPICount($id=null){
        if($id){
            $buySmallSmallAPICount = DB::table('buytolet_request')
            ->join('user_tbl', 'buytolet_request.userID', '=', 'user_tbl.userID')
            ->select('userID')->distinct()
            ->select('user_tbl.id as id', 'user_tbl.firstName as firstName', 'user_tbl.lastName as lastName', 'user_tbl.email as email', 'user_tbl.phone as phone', 'user_tbl.regDate as regDate', 'buytolet_request.occupation as occupation', 'buytolet_request.position as position', 'buytolet_request.company as company', 'buytolet_request.company_address as company_address', 'buytolet_request.income_range as income_range')
            ->where('buytolet_request.id',$id)
            ->orderBy('buytolet_request.id','desc')
            ->get();

            
        }else {
            $buySmallSmallAPICount = DB::table('buytolet_request')->select('buytolet_request.userID')
            ->join('user_tbl', 'buytolet_request.userID', '=', 'user_tbl.userID')
            //->select('buytolet_request.userID')
            //->select('user_tbl.id as id', 'user_tbl.firstName as firstName', 'user_tbl.lastName as lastName', 'user_tbl.email as email', 'user_tbl.phone as phone', 'user_tbl.regDate as regDate', 'buytolet_request.userID as userID', 'buytolet_request.occupation as occupation', 'buytolet_request.position as position', 'buytolet_request.company as company', 'buytolet_request.company_address as company_address', 'buytolet_request.income_range as income_range')
            //->orderBy('buytolet_request.id','desc')
            ->distinct('buytolet_request.userID')
            ->count('buytolet_request.userID');
            //->get();
        }

        return $buySmallSmallAPICount;
    }
    
    public function buySmallSmallPropertyRequestAPI($id=null){
        if($id){
            $buySmallSmallPropertyRequestAPI = DB::table('buytolet_request')
            ->join('buytolet_property', 'buytolet_request.propertyID', '=', 'buytolet_property.propertyID')
            ->select('buytolet_request.*', 'buytolet_property.property_name as property_name')
            ->where('buytolet_request.id',$id)
            ->orderBy('buytolet_request.id','desc')
            ->get();

            
        }else {
            $buySmallSmallPropertyRequestAPI = DB::table('buytolet_request')
            ->join('buytolet_property', 'buytolet_request.propertyID', '=', 'buytolet_property.propertyID')
            ->select('buytolet_request.*', 'buytolet_property.property_name as property_name')
            ->orderBy('buytolet_request.id','desc')
            ->get();
        }

        return $buySmallSmallPropertyRequestAPI;
    }

   
    
}
