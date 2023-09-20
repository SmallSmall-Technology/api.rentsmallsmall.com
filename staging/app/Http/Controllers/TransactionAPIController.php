<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionAPIController extends Controller
{
    public function transactionAPI($id=null){
        if($id){
            $transactions = DB::table('transaction_tbl')->where('id',$id)->get();
        }else {
            $transactions = DB::table('transaction_tbl')->get();
        }
        
        return $transactions;
    }

    public function transactionCountAPI($id=null){
        if($id){
            $transactionsCount = DB::table('transaction_tbl')->where('id',$id)->count();
        }else {
            $transactionsCount = DB::table('transaction_tbl')->count();
        }
        
        return $transactionsCount;
    }

    public function checkAPI(){
        $client = new Client;
        $request = $client->get('http://127.0.0.1:8000/api/add-property-api/')->getBody()->getContents();  
        $data = json_decode($request, true);
        return view('welcome', compact('data'));
    }
    
}
