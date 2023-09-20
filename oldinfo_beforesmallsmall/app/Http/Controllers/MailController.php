<?php

namespace App\Http\Controllers;

use App\Mail\InspectionEmail;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendEmail(){
        $data = [
            'name' => "Doveway"
        ];
        Mail::to('dikcondtn@yahoo.com')->send(new InspectionEmail($data));
    }
}
