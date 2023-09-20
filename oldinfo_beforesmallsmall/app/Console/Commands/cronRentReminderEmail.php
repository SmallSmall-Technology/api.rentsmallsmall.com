<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class cronRentReminderEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rent:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // date_default_timezone_set("Africa/Lagos");

        $today = strtotime(date('Y-m-d'));
        $rentReminders = DB::table('bookings')
            ->join('user_tbl', 'bookings.userID', '=', 'user_tbl.userID')
            ->select('user_tbl.firstName as firstName', 'user_tbl.lastName as lastName', 'user_tbl.email as email', 'user_tbl.phone as phone', 'bookings.userID as userID', 'bookings.next_rental as next_rental')
            ->where('bookings.rent_status','Occupied')->get();
            
            foreach($rentReminders as $rentReminder){
                $to2 = $rentReminder->email;
                $firstName = $rentReminder->firstName;
                $lastName = $rentReminder->lastName;
                $next_rental = $rentReminder->next_rental;
                
                $date7 = date('Y-m-d');
                $date7 = strtotime($date7);
                $date7 = strtotime("+7 day", $date7);
                $sevenDaysTime = date('Y-m-d', $date7);
                
                
                $date3 = date('Y-m-d');
                $date3 = strtotime($date3);
                $date3 = strtotime("+3 day", $date3);
                $threeDaysTime = date('Y-m-d', $date3);
                
                
                $dateDue = date('Y-m-d');
                $dateDue = strtotime($dateDue);
                $DueDayTime = date('Y-m-d', $dateDue);
                
                                        
                //$sevenDaysTime = strtotime('Y-m-d', ('+6 days 5hours'));
                if($next_rental == $sevenDaysTime){
                    $subject2 = "Subscription Reminder";   
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
                                            <div style='width:100%;	min-height:10px;overflow:auto;text-align:center;font-family:calibri;font-size:30px;margin-bottom:20px;' class='name'>Hello $lastName $firstName,</div>
                                            <div style='width:100%;min-height:10px;overflow:auto;text-align:center;font-family:calibri;font-size:20px;margin-bottom:20px;' class='intro'>Subscription Reminder</div>
                                            <div style='width:100%;min-height:30px;	overflow:auto;text-align:center;font-family:calibri;font-size:16px;margin-bottom:20px;' class='email-body'> Trust this email meets you well. <br>
                                            This is to notify you that your subscription will be due in 7 days time.<br> 
                                            You can make payment before the due date in order to increase your credit score with RSS.<br>
                                            <strong>Kindly make payment to our new account details below: <br>
                                            <strong>Bank:</strong> Providus Bank <br>
                                            <strong>Account #:</strong> 7900982382<br>
                                            <strong>Account Name:</strong> Rent Small Small Ltd<br><br>
                                            Thank you for choosing Rent Small Small.</div>
                                            
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
                    $headers .= 'From: <customerexperience@rentsmallsmall.com>' . "\r\n";
                    $headers .= 'BCC: customerexperience@rentsmallsmall.com' . "\r\n";
                    $headers .= 'BCC: accounts@rentsmallsmall.com' . "\r\n";
                    
                    mail($to2,$subject2,$message2,$headers);
                // info('rent reminder');
            
            
                }elseif($next_rental == $threeDaysTime){
                    $subject2 = "Subscription Reminder";   
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
                                            <div style='width:100%;	min-height:10px;overflow:auto;text-align:center;font-family:calibri;font-size:30px;margin-bottom:20px;' class='name'>Hello $lastName $firstName,</div>
                                            <div style='width:100%;min-height:10px;overflow:auto;text-align:center;font-family:calibri;font-size:20px;margin-bottom:20px;' class='intro'>Subscription Reminder</div>
                                            <div style='width:100%;min-height:30px;	overflow:auto;text-align:center;font-family:calibri;font-size:16px;margin-bottom:20px;' class='email-body'> Trust this email meets you well. <br>
                                            This is to notify you that your subscription will be due in 3 days time.<br> 
                                            You can make payment before the due date in order to increase your credit score with RSS.<br>
                                            <strong>Kindly make payment to our new account details below: <br>
                                            <strong>Bank:</strong> Providus Bank <br>
                                            <strong>Account #:</strong> 7900982382<br>
                                            <strong>Account Name:</strong> Rent Small Small Ltd<br><br>
                                            Thank you for choosing Rent Small Small.</div>
                                            
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
                    $headers .= 'From: <customerexperience@rentsmallsmall.com>' . "\r\n";
                    $headers .= 'BCC: customerexperience@rentsmallsmall.com' . "\r\n";
                    $headers .= 'BCC: accounts@rentsmallsmall.com' . "\r\n";
                    
                    mail($to2,$subject2,$message2,$headers);
                // info('rent reminder');
            
            
                }elseif($next_rental == $DueDayTime){
                    $subject2 = "Subscription Reminder";   
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
                                            <div style='width:100%;	min-height:10px;overflow:auto;text-align:center;font-family:calibri;font-size:30px;margin-bottom:20px;' class='name'>Hello $lastName $firstName,</div>
                                            <div style='width:100%;min-height:10px;overflow:auto;text-align:center;font-family:calibri;font-size:20px;margin-bottom:20px;' class='intro'>Subscription Reminder</div>
                                            <div style='width:100%;min-height:30px;	overflow:auto;text-align:center;font-family:calibri;font-size:16px;margin-bottom:20px;' class='email-body'> I hope this email meets you well.<br>
                                            This notice is to inform you that your subscription is due today and your grace period will expire in 2 days time.<br>
                                            You will be charged a late fee of N3000 after the expiration of your grace period.<br>
                                            Late Payment Policy :<br>

                                            1. Any subscription not paid by the end of the second day after your subscription due date is subject to a three thousand Naira (N3,000) late fee charge every day.<br>

                                            2. Please note if your subscription is not paid after your grace period, eviction procedures will be initiated against you.<br>

                                            3. A 100% late charge is still applicable to all subscribers who have paid a percentage of their subscription.<br>
                                            <strong>Kindly make payment to our new account details below: <br>
                                            <strong>Bank:</strong> Providus Bank <br>
                                            <strong>Account #:</strong> 7900982382<br>
                                            <strong>Account Name:</strong> Rent Small Small Ltd<br><br>
                                            Thank you for choosing Rent Small Small.</div>
                                            
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
                    $headers .= 'From: <customerexperience@rentsmallsmall.com>' . "\r\n";
                    $headers .= 'BCC: customerexperience@rentsmallsmall.com' . "\r\n";
                    $headers .= 'BCC: accounts@rentsmallsmall.com' . "\r\n";
                    
                    mail($to2,$subject2,$message2,$headers);
                // info('rent reminder');
            
            
                }
                
                
            
                    }
                    return 0;
                 //second email
                //$to2 = 'dikcondtn@yahoo.com';
                
            }
}
