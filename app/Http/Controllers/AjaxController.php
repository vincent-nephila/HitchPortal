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
    
    public function showTrips($destination){
        if(Request::ajax()){
            $results = DB::Select("select *,trips.id tripId from trips "
                    . "join ctr_routes on trips.route = ctr_routes.id "
                    . "join vehicles on trips.vehicle_id = vehicles.id "
                    . "join drivers on trips.driver_id = drivers.id "
                    . "where ctr_routes.destinationPoint = '$destination';");
           $value = '<fieldset class="form-group">';
            $value = $value.'<label class="control-label col-md-2">Available Trips</label>';
            $value = $value.'<div class="col-md-10" >';
            $value = $value.'<select class="form-control" name="trip" placeholder="Model" onchange="findSeat(this.value)">';
            $value = $value.'<option value="" disabled hidden selected></option>';
            foreach($results as $result){
                $value= $value.'<option value="'.$result->tripId .'">' .$result->tripId.'-'.$result->vePlateNo.'-'.$result->firstname. '</option>';
            }
            $value = $value. '</select>';
            $value = $value. '</div>';
            $value = $value. '</fieldset>';
           //$value = \App\Trip::with(['driver','vehicle','ctrRoute'])->get();
/*            $value='';
            
              $value = '<table class="table">';
            foreach($results as $result){
           $pic ='/uploads/vehicle/'.$result->veFrontPic;
            $value = $value.'<tr>';
           $value = $value. '<td><img src="http://hitch.app'.$pic.'" style="height:100px; width:auto;"></td>';
           $value = $value. '<td>Start: '.$result->startPoint.'<br>';
           $value = $value. 'Date:'.$result->date.'<br>';
           $value = $value. 'Time:'.$result->time.'<br>';
           $value = $value. 'Vehicle:'.$result->veModel.'<br>';
           $value = $value. '</td>';
           $value = $value. '</tr>';
            }

            $value = $value. '</table>';*/
        return $value;
        }
    }
    
    public function showSeats($trip){
        if(Request::ajax()){
        $matchfields=['tripId'=>$trip,'available'=>1];
        $seats = \App\Seat::where($matchfields)->get();
            $value = '<fieldset class="form-group">';
            $value = $value.'<label class="control-label col-md-2">Available Seats</label>';
            $value = $value.'<div class="col-md-10" >';
            $value = $value.'<select class="form-control" name="seat">';
            $value = $value.'<option value="" disabled hidden selected></option>';
            foreach($seats as $seat){
                $value= $value.'<option value="'.$seat->seatno .'">'.$seat->seatno.'</option>';
            }
            $value = $value. '</select>';
            $value = $value. '</div>';
            $value = $value. '</fieldset>';
            
           return $value;
        }
    }
    
    public function changeOwnerStat($applicant){
    if(Request::ajax()){
        $user = \App\User::find($applicant);
        $user->status = 2;
        $user->save();
        return "Approved";
    }
    }
    
        public function changeDriverStat($applicant){
    if(Request::ajax()){
        $user = \App\Driver::find($applicant);
        $user->acctStatus = 1;
        $user->save();
        return "Approved";
    }
    }
    
        public function changeVehicleStat($applicant){
    if(Request::ajax()){
        $user = \App\Driver::find($applicant);
        $user->acctStatus = 4;
        $user->save();
        return "Approved";
    }
    }    
}
