<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VerificationAPIController extends Controller
{
    public function verificationAPI($id=null){
        if($id){
            $verifications = DB::table('verifications')
            ->join('user_tbl', 'verifications.user_id', '=', 'user_tbl.userID')
            ->select('user_tbl.firstName as firstName', 'user_tbl.lastName as lastName', 'user_tbl.userID as userID', 'user_tbl.email as email', 'user_tbl.phone as phone', 'user_tbl.verified as verified', 'verifications.id as veriID', 'verifications.employment_status as employment_status', 'verifications.verification_id as verification_id', 'verifications.created_at as verifications_date', 'verifications.gross_annual_income as gross_annual_income', 'verifications.created_at as created_at')
            ->where('verifications.id',$id)
            ->orderBy('verifications.id','desc')
            ->get();
        }else {
            $verifications = DB::table('verifications')
            ->join('user_tbl', 'verifications.user_id', '=', 'user_tbl.userID')
            ->select('user_tbl.firstName as firstName', 'user_tbl.lastName as lastName', 'user_tbl.userID as userID', 'user_tbl.email as email', 'user_tbl.phone as phone', 'user_tbl.verified as verified', 'verifications.id as veriID', 'verifications.employment_status as employment_status', 'verifications.verification_id as verification_id', 'verifications.created_at as verifications_date', 'verifications.gross_annual_income as gross_annual_income', 'verifications.created_at as created_at')
            ->orderBy('verifications.id','desc')
            ->get();
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

    public function updateVerificationStatusAPI(Request $request)
    {

        $data = array();
        $data['verified'] = $request->verified;
        
        $update = DB::table('user_tbl')->where('userID', $request->userID)->update($data);
        $subscriber = DB::table('user_tbl')->where('userID', $request->userID)->first();
       
        if ($update) {
            
            $to = $subscriber->email;
            $firstName = $subscriber->firstName;
            $lastName = $subscriber->lastName;
            
            $subject = "Verification Completed";

            $message = "
            <!---Header starts here ---->
                <!doctype html>
                <html>
                <head>
                <meta charset='utf-8'>
                <meta name='viewport' content='width=device-width'>
                <title></title>
                </head>

                <body style='width:100%;padding:0;margin:0;box-sizing:border-box;'>
                    <div class='container' style='width:95%;min-height:100px;overflow:auto;margin:auto;box-sizing:border-box;'>
                        <table width='100%'>
                            <tr>
                                <td width='33.3%'>&nbsp;</td>
                                <td style='text-align:center' class='logo-container' width='33.3%'><img width='130px' src='https://www.rentsmallsmall.com/assets/img/logo-rss.png' /></td>
                                <td width='33.3%'>&nbsp;</td>
                            </tr>
                        </table>
                <!---Header ends here ---->

                <!---Body starts here ---->
                        <table width='100%' style='margin-top:30px'>
                            <tr>
                                <td width='100%'>
                                    <div class='message-container' style='width:100%;border-radius:10px;text-align:center;background:#F2FCFB;padding:40px;'>
                                        <div style='width:100%;	min-height:10px;overflow:auto;text-align:center;font-family:calibri;font-size:30px;margin-bottom:20px;' class='name'>Hello, $firstName</div>
                                        <div style='width:100%;min-height:10px;overflow:auto;text-align:center;font-family:calibri;font-size:20px;margin-bottom:20px;' class='intro'>Verification Completed</div>
                                        <div style='width:100%;min-height:30px;	overflow:auto;text-align:center;font-family:calibri;font-size:16px;margin-bottom:20px;' class='email-body'> Thank you for showing interest in subscribing one of our properties. This is to inform you that your verification has been completed and you are eligible to subscribe this property . You can now proceed to pay for your already booked apartment/Furniture. Proceed to your dashboard to continue.</div>
                                        <div style='width:100%;min-height:30px;	overflow:auto;text-align:center;font-family:calibri;font-size:16px;margin-bottom:20px;' class='email-body'>Please note: If payment is not made within 12 hours, the property will be available for the next person in the queue. Also, if payment is made after the stipulated time, the process of initiating a refund takes 7 days or a sum of two thousand naira (N2000) will be charged for an immediate refund. If you choose to cancel your booking, a 5% deduction would be applied.</div>
                                        <div style='width:100%;min-height:30px;	overflow:auto;text-align:center;font-family:calibri;font-size:16px;margin-bottom:20px;' class='email-body'> Subscription payment is easy on our platform, we use Paystack to collect payments on a modern secure payment gateway, this gateway offers users different modes of payment.  RentSmallsmall does not store bank card or personal account data.
If you encounter any problem using the payment gateway please contact RentSmallsmall Customer experience at customerexperience@rentsmallsmall.com or Call 070-877 89 815/ 0903-722-2669/ 0903-633-9800 for assistance. Thanks</div>
                                        
                                    </div>
                                </td>
                            </tr>
                        </table> 
                <!---Body ends here ---->

                <!---Footer starts here ---->
                    <div class='footer' style='width:100%;min-height:100px;overflow:auto;margin-top:40px;padding-top:40px;border-top:1px solid #00CDA6;padding:20px;'>
                            <div style='width:100%;min-height:10px;overflow:auto;margin-bottom:20px;font-family:avenir-regular;font-size:14px;text-align:center;' class='stay-connected-txt'>Stay connected to us</div>
                            <div style='width:100%;min-height:10px;overflow:auto;margin-bottom:30px;text-align:center;' class='social-spc'>
                                <ul class='social-container' style='display:inline-block;min-width:100px;min-height:10px;overflow:auto;margin:auto;list-style:none;padding:0;'>
                                    <li style='width:70px;min-height:10px;overflow:auto;float:left;text-align:center;' class='social-item'><a href='https://www.twitter.com/rentsmallsmall'><img width='50px' height='auto' src='https://www.rentsmallsmall.com/assets/img/twitter.png' /></a></li>
                                    <li style='width:70px;min-height:10px;overflow:auto;float:left;text-align:center;' class='social-item'><a href='https://www.facebook.com/rentsmallsmall'><img width='50px' height='auto' src='https://www.rentsmallsmall.com/assets/img/facebook.png' /></a></li>
                                    <li style='width:70px;min-height:10px;overflow:auto;float:left;text-align:center;' class='social-item'><a href='https://www.instagram.com/rentsmallsmall'><img width='50px' height='auto' src='https://www.rentsmallsmall.com/assets/img/instagram.png' /></a></li>
                                    <li style='width:70px;min-height:10px;overflow:auto;float:left;text-align:center;' class='social-item'><a href='https://www.linkedin.com/company/rentsmallsmall'><img width='50px' height='auto' src='https://www.rentsmallsmall.com/assets/img/linkedin.png' /></a></li>
                                </ul>
                            </div>
                            <div style='width:100%;min-height:30px;overflow:auto;text-align:center;line-height:30px;font-size:14px;font-family:avenir-regular;color:#00CDA6;' class='disclaimer'>
                                For help contact Customer experience<br />
                                at 090 722 2669, 0903 633 9800<br /> 
                                or email to customerexperience@rentsmallsmall.com
                            </div>
                        </div>
                    </div>
                </body>
                </html>
                <!---Footer ends here ---->

        ";

        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // More headers
        $headers .= 'From: <noreply@rentsmallsmall.com>' . "\r\n";
        $headers .= 'Cc: customerexperience@rentsmallsmall.com' . "\r\n";

        mail($to,$subject,$message,$headers);
 
            return redirect('https://rentsmallsmall.io/verification-status-update-success');
        } else {

            // return ["update"=>"did not update"];
            return redirect('https://rentsmallsmall.io/verification-status-update-failed');
        }
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
