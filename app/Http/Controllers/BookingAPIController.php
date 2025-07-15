<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Psr\Log\NullLogger;
use Exception;

class BookingAPIController extends Controller
{
    public function bookingAPI($id=null){
        try {
            if($id){
                $bookings = DB::table('bookings')->where('userID',$id)->get();
            }else {
                $bookings = DB::table('bookings')->get();
            }
            
            return response()->json([
                'status' => 'success',
                'data' => $bookings ?? [],
                'count' => $bookings ? $bookings->count() : 0
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

    public function bookingDistinctCountAPI($id=null){
        try {
            if($id){
                $bookingDistinctCount = DB::table('bookings')->select('userID')->where('userID',$id)->distinct()->count();
            }else {
                $bookingDistinctCount = DB::table('bookings')->select('userID')->distinct()->count('userID');
            }
            
            return response()->json([
                'status' => 'success',
                'count' => $bookingDistinctCount ?? 0,
                'data' => ['count' => $bookingDistinctCount ?? 0]
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

    public function bookingDistinctTenantAPI($id=null){
        try {
            if($id){
                $bookingDistinctTenant = DB::table('bookings')
                ->join('user_tbl', 'bookings.userID', '=', 'user_tbl.userID')
                ->select('user_tbl.firstName as firstName', 'user_tbl.lastName as lastName', 'bookings.userID as userID', 'bookings.rent_status as rent_status', 'user_tbl.account_manager as account_manager')
                ->where('bookings.userID', $id)->distinct()->get('userID');

            }else {
                $bookingDistinctTenant = DB::table('bookings')
                ->join('user_tbl', 'bookings.userID', '=', 'user_tbl.userID')
                ->select('user_tbl.firstName as firstName', 'user_tbl.lastName as lastName', 'bookings.userID as userID', 'bookings.rent_status as rent_status', 'user_tbl.account_manager as account_manager')->distinct()->get('userID');
            }
            
            return response()->json([
                'status' => 'success',
                'data' => $bookingDistinctTenant ?? [],
                'count' => $bookingDistinctTenant ? $bookingDistinctTenant->count() : 0
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

    public function tenantsManagedAPI($id=null){
        try {
            if($id){
                $bookingDistinctTenant = DB::table('bookings')
                ->join('user_tbl', 'bookings.userID', '=', 'user_tbl.userID')
                ->select('user_tbl.firstName as firstName', 'user_tbl.lastName as lastName', 'bookings.userID as userID', 'user_tbl.account_manager as account_manager')
                ->where('bookings.userID', $id)->distinct()->get('userID');

            }else {
                $bookingDistinctTenant = DB::table('bookings')
                ->join('user_tbl', 'bookings.userID', '=', 'user_tbl.userID')
                ->select('user_tbl.firstName as firstName', 'user_tbl.lastName as lastName', 'bookings.userID as userID', 'user_tbl.account_manager as account_manager')->distinct()->get('userID');
            }
            
            return response()->json([
                'status' => 'success',
                'data' => $bookingDistinctTenant ?? [],
                'count' => $bookingDistinctTenant ? $bookingDistinctTenant->count() : 0
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
    
    public function newTenantsThatBooked($id=null){
        try {
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
            
            return response()->json([
                'status' => 'success',
                'data' => $newTenantsThatBooked ?? [],
                'count' => $newTenantsThatBooked ? $newTenantsThatBooked->count() : 0
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
