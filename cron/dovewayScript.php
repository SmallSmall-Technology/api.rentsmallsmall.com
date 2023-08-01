<?php
$to2 = 'dikcondtn@yahoo.com';
        $subject2 = "API Cron Update";

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
                                    <strong>Prospective Native:</strong> inspection_name <br>
                                    <strong>Property:</strong> propertyTitle <br>
                                    <strong>Updated Inspection Date:</strong> pdated_inspection_date at updated_inspection_time GMT+1</div>
                                    
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

            

        mail($to2,$subject2,$message2,$headers);
        
        ?>