<?php

namespace App\Http\Controllers;

use App\Mail\InspectionEmail;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class StaySmallSmallAPIController extends Controller
{
    public function bookingsAPI($id=null){
        if($id){
            $stayoneBooking = DB::table('stayone_booking')
            ->join('stayone_apartments', 'stayone_booking.aptID', '=', 'stayone_apartments.apartmentID')
            ->select('stayone_booking.id as id', 'stayone_booking.firstname as firstname', 'stayone_booking.lastname as lastname', 'stayone_booking.email as email', 'stayone_booking.phone as phone', 'stayone_booking.guests as guests', 'stayone_booking.date_of_booking as date_of_booking', 'stayone_booking.checkin as checkin', 'stayone_booking.checkout as checkout', 'stayone_apartments.apartmentName as apartmentName', 'stayone_booking.address as address', 'stayone_booking.nok_fullname as nok_fullname','stayone_booking.nok_email as nok_email', 'stayone_booking.nok_phone as nok_phone', 'stayone_booking.nok_address as nok_address', 'stayone_booking.no_of_nights as no_of_nights', 'stayone_booking.comment as comment', 'stayone_booking.cost as cost', 'stayone_booking.pickup_option as pickup_option', 'stayone_booking.pickup_location as pickup_location', 'stayone_booking.pickup_cost as pickup_cost', 'stayone_booking.userID as userID', 'stayone_booking.identification as identification')
            ->where('stayone_booking.id',$id)->orderBy('stayone_booking.id','desc')->get();
            
        }else {
            $stayoneBooking = DB::table('stayone_booking')
            ->join('stayone_apartments', 'stayone_booking.aptID', '=', 'stayone_apartments.apartmentID')
            ->select('stayone_booking.id as id', 'stayone_booking.firstname as firstname', 'stayone_booking.lastname as lastname', 'stayone_booking.email as email', 'stayone_booking.phone as phone', 'stayone_booking.guests as guests', 'stayone_booking.date_of_booking as date_of_booking', 'stayone_booking.checkin as checkin', 'stayone_booking.checkout as checkout', 'stayone_apartments.apartmentName as apartmentName', 'stayone_booking.address as address', 'stayone_booking.nok_fullname as nok_fullname','stayone_booking.nok_email as nok_email', 'stayone_booking.nok_phone as nok_phone', 'stayone_booking.nok_address as nok_address', 'stayone_booking.no_of_nights as no_of_nights', 'stayone_booking.comment as comment', 'stayone_booking.cost as cost', 'stayone_booking.pickup_option as pickup_option', 'stayone_booking.pickup_location as pickup_location', 'stayone_booking.pickup_cost as pickup_cost', 'stayone_booking.userID as userID', 'stayone_booking.identification as identification')
            ->orderBy('stayone_booking.id','desc')->get();
        }
        
        return $stayoneBooking;
    }

    
}
