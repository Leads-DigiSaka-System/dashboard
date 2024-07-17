<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class CalibrateLocationController extends Controller
{
    public function calibrate($level, $code){
        $tableName = "";
        $fieldName = "";

        if($level == "region"){
            $tableName = "provinces";
            $fieldName = "regcode";
        } else if($level == "province"){
            $tableName = "municipalities";
            $fieldName = "provcode";
        }
        
        $res = DB::table($tableName)->where($fieldName, $code)->get();
        return $res;
    }
}
