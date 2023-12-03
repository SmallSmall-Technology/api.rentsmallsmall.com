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
                                    <td style='text-align:center' class='logo-container' width='33.3%'><img width='130px' src='https://smallsmall.com/front/assets/img/rss-png.png' /></td>
                                    <td width='33.3%'>&nbsp;</td>
                                </tr>
                            </table>
                    <!---Header ends here ---->
        
                    <!---Body starts here ---->
<style>
        /* only animate if the device supports hover */
@media (hover: hover) {
  #creditcard {
    /*  set start position */
    transform: translateY(110px);
    transition: transform 0.1s ease-in-out;
    /*  set transition for mouse enter & exit */
  }

  #money {
    /*  set start position */
    transform: translateY(180px);
    transition: transform 0.1s ease-in-out;
    /*  set transition for mouse enter & exit */
  }

  button:hover #creditcard {
    transform: translateY(0px);
    transition: transform 0.2s ease-in-out;
    /*  overide transition for mouse enter */
  }

  button:hover #money {
    transform: translateY(0px);
    transition: transform 0.3s ease-in-out;
    /*  overide transition for mouse enter */
  }
}

@keyframes bounce {
  0% {
    transform: translateY(0);
  }
  50% {
    transform: translateY(-0.25rem);
  }
  100% {
    transform: translateY(0);
  }
}

.button:hover .button__text span {
  transform: translateY(-0.25rem);
  transition: transform .2s ease-in-out;
}

/* styling */

body {
  height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
}

.button {
  border: none;
  outline: none;
  background-color: #007dc1;
  padding: 1rem 90px 1rem 2rem;
  position: relative;
  border-radius: 8px;
  letter-spacing: 0.7px;
  background-color: #007dc1;
  color: #fff;
  font-size: 21px;
  font-family: sans-serif;
  cursor: pointer;
  box-shadow: rgba(0, 9, 61, 0.2) 0px 4px 8px 0px;
}

.button:active {
  transform: translateY(1px);
}

.button__svg {
  position: absolute;
  overflow: visible;
  bottom: 6px;
  right: 0.2rem;
  height: 140%;
}

    </style>
    <table width='100%' style='margin-top:30px'>
        <tr>
            <td width='100%'>
                <div class='message-container' style='width:100%;border-radius:10px;text-align:center;background:#F2FCFB;padding:40px;'>
                    <div style='width:100%;	min-height:10px;overflow:auto;text-align:center;font-family:calibri;font-size:30px;margin-bottom:20px;' class='name'>Hello $lastName $firstName,</div>
                    <div style='width:100%;min-height:10px;overflow:auto;text-align:center;font-family:calibri;font-size:20px;margin-bottom:20px;' class='intro'>Subscription Reminder</div>
                    <div style='width:100%;min-height:30px;	overflow:auto;text-align:center;font-family:calibri;font-size:16px;margin-bottom:20px;' class='email-body'> Trust this email meets you well. <br>
                    This is to notify you that your subscription will be due in 7 days time.<br> 
                    You can make payment before the due date in order to increase your credit score with RSS.<br>
                    <br><strong>Kindly click the Pay Now button 

                            <button class='button'>
                                <span class='button__text'>
                                <span>P</span><span>a</span>y</span><span> </span><span>N</span><span>o</span><span>w</span><span></span><span></span>
                                </span>
                                <svg class='button__svg' role='presentational' viewBox='0 0 600 600'>
                                <defs>
                                    <clipPath id='myClip'>
                                    <rect x='0' y='0' width='100%' height='50%' />
                                    </clipPath>
                                </defs>
                                <g clip-path='url(#myClip)'>
                                    <g id='money'>
                                    <path d='M441.9,116.54h-162c-4.66,0-8.49,4.34-8.62,9.83l.85,278.17,178.37,2V126.37C450.38,120.89,446.56,116.52,441.9,116.54Z' fill='#699e64' stroke='#323c44' stroke-miterlimit='10' stroke-width='14' />
                                    <path d='M424.73,165.49c-10-2.53-17.38-12-17.68-24H316.44c-.09,11.58-7,21.53-16.62,23.94-3.24.92-5.54,4.29-5.62,8.21V376.54H430.1V173.71C430.15,169.83,427.93,166.43,424.73,165.49Z' fill='#699e64' stroke='#323c44' stroke-miterlimit='10' stroke-width='14' />
                                    </g>
                                    <g id='creditcard'>
                                    <path d='M372.12,181.59H210.9c-4.64,0-8.45,4.34-8.58,9.83l.85,278.17,177.49,2V191.42C380.55,185.94,376.75,181.57,372.12,181.59Z' fill='#a76fe2' stroke='#323c44' stroke-miterlimit='10' stroke-width='14' />
                                    <path d='M347.55,261.85H332.22c-3.73,0-6.76-3.58-6.76-8v-35.2c0-4.42,3-8,6.76-8h15.33c3.73,0,6.76,3.58,6.76,8v35.2C354.31,258.27,351.28,261.85,347.55,261.85Z' fill='#ffdc67' />
                                    <path d='M249.73,183.76h28.85v274.8H249.73Z' fill='#323c44' />
                                    </g>
                                </g>
                                <g id='wallet'>
                                    <path d='M478,288.23h-337A28.93,28.93,0,0,0,112,317.14V546.2a29,29,0,0,0,28.94,28.95H478a29,29,0,0,0,28.95-28.94h0v-229A29,29,0,0,0,478,288.23Z' fill='#a4bdc1' stroke='#323c44' stroke-miterlimit='10' stroke-width='14' />
                                    <path d='M512.83,382.71H416.71a28.93,28.93,0,0,0-28.95,28.94h0V467.8a29,29,0,0,0,28.95,28.95h96.12a19.31,19.31,0,0,0,19.3-19.3V402a19.3,19.3,0,0,0-19.3-19.3Z' fill='#a4bdc1' stroke='#323c44' stroke-miterlimit='10' stroke-width='14' />
                                    <path d='M451.46,435.79v7.88a14.48,14.48,0,1,1-29,0v-7.9a14.48,14.48,0,0,1,29,0Z' fill='#a4bdc1' stroke='#323c44' stroke-miterlimit='10' stroke-width='14' />
                                    <path d='M147.87,541.93V320.84c-.05-13.2,8.25-21.51,21.62-24.27a42.71,42.71,0,0,1,7.14-1.32l-29.36-.63a67.77,67.77,0,0,0-9.13.45c-13.37,2.75-20.32,12.57-20.27,25.77l.38,221.24c-1.57,15.44,8.15,27.08,25.34,26.1l33-.19c-15.9,0-28.78-10.58-28.76-25.93Z' fill='#7b8f91' />
                                    <path d='M148.16,343.22a6,6,0,0,0-6,6v92a6,6,0,0,0,12,0v-92A6,6,0,0,0,148.16,343.22Z' fill='#323c44' />
                                </g>
                            
                                </svg>
                          </button>
                        </a>
                          <strong>to pay via your dashboard.</strong><br>
                          <p>Or</p>
                          <strong>Make payment to our new account details below:</strong>
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
                                        <li style='width:70px;min-height:10px;overflow:auto;float:left;text-align:center;' class='social-item'><a href='https://www.twitter.com/rentsmallsmall' target='_blank'><img width='50px' height='auto' src='https://www.rent.smallsmall.com/assets/img/twitter.png' /></a></li>
                                        <li style='width:70px;min-height:10px;overflow:auto;float:left;text-align:center;' class='social-item'><a href='https://www.facebook.com/rentsmallsmall' target='_blank'><img width='50px' height='auto' src='https://www.rent.smallsmall.com/assets/img/facebook.png' /></a></li>
                                        <li style='width:70px;min-height:10px;overflow:auto;float:left;text-align:center;' class='social-item'><a href='https://www.instagram.com/rentsmallsmall' target='_blank'><img width='50px' height='auto' src='https://www.rent.smallsmall.com/assets/img/instagram.png' /></a></li>
                                        <li style='width:70px;min-height:10px;overflow:auto;float:left;text-align:center;' class='social-item'><a href='https://www.linkedin.com/company/rentsmallsmall' target='_blank'><img width='50px' height='auto' src='https://www.rent.smallsmall.com/assets/img/linkedin.png' /></a></li>
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
                    $headers .= 'From: <customerexperience@smallsmall.com>' . "\r\n";
                    $headers .= 'BCC: customerexperience@smallsmall.com' . "\r\n";
                    $headers .= 'BCC: accounts@smallsmall.com' . "\r\n";
                    
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
                                    <td style='text-align:center' class='logo-container' width='33.3%'><img width='130px' src='https://smallsmall.com/front/assets/img/rss-png.png' /></td>
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
                                            <br><strong>Kindly click the Pay Now button 
                        <a href='https://rent.smallsmall.com/user/dashboard'>
                            <button class='button'>
                                <span class='button__text'>
                                <span>P</span><span>a</span>y</span><span> </span><span>N</span><span>o</span><span>w</span><span></span><span></span>
                                </span>
                                <svg class='button__svg' role='presentational' viewBox='0 0 600 600'>
                                <defs>
                                    <clipPath id='myClip'>
                                    <rect x='0' y='0' width='100%' height='50%' />
                                    </clipPath>
                                </defs>
                                <g clip-path='url(#myClip)'>
                                    <g id='money'>
                                    <path d='M441.9,116.54h-162c-4.66,0-8.49,4.34-8.62,9.83l.85,278.17,178.37,2V126.37C450.38,120.89,446.56,116.52,441.9,116.54Z' fill='#699e64' stroke='#323c44' stroke-miterlimit='10' stroke-width='14' />
                                    <path d='M424.73,165.49c-10-2.53-17.38-12-17.68-24H316.44c-.09,11.58-7,21.53-16.62,23.94-3.24.92-5.54,4.29-5.62,8.21V376.54H430.1V173.71C430.15,169.83,427.93,166.43,424.73,165.49Z' fill='#699e64' stroke='#323c44' stroke-miterlimit='10' stroke-width='14' />
                                    </g>
                                    <g id='creditcard'>
                                    <path d='M372.12,181.59H210.9c-4.64,0-8.45,4.34-8.58,9.83l.85,278.17,177.49,2V191.42C380.55,185.94,376.75,181.57,372.12,181.59Z' fill='#a76fe2' stroke='#323c44' stroke-miterlimit='10' stroke-width='14' />
                                    <path d='M347.55,261.85H332.22c-3.73,0-6.76-3.58-6.76-8v-35.2c0-4.42,3-8,6.76-8h15.33c3.73,0,6.76,3.58,6.76,8v35.2C354.31,258.27,351.28,261.85,347.55,261.85Z' fill='#ffdc67' />
                                    <path d='M249.73,183.76h28.85v274.8H249.73Z' fill='#323c44' />
                                    </g>
                                </g>
                                <g id='wallet'>
                                    <path d='M478,288.23h-337A28.93,28.93,0,0,0,112,317.14V546.2a29,29,0,0,0,28.94,28.95H478a29,29,0,0,0,28.95-28.94h0v-229A29,29,0,0,0,478,288.23Z' fill='#a4bdc1' stroke='#323c44' stroke-miterlimit='10' stroke-width='14' />
                                    <path d='M512.83,382.71H416.71a28.93,28.93,0,0,0-28.95,28.94h0V467.8a29,29,0,0,0,28.95,28.95h96.12a19.31,19.31,0,0,0,19.3-19.3V402a19.3,19.3,0,0,0-19.3-19.3Z' fill='#a4bdc1' stroke='#323c44' stroke-miterlimit='10' stroke-width='14' />
                                    <path d='M451.46,435.79v7.88a14.48,14.48,0,1,1-29,0v-7.9a14.48,14.48,0,0,1,29,0Z' fill='#a4bdc1' stroke='#323c44' stroke-miterlimit='10' stroke-width='14' />
                                    <path d='M147.87,541.93V320.84c-.05-13.2,8.25-21.51,21.62-24.27a42.71,42.71,0,0,1,7.14-1.32l-29.36-.63a67.77,67.77,0,0,0-9.13.45c-13.37,2.75-20.32,12.57-20.27,25.77l.38,221.24c-1.57,15.44,8.15,27.08,25.34,26.1l33-.19c-15.9,0-28.78-10.58-28.76-25.93Z' fill='#7b8f91' />
                                    <path d='M148.16,343.22a6,6,0,0,0-6,6v92a6,6,0,0,0,12,0v-92A6,6,0,0,0,148.16,343.22Z' fill='#323c44' />
                                </g>
                            
                                </svg>
                          </button>
                        </a>
                          <strong>to pay via your dashboard.</strong><br>
                          <p>Or</p>
                          <strong>Make payment to our new account details below:</strong>
                          
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
                                        <li style='width:70px;min-height:10px;overflow:auto;float:left;text-align:center;' class='social-item'><a href='https://www.twitter.com/rentsmallsmall' target='_blank'><img width='50px' height='auto' src='https://www.rent.smallsmall.com/assets/img/twitter.png' /></a></li>
                                        <li style='width:70px;min-height:10px;overflow:auto;float:left;text-align:center;' class='social-item'><a href='https://www.facebook.com/rentsmallsmall' target='_blank'><img width='50px' height='auto' src='https://www.rent.smallsmall.com/assets/img/facebook.png' /></a></li>
                                        <li style='width:70px;min-height:10px;overflow:auto;float:left;text-align:center;' class='social-item'><a href='https://www.instagram.com/rentsmallsmall' target='_blank'><img width='50px' height='auto' src='https://www.rent.smallsmall.com/assets/img/instagram.png' /></a></li>
                                        <li style='width:70px;min-height:10px;overflow:auto;float:left;text-align:center;' class='social-item'><a href='https://www.linkedin.com/company/rentsmallsmall' target='_blank'><img width='50px' height='auto' src='https://www.rent.smallsmall.com/assets/img/linkedin.png' /></a></li>
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
        
            ';
            
                
                // Always set content-type when sending HTML email
                    $headers = 'MIME-Version: 1.0' . '\r\n';
                    $headers .= 'Content-type:text/html;charset=UTF-8' . '\r\n';
        
                    // More headers
                    $headers .= 'From: <customerexperience@smallsmall.com>' . '\r\n';
                    $headers .= 'BCC: customerexperience@smallsmall.com' . '\r\n';
                    $headers .= 'BCC: accounts@smallsmall.com' . '\r\n';
                    
                    mail($to2,$subject2,$message2,$headers);
                // info('rent reminder');
            
            
                }elseif($next_rental == $DueDayTime){
                    $subject2 = 'Subscription Reminder';   
                    $message2 = '
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
                                            
                                            <br><strong>Kindly click the Pay Now button 
                        <a href='https://rent.smallsmall.com/user/dashboard'>
                            <button class='button'>
                                <span class='button__text'>
                                <span>P</span><span>a</span>y</span><span> </span><span>N</span><span>o</span><span>w</span><span></span><span></span>
                                </span>
                                <svg class='button__svg' role='presentational' viewBox='0 0 600 600'>
                                <defs>
                                    <clipPath id='myClip'>
                                    <rect x='0' y='0' width='100%' height='50%' />
                                    </clipPath>
                                </defs>
                                <g clip-path='url(#myClip)'>
                                    <g id='money'>
                                    <path d='M441.9,116.54h-162c-4.66,0-8.49,4.34-8.62,9.83l.85,278.17,178.37,2V126.37C450.38,120.89,446.56,116.52,441.9,116.54Z' fill='#699e64' stroke='#323c44' stroke-miterlimit='10' stroke-width='14' />
                                    <path d='M424.73,165.49c-10-2.53-17.38-12-17.68-24H316.44c-.09,11.58-7,21.53-16.62,23.94-3.24.92-5.54,4.29-5.62,8.21V376.54H430.1V173.71C430.15,169.83,427.93,166.43,424.73,165.49Z' fill='#699e64' stroke='#323c44' stroke-miterlimit='10' stroke-width='14' />
                                    </g>
                                    <g id='creditcard'>
                                    <path d='M372.12,181.59H210.9c-4.64,0-8.45,4.34-8.58,9.83l.85,278.17,177.49,2V191.42C380.55,185.94,376.75,181.57,372.12,181.59Z' fill='#a76fe2' stroke='#323c44' stroke-miterlimit='10' stroke-width='14' />
                                    <path d='M347.55,261.85H332.22c-3.73,0-6.76-3.58-6.76-8v-35.2c0-4.42,3-8,6.76-8h15.33c3.73,0,6.76,3.58,6.76,8v35.2C354.31,258.27,351.28,261.85,347.55,261.85Z' fill='#ffdc67' />
                                    <path d='M249.73,183.76h28.85v274.8H249.73Z' fill='#323c44' />
                                    </g>
                                </g>
                                <g id='wallet'>
                                    <path d='M478,288.23h-337A28.93,28.93,0,0,0,112,317.14V546.2a29,29,0,0,0,28.94,28.95H478a29,29,0,0,0,28.95-28.94h0v-229A29,29,0,0,0,478,288.23Z' fill='#a4bdc1' stroke='#323c44' stroke-miterlimit='10' stroke-width='14' />
                                    <path d='M512.83,382.71H416.71a28.93,28.93,0,0,0-28.95,28.94h0V467.8a29,29,0,0,0,28.95,28.95h96.12a19.31,19.31,0,0,0,19.3-19.3V402a19.3,19.3,0,0,0-19.3-19.3Z' fill='#a4bdc1' stroke='#323c44' stroke-miterlimit='10' stroke-width='14' />
                                    <path d='M451.46,435.79v7.88a14.48,14.48,0,1,1-29,0v-7.9a14.48,14.48,0,0,1,29,0Z' fill='#a4bdc1' stroke='#323c44' stroke-miterlimit='10' stroke-width='14' />
                                    <path d='M147.87,541.93V320.84c-.05-13.2,8.25-21.51,21.62-24.27a42.71,42.71,0,0,1,7.14-1.32l-29.36-.63a67.77,67.77,0,0,0-9.13.45c-13.37,2.75-20.32,12.57-20.27,25.77l.38,221.24c-1.57,15.44,8.15,27.08,25.34,26.1l33-.19c-15.9,0-28.78-10.58-28.76-25.93Z' fill='#7b8f91' />
                                    <path d='M148.16,343.22a6,6,0,0,0-6,6v92a6,6,0,0,0,12,0v-92A6,6,0,0,0,148.16,343.22Z' fill='#323c44' />
                                </g>
                            
                                </svg>
                          </button>
                        </a>
                          <strong>to pay via your dashboard.</strong><br>
                          <p>Or</p>
                          <strong>Make payment to our new account details below:</strong>
                          
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
                                        <li style='width:70px;min-height:10px;overflow:auto;float:left;text-align:center;' class='social-item'><a href='https://www.twitter.com/rentsmallsmall' target='_blank'><img width='50px' height='auto' src='https://www.rent.smallsmall.com/assets/img/twitter.png' /></a></li>
                                        <li style='width:70px;min-height:10px;overflow:auto;float:left;text-align:center;' class='social-item'><a href='https://www.facebook.com/rentsmallsmall' target='_blank'><img width='50px' height='auto' src='https://www.rent.smallsmall.com/assets/img/facebook.png' /></a></li>
                                        <li style='width:70px;min-height:10px;overflow:auto;float:left;text-align:center;' class='social-item'><a href='https://www.instagram.com/rentsmallsmall' target='_blank'><img width='50px' height='auto' src='https://www.rent.smallsmall.com/assets/img/instagram.png' /></a></li>
                                        <li style='width:70px;min-height:10px;overflow:auto;float:left;text-align:center;' class='social-item'><a href='https://www.linkedin.com/company/rentsmallsmall' target='_blank'><img width='50px' height='auto' src='https://www.rent.smallsmall.com/assets/img/linkedin.png' /></a></li>
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
        
            ";
            
                
                // Always set content-type when sending HTML email
                    $headers = "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        
                    // More headers
                    $headers .= "From: <customerexperience@smallsmall.com>" . "\r\n";
                    $headers .= "BCC: customerexperience@smallsmall.com" . "\r\n";
                    $headers .= "BCC: accounts@smallsmall.com" . "\r\n";
                    
                    mail($to2,$subject2,$message2,$headers);
                // info('rent reminder');
            
            
                }
                
                
            
                    }
                    return 0;
                 //second email
                //$to2 = 'dikcondtn@yahoo.com';
                
            }
}
