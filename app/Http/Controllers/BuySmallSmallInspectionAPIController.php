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
            ->join('buytolet_users', 'buytolet_inspection.userID', '=', 'buytolet_users.userID')
            ->join('buytolet_property', 'buytolet_inspection.propertyID', '=', 'buytolet_property.propertyID')
            //->join('admin_tbl', 'buytolet_inspection.assigned_tsr', '=', 'admin_tbl.adminID')
            ->select('buytolet_users.firstName as firstName', 'buytolet_users.lastName as lastName', 'buytolet_users.email as email', 'buytolet_users.phone as phone', 'buytolet_inspection.userID as userID', 'buytolet_inspection.id as id', 'buytolet_inspection.inspectionID as inspectionID', 'buytolet_inspection.propertyID as propertyID', 'buytolet_inspection.inspection_date as inspection_date', 'buytolet_inspection.date_of_entry as date_of_entry', 'buytolet_property.property_name as property_name', 'buytolet_inspection.status as status')
            ->where('buytolet_inspection.id',$id)->orderBy('buytolet_inspection.id','desc')->get();
            
        }else {
            // $inspections = DB::table('buytolet_inspection')->get();
            $buyInspectionAPI = DB::table('buytolet_inspection')
            ->join('buytolet_users', 'buytolet_inspection.userID', '=', 'buytolet_users.userID')
            ->join('buytolet_property', 'buytolet_inspection.propertyID', '=', 'buytolet_property.propertyID')
            //->join('admin_tbl', 'buytolet_inspection.assigned_tsr', '=', 'admin_tbl.adminID')
            ->select('buytolet_users.firstName as firstName', 'buytolet_users.lastName as lastName', 'buytolet_users.email as email', 'buytolet_users.phone as phone', 'buytolet_inspection.userID as userID', 'buytolet_inspection.id as id', 'buytolet_inspection.inspectionID as inspectionID', 'buytolet_inspection.propertyID as propertyID', 'buytolet_inspection.inspection_date as inspection_date', 'buytolet_inspection.date_of_entry as date_of_entry', 'buytolet_property.property_name as property_name', 'buytolet_inspection.status as status')
            ->orderBy('buytolet_inspection.id','desc')->get();
        }
        //dd($buyInspectionAPI);
        return $buyInspectionAPI;
    }

   
    
}
