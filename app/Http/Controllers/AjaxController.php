<?php

namespace App\Http\Controllers;

use Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class AjaxController extends Controller
{
    public function getModel($maker){
    if(Request::ajax()){
        $result = DB::Select("select model from ctr_vehicles where maker='$maker'");
        $value = '<select class="form-control" name="model" placeholder="Model">';
        foreach($result as $results){
            $value= $value.'<option value="' . $results->model .'">' .$results->model . '</option>';
        }
        $value= $value.'</select>';
        return $value;
    }
    }
    
    public function changeOwnerStat($applicant){
    if(Request::ajax()){
        $user = \App\User::find($applicant);
        $user->status = 2;
        return "Approved";
    }
    }
}
