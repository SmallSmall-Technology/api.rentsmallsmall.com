<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeAPIController extends Controller
{
    public function employeeAPI($id=null){
        if($id){
            $employees = DB::table('employees')->get();
        }else {
            $employees = DB::table('employees')->get();
        }
        
        return $employees;
    }
}