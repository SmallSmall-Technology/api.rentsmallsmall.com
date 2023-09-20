<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PayoutAPIController extends Controller
{
    public function payoutAPI($id=null){
        if($id){
            $payout = DB::table('payout')->where('id',$id)->get();
        }else {
            $payout = DB::table('payout')->get();
        }
        
        return $payout;
    }

    public function addPayoutAPI(Request $request){
        $data = array();

        $data['payee_id'] = $request->payee_id;
        $data['next_payout'] = $request->next_payout;
        $data['next_payout_date'] = $request->next_payout_date;
        $data['payout_status'] = 'pending';
        $data['authorized_by'] = $request->authorized_by;
        $data['date_paid'] = $request->date_paid;
        
        $addPayout = DB::table('payout')->insert($data);
        if($addPayout){
            return redirect('https://rentsmallsmall.io/add-payout-success');
                // return redirect()->back();
        }else {
            return redirect('https://rentsmallsmall.io/add-payout-failed');
        }
           
    }
}
