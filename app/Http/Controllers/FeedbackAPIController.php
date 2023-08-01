<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class FeedbackAPIController extends Controller
{
 
    public function feedback(Request $request){
        $data = array();

        $data['satisfaction'] = $request->satisfaction;
        $data['rate'] = $request->rate;
        $data['comment'] = $request->comment;
        $data['followUp'] = $request->followUp;
        $data['feedback_date'] = now();
        
        $feedback = DB::table('feedback')->insert($data);
        if($feedback){
            return response(['Message'=>'Saved Successfully'], 201);
                // return redirect()->back();
        }else {
            return response(['Message'=>'Failed'], 400);
        }
           
    }
    

}
