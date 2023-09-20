<?php

namespace App\Http\Controllers;

use App\Mail\InspectionEmail;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class LoanAPIController extends Controller
{
    public function loanEligibleSubscribers2($id=null){
        if($id){
            $currentMonth = date('m');
            $currentYear = date('Y');

            $inspections = DB::table('inspection_tbl')
            ->join('user_tbl', 'inspection_tbl.userID', '=', 'user_tbl.userID')
            ->join('property_tbl', 'inspection_tbl.propertyID', '=', 'property_tbl.propertyID')
            ->select('user_tbl.firstName as firstName', 'user_tbl.lastName as lastName', 'user_tbl.email as email', 'user_tbl.phone as phone', 'inspection_tbl.userID as userID', 'inspection_tbl.id as id', 'inspection_tbl.inspectionID as inspectionID', 'inspection_tbl.propertyID as propertyID', 'inspection_tbl.inspectionDate as inspectionDate', 'inspection_tbl.updated_inspection_date as updated_inspection_date', 'inspection_tbl.inspectionType as inspectionType', 'inspection_tbl.dateOfEntry as dateOfEntry', 'property_tbl.propertyTitle as propertyTitle', 'inspection_tbl.assigned_tsr as assigned_tsr', 'inspection_tbl.inspection_status as inspection_status', 'inspection_tbl.inspection_remarks as inspection_remarks', 'inspection_tbl.comment as comment', 'inspection_tbl.follow_up_stage as follow_up_stage', 'property_tbl.propertyTitle as propertyTitle')
            ->where('inspection_tbl.id',$id)->whereRaw('MONTH(inspection_tbl.dateOfEntry) = ?',[$currentMonth])->whereRaw('YEAR(inspection_tbl.dateOfEntry) = ?',[$currentYear])
            ->orderBy('inspection_tbl.id','desc')->get();
            
        }else {
            // $inspections = DB::table('inspection_tbl')->get();
            $currentMonth = date('m');
            $currentYear = date('Y');

            $inspections = DB::table('inspection_tbl')
            ->join('user_tbl', 'inspection_tbl.userID', '=', 'user_tbl.userID')
            ->join('property_tbl', 'inspection_tbl.propertyID', '=', 'property_tbl.propertyID')
            ->select('user_tbl.firstName as firstName', 'user_tbl.lastName as lastName', 'user_tbl.email as email', 'user_tbl.phone as phone', 'inspection_tbl.userID as userID', 'inspection_tbl.id as id', 'inspection_tbl.inspectionID as inspectionID', 'inspection_tbl.propertyID as propertyID', 'inspection_tbl.inspectionDate as inspectionDate', 'inspection_tbl.updated_inspection_date as updated_inspection_date', 'inspection_tbl.inspectionType as inspectionType', 'inspection_tbl.dateOfEntry as dateOfEntry', 'property_tbl.propertyTitle as propertyTitle','inspection_tbl.assigned_tsr as assigned_tsr','inspection_tbl.inspection_status as inspection_status', 'inspection_tbl.inspection_remarks as inspection_remarks', 'inspection_tbl.comment as comment', 'inspection_tbl.follow_up_stage as follow_up_stage', 'property_tbl.propertyTitle as propertyTitle')
            ->whereRaw('MONTH(inspection_tbl.dateOfEntry) = ?',[$currentMonth])->whereRaw('YEAR(inspection_tbl.dateOfEntry) = ?',[$currentYear])
            ->orderBy('inspection_tbl.id','desc')->get();
        }
        
        return $inspections;
    }


    // public function loanEligibleSubscribers($id=null){
    //     if($id){

    //         $loanEligibleSubscribers = DB::table('bookings')
    //         ->join('user_tbl', 'bookings.userID', '=', 'user_tbl.userID')
    //         ->join('bookings.userID', '=', 'transactions_tbl.userID')
    //         // ->join('property_tbl', 'inspection_tbl.propertyID', '=', 'property_tbl.propertyID')
    //         // ->join('bookings', 'user_tbl.userID', '=', 'bookings.userID')
    //         ->select('user_tbl.firstName as firstName', 'user_tbl.lastName as lastName', 'bookings.userID as userID', 'bookings.rent_status as rent_status', 'user_tbl.account_manager as account_manager')
    //         ->where('bookings.userID', $id)->distinct()->get('userID');

    //     }else {
    //         $loanEligibleSubscribers = DB::table('bookings')
    //         ->join('user_tbl', 'bookings.userID', '=', 'user_tbl.userID')
    //         ->join('transaction_tbl', 'bookings.userID', '=', 'transaction_tbl.userID')
    //         ->select('user_tbl.firstName as firstName', 'user_tbl.lastName as lastName', 'bookings.userID as userID', 'bookings.rent_status as rent_status', 'user_tbl.account_manager as account_manager', 'transaction_tbl.reference_id as reference_id')->where('transaction_tbl.status','approved')->get();
    //     }
        
    //     return $loanEligibleSubscribers;
    // }
    
    public function loanEligibleSubscribers($id=null){
        if($id){

            // $loanEligibleSubscribers = DB::table('transaction_tbl')
            // ->join('user_tbl', 'transaction_tbl.userID', '=', 'user_tbl.userID')
            // ->join('bookings', 'transaction_tbl.userID', '=', 'bookings.userID')
            // ->select('user_tbl.firstName as firstName', 'user_tbl.lastName as lastName', 'transaction_tbl.userID as userID',  'user_tbl.account_manager as account_manager', 'transaction_tbl.reference_id as reference_id')->where('transaction_tbl.status','approved')
            // ->where('transaction_tbl.userID', $id)->count();
            
            $loanEligibleSubscribers = DB::table('transaction_tbl')
            ->join('user_tbl', 'transaction_tbl.userID', '=', 'user_tbl.userID')
            ->join('bookings', 'transaction_tbl.reference_id', '=', 'bookings.reference_id')
            ->select('user_tbl.firstName as firstName', 'user_tbl.lastName as lastName', 'transaction_tbl.userID as userID',  'user_tbl.account_manager as account_manager', 'transaction_tbl.reference_id as reference_id', 'bookings.next_rental as next_rental', 'transaction_tbl.transaction_date as transaction_date')
            ->where('transaction_tbl.status','approved')
            ->where('transaction_tbl.userID', $id)
            ->where(DB::raw('DATE(transaction_tbl.transaction_date)'), '<=', DB::raw('DATE(bookings.next_rental)'))
            //->where('bookings.next_rental', '==', '2022-05-18')
            //->where('transaction_tbl.transaction_date', '==', '2022-02-22 18:13:18')
            //->where('transaction_tbl.transaction_date', '==', 'bookings.next_rental')
            ->get();

        }else {
            $loanEligibleSubscribers = DB::table('transaction_tbl')
            ->join('user_tbl', 'transaction_tbl.userID', '=', 'user_tbl.userID')
            ->join('bookings', 'transaction_tbl.reference_id', '=', 'bookings.reference_id')
            ->select('user_tbl.firstName as firstName', 'user_tbl.lastName as lastName', 'transaction_tbl.userID as userID',  'user_tbl.account_manager as account_manager', 'transaction_tbl.reference_id as reference_id', 'bookings.next_rental as next_rental', 'transaction_tbl.transaction_date as transaction_date')
            ->where('transaction_tbl.status','approved')
            ->where(DB::raw('DATE(transaction_tbl.transaction_date)'), '<=', DB::raw('DATE(bookings.next_rental)'))
            ->get();
        }
        
        return $loanEligibleSubscribers;
    }
    
    public function loanEligibleSubscribersCount($id=null){
        if($id){

            // $loanEligibleSubscribers = DB::table('transaction_tbl')
            // ->join('user_tbl', 'transaction_tbl.userID', '=', 'user_tbl.userID')
            // ->join('bookings', 'transaction_tbl.userID', '=', 'bookings.userID')
            // ->select('user_tbl.firstName as firstName', 'user_tbl.lastName as lastName', 'transaction_tbl.userID as userID',  'user_tbl.account_manager as account_manager', 'transaction_tbl.reference_id as reference_id')->where('transaction_tbl.status','approved')
            // ->where('transaction_tbl.userID', $id)->count();
            
            $loanEligibleSubscribersCount = DB::table('transaction_tbl')
            ->join('user_tbl', 'transaction_tbl.userID', '=', 'user_tbl.userID')
            ->join('bookings', 'transaction_tbl.reference_id', '=', 'bookings.reference_id')
            ->select('user_tbl.firstName as firstName', 'user_tbl.lastName as lastName', 'transaction_tbl.userID as userID',  'user_tbl.account_manager as account_manager', 'transaction_tbl.reference_id as reference_id', 'bookings.next_rental as next_rental', 'transaction_tbl.transaction_date as transaction_date')
            ->where('transaction_tbl.status','approved')
            ->where('transaction_tbl.userID', $id)
            ->where(DB::raw('DATE(transaction_tbl.transaction_date)'), '<=', DB::raw('DATE(bookings.next_rental)'))
            //->where('bookings.next_rental', '==', '2022-05-18')
            //->where('transaction_tbl.transaction_date', '==', '2022-02-22 18:13:18')
            //->where('transaction_tbl.transaction_date', '==', 'bookings.next_rental')
            ->count();

        }else {
            $loanEligibleSubscribersCount = DB::table('transaction_tbl')
            ->join('user_tbl', 'transaction_tbl.userID', '=', 'user_tbl.userID')
            ->join('bookings', 'transaction_tbl.reference_id', '=', 'bookings.reference_id')
            ->select('user_tbl.firstName as firstName', 'user_tbl.lastName as lastName', 'transaction_tbl.userID as userID',  'user_tbl.account_manager as account_manager', 'transaction_tbl.reference_id as reference_id', 'bookings.next_rental as next_rental', 'transaction_tbl.transaction_date as transaction_date')
            ->where('transaction_tbl.status','approved')
            ->where(DB::raw('DATE(transaction_tbl.transaction_date)'), '<=', DB::raw('DATE(bookings.next_rental)'))
            ->count();
        }
        
        return $loanEligibleSubscribersCount;
    }
    
    public function userCountAPI($id=null){
        if($id){
            $userCount = DB::table('user_tbl')->where('userID',$id)->count();
        }else {
            $userCount = DB::table('user_tbl')->count();
        }
        
        return $userCount;
    }
    
    
    
}
