<?php

namespace App\Http\Controllers;

use App\Mail\InspectionEmail;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class InspectionAPIController extends Controller
{
    public function inspectionAPI($id=null){
        if($id){
            // $inspections = DB::table('inspection_tbl')->where('id',$id)->get();
            $inspections = DB::table('inspection_tbl')
            ->join('user_tbl', 'inspection_tbl.userID', '=', 'user_tbl.userID')
            ->join('property_tbl', 'inspection_tbl.propertyID', '=', 'property_tbl.propertyID')
            //->join('admin_tbl', 'inspection_tbl.assigned_tsr', '=', 'admin_tbl.adminID')
            ->select('user_tbl.firstName as firstName', 'user_tbl.lastName as lastName', 'user_tbl.email as email', 'user_tbl.phone as phone', 'user_tbl.verified as verified', 'inspection_tbl.userID as userID', 'inspection_tbl.id as id', 'inspection_tbl.inspectionID as inspectionID', 'inspection_tbl.propertyID as propertyID', 'inspection_tbl.inspectionDate as inspectionDate', 'inspection_tbl.updated_inspection_date as updated_inspection_date', 'inspection_tbl.inspectionType as inspectionType', 'inspection_tbl.dateOfEntry as dateOfEntry', 'property_tbl.propertyTitle as propertyTitle', 'inspection_tbl.assigned_tsr as assigned_tsr', 'inspection_tbl.inspection_status as inspection_status', 'inspection_tbl.inspection_remarks as inspection_remarks', 'inspection_tbl.comment as comment', 'inspection_tbl.follow_up_stage as follow_up_stage', 'inspection_tbl.customer_inspec_feedback as customer_inspec_feedback', 'inspection_tbl.cx_feedback_details as cx_feedback_details', 'property_tbl.propertyTitle as propertyTitle')
            ->where('inspection_tbl.id',$id)->orderBy('inspection_tbl.id','desc')->get();
            
        }else {
            // $inspections = DB::table('inspection_tbl')->get();
            $inspections = DB::table('inspection_tbl')
            ->join('user_tbl', 'inspection_tbl.userID', '=', 'user_tbl.userID')
            ->join('property_tbl', 'inspection_tbl.propertyID', '=', 'property_tbl.propertyID')
            //->join('admin_tbl', 'inspection_tbl.assigned_tsr', '=', 'admin_tbl.adminID')
            ->select('user_tbl.firstName as firstName', 'user_tbl.lastName as lastName', 'user_tbl.email as email', 'user_tbl.phone as phone', 'user_tbl.verified as verified', 'inspection_tbl.userID as userID', 'inspection_tbl.id as id', 'inspection_tbl.inspectionID as inspectionID', 'inspection_tbl.propertyID as propertyID', 'inspection_tbl.inspectionDate as inspectionDate', 'inspection_tbl.updated_inspection_date as updated_inspection_date', 'inspection_tbl.inspectionType as inspectionType', 'inspection_tbl.dateOfEntry as dateOfEntry', 'property_tbl.propertyTitle as propertyTitle','inspection_tbl.assigned_tsr as assigned_tsr','inspection_tbl.inspection_status as inspection_status', 'inspection_tbl.inspection_remarks as inspection_remarks', 'inspection_tbl.comment as comment', 'inspection_tbl.follow_up_stage as follow_up_stage', 'inspection_tbl.customer_inspec_feedback as customer_inspec_feedback', 'inspection_tbl.cx_feedback_details as cx_feedback_details', 'property_tbl.propertyTitle as propertyTitle')
            ->orderBy('inspection_tbl.id','desc')->get();
        }
        
        return $inspections;
    }

    public function inspectionCountAPI($id=null){
        if($id){
            $inspectionsCount = DB::table('inspection_tbl')->where('id',$id)->count();
            
        }else {
            $inspectionsCount = DB::table('inspection_tbl')->count();
        }
        
        return $inspectionsCount;
    }

    

    public function updateInspectionAPI(Request $request)
    {

        $data = array();
        $data['updated_inspection_date'] = $request->updated_inspection_date;
        $data['assigned_tsr'] = $request->assigned_tsr;
        // $updated_inspection_date = $data['updated_inspection_date'];
        $updated_inspection_date = date('d-M-Y',strtotime($data['updated_inspection_date']));
        $updated_inspection_time = date('H:i:s',strtotime($data['updated_inspection_date']));
        $data['inspection_status'] = 'pending-assigned';

        $update = DB::table('inspection_tbl')->where('id', $request->id)->update($data);

        $inspectingTenantInfo = DB::table('user_tbl')->where('userID',$request->userID)->first();
        // dd($inspectingTenantInfo);
        $inspection_email = $inspectingTenantInfo->email;
        $inspection_name = $inspectingTenantInfo->firstName.' '.$inspectingTenantInfo->lastName;
        // foreach($inspectingTenantInfo as $inspectingTenantInfoSingle){
        //     echo $inspection_email = $inspectingTenantInfoSingle['email'];
        // }

        // exit;
        $assigned_tsr = $request->assigned_tsr;
        $tsr = DB::table('admin_tbl')->where('adminID',$assigned_tsr)->first();

        if ($update) {
            // $inspection_email = 'dikcondtn@yahoo.com';
            // Mail::send('mail.inspectionUpdate', ['name' =>'Doveway'], function($message){
            //     $message->from('noreply@rentsmallsmall.com', 'Inspection Update');
            //     $message->to('dikcondtn@yahoo.com');
            // });
            // Mail::to($form1->email)->send(new ThankYouMail($form1));
            // Mail::to('dikcondtn@yahoo.com')->send(new InspectionEmail($data));
            // $details = [
            //     'title' => 'Mail from ItSolutionStuff.com',
            //     'body' => 'This is for testing email using smtp'
            // ];
            // Mail::to('dikcondtn@yahoo.com')->send(new InspectionEmail($details));
            // return ["update"=>"updated"];
            $propertyTitle = $request->propertyTitle;

            $to = $inspection_email;
            $subject = "Inspection Update";

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
                                        <div style='width:100%;	min-height:10px;overflow:auto;text-align:center;font-family:calibri;font-size:30px;margin-bottom:20px;' class='name'>Hello $inspection_name,</div>
                                        <div style='width:100%;min-height:10px;overflow:auto;text-align:center;font-family:calibri;font-size:20px;margin-bottom:20px;' class='intro'>Inspection Date Updated</div>
                                        <div style='width:100%;min-height:30px;	overflow:auto;text-align:center;font-family:calibri;font-size:16px;margin-bottom:20px;' class='email-body'> This is to inform you that your inspection date for $propertyTitle has been updated to $updated_inspection_date at $updated_inspection_time GMT+1</div>
                                        <div style='width:100%;min-height:30px;	overflow:auto;text-align:center;font-family:calibri;font-size:16px;margin-bottom:20px;' class='email-body'> Kindly contact $tsr->firstName $tsr->lastName on $tsr->phone for inspection.</div>
                                        <div style='width:100%;min-height:30px;	overflow:auto;text-align:center;font-family:calibri;font-size:16px;margin-bottom:20px;' class='email-body'> Thanks for choosing RentSmallSmall.</div>
                                        
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


        //second email
        $to2 = $tsr->email;
        $subject2 = "Inspection Update";

        $message2 = "
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
                                    <div style='width:100%;	min-height:10px;overflow:auto;text-align:center;font-family:calibri;font-size:30px;margin-bottom:20px;' class='name'>Hello TSR,</div>
                                    <div style='width:100%;min-height:10px;overflow:auto;text-align:center;font-family:calibri;font-size:20px;margin-bottom:20px;' class='intro'>Inspection Date Updated</div>
                                    <div style='width:100%;min-height:30px;	overflow:auto;text-align:center;font-family:calibri;font-size:16px;margin-bottom:20px;' class='email-body'> This is to inform you that an inspection has been scheduled. The inspection details are as follows:<br> 
                                    <strong>Prospective Native:</strong> $inspection_name <br>
                                    <strong>Property:</strong> $propertyTitle <br>
                                    <strong>Updated Inspection Date:</strong> $updated_inspection_date at $updated_inspection_time GMT+1</div>
                                    
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
            // $headers .= 'Cc: myboss@example.com' . "\r\n";

            mail($to,$subject,$message,$headers);

            

        mail($to2,$subject2,$message2,$headers);

        //new unione template
        require 'vendor/autoload.php';

$headers = array(
    'Content-Type' => 'application/json',
    'Accept' => 'application/json',
    'X-API-KEY' => '6tkb5syz5g1bgtkz1uonenrxwpngrwpq9za1u6ha',
);

$client = new \GuzzleHttp\Client([
    'base_uri' => 'https://us1.unione.io/en/transactional/api/v1/'
]);

$requestBody = [
  "message" => [
    "recipients" => [
      [
        "email" => "dikcondtn@yahoo.com",
        "substitutions" => [
          "CustomerId" => 12452,
          "to_name" => "Doveway"
        ],
        "metadata" => [
          "campaign_id" => "c77f4f4e-3561-49f7-9f07-c35be01b4f43",
          "customer_hash" => "b253ac7"
        ]
      ]
    ],
    "template_id" => "string",
    "tags" => [
      "string1"
    ],
    "skip_unsubscribe" => 0,
    "global_language" => "string",
    "template_engine" => "simple",
    "global_substitutions" => [
      "property1" => "string",
      "property2" => "string"
    ],
    "global_metadata" => [
      "property1" => "string",
      "property2" => "string"
    ],
    "body" => [
      "html" => "<b>Hello, {{to_name}}</b>",
      "plaintext" => "Hello, {{to_name}}",
      "amp" => "<!doctype html><html amp4email><head> <meta charset=\"utf-8\"><script async src=\"https://cdn.ampproject.org/v0.js\"></script> <style amp4email-boilerplate>body[visibility:hidden]</style></head><body> Hello, AMP4EMAIL world.</body></html>"
    ],
    "subject" => "string",
    "from_email" => "user@example.com",
    "from_name" => "John Smith",
    "reply_to" => "user@example.com",
    "track_links" => 0,
    "track_read" => 0,
    "bypass_global" => 0,
    "bypass_unavailable" => 0,
    "bypass_unsubscribed" => 0,
    "bypass_complained" => 0,
    "headers" => [
      "X-MyHeader" => "some data",
      "List-Unsubscribe" => "<mailto: unsubscribe@example.com?subject=unsubscribe>, <http://www.example.com/unsubscribe/{{CustomerId}}>"
    ],
    "attachments" => [
      [
        "type" => "text/plain",
        "name" => "readme.txt",
        "content" => "SGVsbG8sIHdvcmxkIQ=="
      ]
    ],
    "inline_attachments" => [
      [
        "type" => "image/gif",
        "name" => "IMAGECID1",
        "content" => "R0lGODdhAwADAIABAP+rAP///ywAAAAAAwADAAACBIQRBwUAOw=="
      ]
    ],
    "options" => [
      "send_at" => "2021-11-19 10:00:00",
      "unsubscribe_url" => "https://example.org/unsubscribe/{{CustomerId}}",
      "custom_backend_id" => 0,
      "smtp_pool_id" => "string"
    ]
  ]
];

try {
    $response = $client->request('POST','email/send.json', array(
        'headers' => $headers,
        'json' => $requestBody,
       )
    );
    print_r($response->getBody()->getContents());
 }
 catch (\GuzzleHttp\Exception\BadResponseException $e) {
    // handle exception or api errors.
    print_r($e->getMessage());
 }

 //unione template ends


            return redirect('https://rentsmallsmall.io/inspection-update-success');
        } else {

            // return ["update"=>"did not update"];
            return redirect('https://rentsmallsmall.io/inspection-update-failed');
        }
    }

    // public function updateInspectionStatusAPI(Request $request)
    // {

    //     $data = array();
    //     $data['inspection_status'] = $request->inspection_status;
    //     $data['inspection_remarks'] = $request->inspection_remarks;
    //     $data['comment'] = $request->comment;
        
    //     $update = DB::table('inspection_tbl')->where('id', $request->id)->update($data);
       
    //     if ($update) {
 
    //         return redirect('https://rentsmallsmall.io/inspection-status-update-success');
    //     } else {

    //         // return ["update"=>"did not update"];
    //         return redirect('https://rentsmallsmall.io/inspection-status-update-failed');
    //     }
    // }
    
    public function updateInspectionStatusAPI(Request $request)
    {

        $data = array();
        $data['inspection_status'] = $request->inspection_status;
        $data['inspection_remarks'] = $request->inspection_remarks;
        $data['comment'] = $request->comment;
        
        $update = DB::table('inspection_tbl')->where('id', $request->id)->update($data);
       
        if ($update) {
            if($data['inspection_status'] = 'completed'){
                //second email
            $to = 'customerexperience@smallsmall.com';
            $firstName = $request->firstName;
            $lastName = $request->lastName;
            $propertyID = $request->propertyID;
            $propertyTitle = $request->propertyTitle;
            $subject = "Inspection Completed";

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
                                        <div style='width:100%;	min-height:10px;overflow:auto;text-align:center;font-family:calibri;font-size:30px;margin-bottom:20px;' class='name'>Dear Team,</div>
                                        <div style='width:100%;min-height:10px;overflow:auto;text-align:center;font-family:calibri;font-size:20px;margin-bottom:20px;' class='intro'>Inspection Completed</div>
                                        <div style='width:100%;min-height:30px;	overflow:auto;text-align:center;font-family:calibri;font-size:16px;margin-bottom:20px;' class='email-body'>
                                        

This is to inform you that the inspection of $firstName $lastName to <a href='https://rent.smallsmall.com/property/$propertyID'>($propertyTitle)</a> is completed.<br>

<br><br>

Regards, 
                                       </div>
                                        
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
                                or email to customerexperience@smallsmall.com
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
                $headers .= 'From: <noreply@smallsmall.com>' . "\r\n";
                // $headers .= 'Cc: myboss@example.com' . "\r\n";
    
                mail($to,$subject,$message,$headers);

            }
 
            // return redirect('https://rentsmallsmall.io/inspection-status-update-success');
            return redirect('https://rentsmallsmall.io/all-pending-inspections-tsr');
        } else {

            // return ["update"=>"did not update"];
            return redirect('https://rentsmallsmall.io/inspection-status-update-failed');
        }
    }
    
    public function updatePostInspectionFeedbackAPI(Request $request)
    {

        $data = array();
        $data['customer_inspec_feedback'] = $request->customer_inspec_feedback;
        $data['cx_feedback_details'] = $request->cx_feedback_details;
        
        $update = DB::table('inspection_tbl')->where('id', $request->id)->update($data);
       
        if ($update) {
 
            return redirect('https://rentsmallsmall.io/inspection-post-inspec-feedback-success');
        } else {

            // return ["update"=>"did not update"];
            return redirect('https://rentsmallsmall.io/inspection-post-inspec-feedback-failed');
        }
    }

    public function inspectionTSRAPI($id=null){
        if($id){
            // $inspections = DB::table('inspection_tbl')->where('id',$id)->get();
            $inspectionsTSR = DB::table('inspection_tbl')
            ->join('user_tbl', 'inspection_tbl.userID', '=', 'user_tbl.userID')
            ->join('property_tbl', 'inspection_tbl.propertyID', '=', 'property_tbl.propertyID')
            ->select('user_tbl.firstName as firstName', 'user_tbl.lastName as lastName', 'user_tbl.email as email', 'inspection_tbl.userID as userID', 'inspection_tbl.id as id', 'inspection_tbl.inspectionID as inspectionID', 'inspection_tbl.propertyID as propertyID', 'inspection_tbl.inspectionDate as inspectionDate', 'inspection_tbl.updated_inspection_date as updated_inspection_date', 'inspection_tbl.inspectionType as inspectionType', 'inspection_tbl.dateOfEntry as dateOfEntry', 'property_tbl.propertyTitle as propertyTitle')
            ->where('inspection_tbl.id',$id)->where('inspection_tbl.assigned_tsr',Auth::user()->parent_id)->get();
            
        }else {
            // $inspections = DB::table('inspection_tbl')->get();
            $inspections = DB::table('inspection_tbl')
            ->join('user_tbl', 'inspection_tbl.userID', '=', 'user_tbl.userID')
            ->join('property_tbl', 'inspection_tbl.propertyID', '=', 'property_tbl.propertyID')
            ->select('user_tbl.firstName as firstName', 'user_tbl.lastName as lastName', 'user_tbl.email as email', 'inspection_tbl.userID as userID', 'inspection_tbl.id as id', 'inspection_tbl.inspectionID as inspectionID', 'inspection_tbl.propertyID as propertyID', 'inspection_tbl.inspectionDate as inspectionDate', 'inspection_tbl.updated_inspection_date as updated_inspection_date', 'inspection_tbl.inspectionType as inspectionType', 'inspection_tbl.dateOfEntry as dateOfEntry', 'property_tbl.propertyTitle as propertyTitle')
            ->where('inspection_tbl.assigned_tsr',Auth::user()->parent_id)->get();
        }
        
        return $inspections;
    }

    public function myInspectionAPI($id=null){
        if($id){
            // $inspections = DB::table('inspection_tbl')->where('id',$id)->get();
            $myInspections = DB::table('inspection_tbl')
            ->join('user_tbl', 'inspection_tbl.userID', '=', 'user_tbl.userID')
            ->join('property_tbl', 'inspection_tbl.propertyID', '=', 'property_tbl.propertyID')
            ->select('user_tbl.firstName as firstName', 'user_tbl.lastName as lastName', 'user_tbl.email as email', 'inspection_tbl.userID as userID', 'inspection_tbl.id as id', 'inspection_tbl.inspectionID as inspectionID', 'inspection_tbl.propertyID as propertyID', 'inspection_tbl.inspectionDate as inspectionDate', 'inspection_tbl.updated_inspection_date as updated_inspection_date', 'inspection_tbl.inspectionType as inspectionType', 'inspection_tbl.dateOfEntry as dateOfEntry', 'property_tbl.propertyTitle as propertyTitle')
            ->where('inspection_tbl.assigned_tsr',$id)->orderBy('inspection_tbl.id','desc')->get();
            
        }else {
            // $inspections = DB::table('inspection_tbl')->get();
            $myInspections = DB::table('inspection_tbl')
            ->join('user_tbl', 'inspection_tbl.userID', '=', 'user_tbl.userID')
            ->join('property_tbl', 'inspection_tbl.propertyID', '=', 'property_tbl.propertyID')
            ->select('user_tbl.firstName as firstName', 'user_tbl.lastName as lastName', 'user_tbl.email as email', 'inspection_tbl.userID as userID', 'inspection_tbl.id as id', 'inspection_tbl.inspectionID as inspectionID', 'inspection_tbl.propertyID as propertyID', 'inspection_tbl.inspectionDate as inspectionDate', 'inspection_tbl.updated_inspection_date as updated_inspection_date', 'inspection_tbl.inspectionType as inspectionType', 'inspection_tbl.dateOfEntry as dateOfEntry', 'property_tbl.propertyTitle as propertyTitle')
            ->orderBy('inspection_tbl.id','desc')->get();
        }
        
        return $myInspections;
    }

    public function inspectionsThisMonth($id=null){
        if($id){
            $currentMonth = date('m');
            $currentYear = date('Y');
        //$data = DB::table("items")
            //->whereRaw('MONTH(created_at) = ?',[$currentMonth])
            //->get();

            // $inspections = DB::table('inspection_tbl')->where('id',$id)->get();
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
    
    public function inspectionsLastMonth($id=null){
        if($id){
            $currentMonth = date('m');
            $lastMonth = $currentMonth - 1;
            $currentYear = date('Y');
        //$data = DB::table("items")
            //->whereRaw('MONTH(created_at) = ?',[$currentMonth])
            //->get();

            // $inspections = DB::table('inspection_tbl')->where('id',$id)->get();
            $inspections = DB::table('inspection_tbl')
            ->join('user_tbl', 'inspection_tbl.userID', '=', 'user_tbl.userID')
            ->join('property_tbl', 'inspection_tbl.propertyID', '=', 'property_tbl.propertyID')
            ->select('user_tbl.firstName as firstName', 'user_tbl.lastName as lastName', 'user_tbl.email as email', 'user_tbl.phone as phone', 'inspection_tbl.userID as userID', 'inspection_tbl.id as id', 'inspection_tbl.inspectionID as inspectionID', 'inspection_tbl.propertyID as propertyID', 'inspection_tbl.inspectionDate as inspectionDate', 'inspection_tbl.updated_inspection_date as updated_inspection_date', 'inspection_tbl.inspectionType as inspectionType', 'inspection_tbl.dateOfEntry as dateOfEntry', 'property_tbl.propertyTitle as propertyTitle', 'inspection_tbl.assigned_tsr as assigned_tsr', 'inspection_tbl.inspection_status as inspection_status', 'inspection_tbl.inspection_remarks as inspection_remarks', 'inspection_tbl.comment as comment', 'inspection_tbl.follow_up_stage as follow_up_stage', 'property_tbl.propertyTitle as propertyTitle')
            ->where('inspection_tbl.id',$id)->whereRaw('MONTH(inspection_tbl.dateOfEntry) = ?',[$lastMonth])->whereRaw('YEAR(inspection_tbl.dateOfEntry) = ?',[$currentYear])
            ->orderBy('inspection_tbl.id','desc')->get();
            
        }else {
            // $inspections = DB::table('inspection_tbl')->get();
            $currentMonth = date('m');
            $lastMonth = $currentMonth - 1;
            $currentYear = date('Y');

            $inspections = DB::table('inspection_tbl')
            ->join('user_tbl', 'inspection_tbl.userID', '=', 'user_tbl.userID')
            ->join('property_tbl', 'inspection_tbl.propertyID', '=', 'property_tbl.propertyID')
            ->select('user_tbl.firstName as firstName', 'user_tbl.lastName as lastName', 'user_tbl.email as email', 'user_tbl.phone as phone', 'inspection_tbl.userID as userID', 'inspection_tbl.id as id', 'inspection_tbl.inspectionID as inspectionID', 'inspection_tbl.propertyID as propertyID', 'inspection_tbl.inspectionDate as inspectionDate', 'inspection_tbl.updated_inspection_date as updated_inspection_date', 'inspection_tbl.inspectionType as inspectionType', 'inspection_tbl.dateOfEntry as dateOfEntry', 'property_tbl.propertyTitle as propertyTitle','inspection_tbl.assigned_tsr as assigned_tsr','inspection_tbl.inspection_status as inspection_status', 'inspection_tbl.inspection_remarks as inspection_remarks', 'inspection_tbl.comment as comment', 'inspection_tbl.follow_up_stage as follow_up_stage', 'property_tbl.propertyTitle as propertyTitle')
            ->whereRaw('MONTH(inspection_tbl.dateOfEntry) = ?',[$lastMonth])->whereRaw('YEAR(inspection_tbl.dateOfEntry) = ?',[$currentYear])
            ->orderBy('inspection_tbl.id','desc')->get();
        }
        
        return $inspections;
    }
    
    public function multipleInspection(Request $request)
    {

        $data = array();
        $data['inspection_status'] = $request->inspection_status;

        $update = DB::table('inspection_tbl')->where('id', $request->id)->update($data);
       
        if ($update) {
 
            return redirect('https://rentsmallsmall.io/inspection-status-update-success');
        } else {

            // return ["update"=>"did not update"];
            return redirect('https://rentsmallsmall.io/inspection-status-update-failed');
        }
    }
    
    public function apartmentNotAvailable(Request $request)
    {

        $data = array();
        $data['inspection_status'] = $request->inspection_status;
        // $data['email'] = $request->email;
        $email = $request->email;

        $update = DB::table('inspection_tbl')->where('id', $request->id)->update($data);
       
        if ($update) {
            
            //second email
            $to = $email;
            $firstName = $request->firstName;
            $propertyID = $request->propertyID;
            $propertyTitle = $request->propertyTitle;
            $subject = "Apartment Not Available";

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
                                        <div style='width:100%;	min-height:10px;overflow:auto;text-align:center;font-family:calibri;font-size:30px;margin-bottom:20px;' class='name'>Dear $firstName,</div>
                                        <div style='width:100%;min-height:10px;overflow:auto;text-align:center;font-family:calibri;font-size:20px;margin-bottom:20px;' class='intro'>Property Not Available</div>
                                        <div style='width:100%;min-height:30px;	overflow:auto;text-align:center;font-family:calibri;font-size:16px;margin-bottom:20px;' class='email-body'>
                                        Thank you for indicating interest in our property.<br>

We regret to inform you that the unit you are requesting to see <a href='https://rent.smallsmall.com/property/$propertyID'>($propertyTitle)</a> is unavailable.<br>

We apologize for the inconvenience this may cause you and we hope that you will be interested in other units on our platform.<br>

Kindly visit www.rent.smallsmall.com to check alternative options. <br>

Thank you for choosing Smallsmall.<br><br>

Regards, 
                                       </div>
                                        
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
                                or email to customerexperience@smallsmall.com
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
                $headers .= 'From: <noreply@smallsmall.com>' . "\r\n";
                // $headers .= 'Cc: myboss@example.com' . "\r\n";
    
                mail($to,$subject,$message,$headers);

            

 
            return redirect('https://rentsmallsmall.io/inspection-status-update-success');
        } else {

            // return ["update"=>"did not update"];
            return redirect('https://rentsmallsmall.io/inspection-status-update-failed');
        }
    }


    public function checkAPI(){
        $client = new Client;
        $request = $client->get('http://127.0.0.1:8000/api/add-property-api/')->getBody()->getContents();  
        $data = json_decode($request, true);
        return view('welcome', compact('data'));
    }
    
}
