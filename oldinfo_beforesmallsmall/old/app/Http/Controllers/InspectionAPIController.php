<?php

namespace App\Http\Controllers;

use App\Mail\InspectionEmail;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class InspectionAPIController extends Controller
{
    public function inspectionAPI($id=null){
        if($id){
            $inspections = DB::table('inspection_tbl')->where('id',$id)->get();
            
        }else {
            $inspections = DB::table('inspection_tbl')->get();
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

        $update = DB::table('inspection_tbl')->where('id', $request->id)->update($data);
        if ($update) {
            // $inspecion_email = D
            // Mail::send('mail.inspectionUpdate', ['name' =>'Doveway'], function($message){
            //     $message->from('noreply@rentsmallsmall.com', 'Inspection Update');
            //     $message->to('dikcondtn@yahoo.com');
            // });
            // Mail::to($form1->email)->send(new ThankYouMail($form1));
            Mail::to('dikcondtn@yahoo.com')->send(new InspectionEmail($data));
            // return ["update"=>"updated"];
            return redirect('https://rentsmallsmall.io/inspection-update-success');
        } else {

            // return ["update"=>"did not update"];
            return redirect('https://rentsmallsmall.io/inspection-update-failed');
        }
    }


    public function checkAPI(){
        $client = new Client;
        $request = $client->get('http://127.0.0.1:8000/api/add-property-api/')->getBody()->getContents();  
        $data = json_decode($request, true);
        return view('welcome', compact('data'));
    }
    
}
