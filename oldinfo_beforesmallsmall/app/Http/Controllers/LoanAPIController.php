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
    
}
