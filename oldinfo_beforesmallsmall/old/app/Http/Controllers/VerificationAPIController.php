<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VerificationAPIController extends Controller
{
    public function verificationAPI($id=null){
        if($id){
            $verifications = DB::table('verifications')->where('id',$id)->get();
        }else {
            $verifications = DB::table('verifications')->get();
        }
        
        return $verifications;
    }

    public function verificationCountAPI($id=null){
        if($id){
            $verificationsCount = DB::table('verifications')->where('id',$id)->count();
        }else {
            $verificationsCount = DB::table('verifications')->count();
        }
        
        return $verificationsCount;
    }

    public function addPropertyAPI(Request $request){
        $data = array();
        // $data['userId'] = $random;
        $data['propertyTitle'] = $request->propertyTitle;
        $data['propertyID'] = $request->propertyID;
        $data['propertyDescription'] = $request->propertyDescription;
        $data['rentalCondition'] = $request->rentalCondition;
        $data['furnishing'] = $request->furnishing;
        $data['price'] = $request->price;
        $data['serviceCharge'] = $request->serviceCharge;
        $data['securityDeposit'] = $request->securityDeposit;
        $data['securityDepositTerm'] = $request->securityDepositTerm;
        $data['verification'] = $request->verification;
        $data['propertyType'] = $request->propertyType;
        $data['renting_as'] = $request->renting_as;
        $data['paymentPlan'] = $request->paymentPlan;
        $data['frequency'] = $request->frequency;
        $data['intervals'] = $request->intervals;
        $data['amenities'] = $request->amenities;
        $data['services'] = $request->services;
        $data['bed'] = $request->bed;
        $data['bath'] = $request->bath;
        $data['toilet'] = $request->toilet;
        $data['address'] = $request->address;
        $data['city'] = $request->city;
        $data['state'] = $request->state;
        $data['country'] = $request->country;
        $data['zip'] = $request->zip;
        $data['status'] = $request->status;
        $data['imageFolder'] = $request->imageFolder;
        $data['featuredImg'] = $request->featuredImg;
        $data['poster'] = $request->intervals;
        $data['views'] = $request->views;
        $data['featured_property'] = $request->featured_property;
        $data['available_date'] = date('Y-m-d');
        $data['dateOfEntry'] = date('Y-m-d H:i:s');
        $property = DB::table('property_tbl')->insert($data);
    }

    public function editPropertyAPI(Request $request)
    {

        $data = array();
        // $data['propertyTitle'] = $request->propertyTitle;
        // $data['propertyID'] = $request->propertyID;
        // $data['propertyDescription'] = $request->propertyDescription;
        // $data['rentalCondition'] = $request->rentalCondition;
        // $data['furnishing'] = $request->furnishing;
        // $data['price'] = $request->price;
        // $data['serviceCharge'] = $request->serviceCharge;
        // $data['securityDeposit'] = $request->securityDeposit;
        // $data['securityDepositTerm'] = $request->securityDepositTerm;
        // $data['verification'] = $request->verification;
        // $data['propertyType'] = $request->propertyType;
        // $data['renting_as'] = $request->renting_as;
        // $data['paymentPlan'] = $request->paymentPlan;
        // $data['frequency'] = $request->frequency;
        // $data['intervals'] = $request->intervals;
        // $data['amenities'] = $request->amenities;
        // $data['services'] = $request->services;
        // $data['bed'] = $request->bed;
        // $data['bath'] = $request->bath;
        // $data['toilet'] = $request->toilet;
        // $data['address'] = $request->address;
        // $data['city'] = $request->city;
        // $data['state'] = $request->state;
        // $data['country'] = $request->country;
        // $data['zip'] = $request->zip;
        // $data['status'] = $request->status;
        // $data['imageFolder'] = $request->imageFolder;
        // $data['featuredImg'] = $request->featuredImg;
        // $data['poster'] = $request->intervals;
        // $data['views'] = $request->views;
        // $data['featured_property'] = $request->featured_property;
        // $data['available_date'] = date('Y-m-d');
        // $data['dateOfEntry'] = date('Y-m-d H:i:s');
        // $data['id'] = $request->id;
        $data['name'] = $request->name;
        $data['state_id'] = $request->state_id;

        $update = DB::table('cities')->where('id', $request->id)->update($data);
        if ($update) {
            return ["update"=>"updated"];
        } else {

            return ["update"=>"did not update"];
        }
    }

    public function checkAPI(){
        $client = new Client;
        $request = $client->get('http://127.0.0.1:8000/api/add-property-api/')->getBody()->getContents();  
        $data = json_decode($request, true);
        return view('welcome', compact('data'));
    }
    
}
