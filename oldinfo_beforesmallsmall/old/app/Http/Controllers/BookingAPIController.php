<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Psr\Log\NullLogger;

class BookingAPIController extends Controller
{
    public function bookingAPI($id=null){
        if($id){
            $bookings = DB::table('bookings')->where('userID',$id)->get();
        }else {
            $bookings = DB::table('bookings')->get();
        }
        
        return $bookings;
    }

    public function bookingDistinctCountAPI($id=null){
        if($id){
            $bookingDistinctCount = DB::table('bookings')->select('userID')->where('userID',$id)->distinct()->count();
        }else {
            $bookingDistinctCount = DB::table('bookings')->select('userID')->distinct()->count('userID');
        }
        
        return $bookingDistinctCount;
    }

    public function bookingDistinctTenantAPI($id=null){
        if($id){
            // $bookingDistinctTenantAPI = DB::table('bookings')->select('userID')->where('userID',$id)->distinct()->count();
            
            $bookingDistinctTenant = DB::table('bookings')
            ->join('user_tbl', 'bookings.userID', '=', 'user_tbl.userID')
            // ->join('property_tbl', 'inspection_tbl.propertyID', '=', 'property_tbl.propertyID')
            // ->join('bookings', 'user_tbl.userID', '=', 'bookings.userID')
            ->select('user_tbl.firstName as firstName', 'user_tbl.lastName as lastName', 'bookings.userID as userID', 'user_tbl.account_manager as account_manager')
            ->where('bookings.userID', $id)->distinct()->get('userID');

        }else {
            $bookingDistinctTenant = DB::table('bookings')
            ->join('user_tbl', 'bookings.userID', '=', 'user_tbl.userID')
            // ->join('property_tbl', 'inspection_tbl.propertyID', '=', 'property_tbl.propertyID')
            // ->join('bookings', 'user_tbl.userID', '=', 'bookings.userID')
            ->select('user_tbl.firstName as firstName', 'user_tbl.lastName as lastName', 'bookings.userID as userID', 'user_tbl.account_manager as account_manager')->distinct()->get('userID');
        }
        
        return $bookingDistinctTenant;
    }

}
