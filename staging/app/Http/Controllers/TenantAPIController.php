<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Psr\Log\NullLogger;

class TenantAPIController extends Controller
{
    public function tenantAPI($id=null){
        if($id){
            $tenant = DB::table('user_tbl')->where('user_type','tenant')->where('userID',$id)->get();
        }else {
            $tenant = DB::table('user_tbl')->where('user_type','tenant')->get();
        }
        
        return $tenant;
    }

    public function convertedTenantAPI($id=null){
        if($id){
            $convertedTenantAPI = DB::table('user_tbl')->where('user_type','tenant')->where('id',$id)->get();
        }else {
            $convertedTenantAPI = DB::table('user_tbl')->where('user_type','tenant')->get();
        }
        
        return $convertedTenantAPI;
    }

    public function tenantProfile($id=null)
    {
        if($id){
            $tenantProfile = DB::table('user_tbl')
            ->join('inspection_tbl', 'user_tbl.userID', '=', 'inspection_tbl.userID')
            ->join('property_tbl', 'inspection_tbl.propertyID', '=', 'property_tbl.propertyID')
            // ->join('bookings', 'user_tbl.userID', '=', 'bookings.userID')
            ->select('user_tbl.firstName as firstName', 'user_tbl.lastName as lastName', 'user_tbl.verified as verified', 'user_tbl.email as email', 'user_tbl.phone as phone', 'inspection_tbl.inspectionDate as inspectionDate', 'inspection_tbl.propertyID as propertyID', 'inspection_tbl.inspectionType as inspectionType', 'property_tbl.propertyTitle as propertyTitle')
            ->where('user_tbl.userID', $id)->get();
        }else{
            $tenantProfile = DB::table('user_tbl')
            ->join('inspection_tbl', 'user_tbl.userID', '=', 'inspection_tbl.userID')
            ->join('property_tbl', 'inspection_tbl.propertyID', '=', 'property_tbl.propertyID')
            ->select('user_tbl.firstName as firstName', 'user_tbl.lastName as lastName', 'user_tbl.verified as verified', 'user_tbl.email as email', 'user_tbl.phone as phone', 'inspection_tbl.inspectionDate as inspectionDate', 'inspection_tbl.propertyID as propertyID', 'inspection_tbl.inspectionType as inspectionType', 'property_tbl.propertyTitle as propertyTitle')->get();
        }

        return $tenantProfile;
        //return view('backend.tenantProfile', compact('tenantProfile'));
    }

    public function tenantRentalInfo($id=null)
    {
        if($id){
            $tenantRentalInfo = DB::table('user_tbl')
            ->join('bookings', 'user_tbl.userID', '=', 'bookings.userID')
            ->select('bookings.move_in_date as move_in_date', 'bookings.booked_as as booked_as', 'bookings.next_rental as next_rental', 'bookings.rent_expiration as rent_expiration', 'bookings.rent_status as rent_status')
            ->where('bookings.userID', $id)->get();
        }else{
            $tenantRentalInfo = DB::table('user_tbl')
            ->join('bookings', 'user_tbl.userID', '=', 'bookings.userID')
            ->select('bookings.move_in_date as move_in_date', 'bookings.booked_as as booked_as')->get();
        }

        return $tenantRentalInfo;
        //return view('backend.tenantProfile', compact('tenantProfile'));
    }

    public function updateAccountManagerAPI(Request $request)
    {

        $data = array();
        $data['account_manager'] = $request->account_manager;

        $update = DB::table('user_tbl')->where('userID', $request->userID)->update($data);
        if ($update) {
            // return ["update"=>"updated"];
            return redirect('https://rentsmallsmall.io/account-manager-update-success');
        } else {

            // return ["update"=>"did not update"];
            return redirect('https://rentsmallsmall.io/account-manager-update-failed');
        }
    }



    // public function addTenantAPI(Request $request){
    //     $data = array();
    //     // $data['userId'] = $random;
    //     $data['propertyTitle'] = $request->propertyTitle;
    //     $data['propertyID'] = $request->propertyID;
    //     $data['propertyDescription'] = $request->propertyDescription;
    //     $data['rentalCondition'] = $request->rentalCondition;
    //     $data['furnishing'] = $request->furnishing;
    //     $data['price'] = $request->price;
    //     $data['serviceCharge'] = $request->serviceCharge;
    //     $data['securityDeposit'] = $request->securityDeposit;
    //     $data['securityDepositTerm'] = $request->securityDepositTerm;
    //     $data['verification'] = $request->verification;
    //     $data['propertyType'] = $request->propertyType;
    //     $data['renting_as'] = $request->renting_as;
    //     $data['paymentPlan'] = $request->paymentPlan;
    //     $data['frequency'] = $request->frequency;
    //     $data['intervals'] = $request->intervals;
    //     $data['amenities'] = $request->amenities;
    //     $data['services'] = $request->services;
    //     $data['bed'] = $request->bed;
    //     $data['bath'] = $request->bath;
    //     $data['toilet'] = $request->toilet;
    //     $data['address'] = $request->address;
    //     $data['city'] = $request->city;
    //     $data['state'] = $request->state;
    //     $data['country'] = $request->country;
    //     $data['zip'] = $request->zip;
    //     $data['status'] = $request->status;
    //     $data['imageFolder'] = $request->imageFolder;
    //     $data['featuredImg'] = $request->featuredImg;
    //     $data['poster'] = $request->intervals;
    //     $data['views'] = $request->views;
    //     $data['featured_property'] = $request->featured_property;
    //     $data['available_date'] = date('Y-m-d');
    //     $data['dateOfEntry'] = date('Y-m-d H:i:s');
    //     $property = DB::table('property_tbl')->insert($data);
    // }

}
