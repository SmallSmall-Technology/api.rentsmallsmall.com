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
            ->select('user_tbl.firstName as firstName', 'user_tbl.lastName as lastName', 'bookings.userID as userID', 'bookings.rent_status as rent_status', 'user_tbl.account_manager as account_manager')
            ->where('bookings.userID', $id)->distinct()->get('userID');

        }else {
            $bookingDistinctTenant = DB::table('bookings')
            ->join('user_tbl', 'bookings.userID', '=', 'user_tbl.userID')
            // ->join('property_tbl', 'inspection_tbl.propertyID', '=', 'property_tbl.propertyID')
            // ->join('bookings', 'user_tbl.userID', '=', 'bookings.userID')
            ->select('user_tbl.firstName as firstName', 'user_tbl.lastName as lastName', 'bookings.userID as userID', 'bookings.rent_status as rent_status', 'user_tbl.account_manager as account_manager')->distinct()->get('userID');
        }
        
        return $bookingDistinctTenant;
    }

    public function tenantsManagedAPI($id=null){
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
    
    public function newTenantsThatBooked($id=null){
        if($id){
            $newTenantsThatBooked = DB::table('bookings')
            ->join('user_tbl', 'bookings.userID', '=', 'user_tbl.userID')
            ->join('property_tbl', 'bookings.propertyID', '=', 'property_tbl.propertyID')
            ->select('bookings.*', 'user_tbl.firstName', 'user_tbl.lastName', 'property_tbl.propertyTitle')
            ->where('bookings.id',$id)
            ->get();
        }else {
            $newTenantsThatBooked = DB::table('bookings')
            ->join('user_tbl', 'bookings.userID', '=', 'user_tbl.userID')
            ->join('property_tbl', 'bookings.propertyID', '=', 'property_tbl.propertyID')
            ->select('bookings.*', 'user_tbl.firstName', 'user_tbl.lastName', 'property_tbl.propertyTitle')
            ->get();
            

        }
        
        return $newTenantsThatBooked;
    }
    
    public function newSubscribersUpdateSave(Request $request)
    {

        $data = array();
        $data['move_in_date'] = $request->move_in_date;
        $data['move_out_date'] = $request->move_out_date;
        $data['rent_expiration'] = $request->rent_expiration;
        $data['next_rental'] = $request->next_rental;

        $update = DB::table('bookings')->where('id', $request->id)->update($data);
         if($update){
            return redirect('https://rentsmallsmall.io/update-success');
        }else{
            return redirect('https://rentsmallsmall.io/update-failed');
        }
    }
    
    public function subscriptionDueThisMonth($id=null){
        if($id){
            $currentMonth = date('m');
            $currentYear = date('Y');
            $subscriptionDueThisMonth = DB::table('bookings')
            ->join('user_tbl', 'bookings.userID', '=', 'user_tbl.userID')
            ->join('property_tbl', 'bookings.propertyID', '=', 'property_tbl.propertyID')
            ->select('bookings.*', 'user_tbl.firstName', 'user_tbl.lastName', 'property_tbl.propertyTitle')
            ->where('bookings.id',$id)
            ->get();
        }else {
            $currentMonth = date('m');
            $currentYear = date('Y');
            $subscriptionDueThisMonth = DB::table('bookings')
            ->join('user_tbl', 'bookings.userID', '=', 'user_tbl.userID')
            ->join('property_tbl', 'bookings.propertyID', '=', 'property_tbl.propertyID')
            ->select('bookings.*', 'user_tbl.firstName', 'user_tbl.lastName', 'property_tbl.propertyTitle')
            ->whereRaw('MONTH(bookings.next_rental) = ?',[$currentMonth])->whereRaw('YEAR(bookings.next_rental) = ?',[$currentYear])
            ->orderBy('bookings.next_rental','desc')->get();
            

        }
        
        return $subscriptionDueThisMonth;
    }

}
