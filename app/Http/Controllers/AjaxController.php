<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class AjaxController extends Controller
{
    public function getModel($maker){
    if(Request::ajax()){
        $result = DB::Select("select model from ctr_vehicles where maker='$maker'");
        $value = "test";
        foreach($result as $results){
            $value= $value.$results->model.'<br>';
        }
        
        return $value;
     //   return "new";
    }
    }
}
