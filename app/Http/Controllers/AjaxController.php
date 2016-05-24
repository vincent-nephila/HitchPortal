<?php

namespace App\Http\Controllers;

use Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Input;

class AjaxController extends Controller
{
    public function getModel($maker){
    //if(Request::ajax()){
        $result = DB::Select("select model from ctr_vehicles where maker='$maker'");
        $value = '<select class="form-control" name="model" placeholder="Model" onclick="getYear(this.value)">';
        foreach($result as $results){
            $value= $value.'<option value="' . $results->model .'">' .$results->model . '</option>';
        }
        $value= $value.'</select>';
        return $value;
    //}
    }
    
    public function getYear($model){
    if(Request::ajax()){
        $result = DB::Select("select * from ctr_vehicles where model='$model'");
        $value = '<select class="form-control" name="year">';
        foreach($result as $results){
            $value= $value.'<option value="' . $results->prodYear .'">' .$results->prodYear . '</option>';
        }
        $value= $value.'</select>';
        return $value;
       }
    }    
    public function showMeeting($destination){
        if(Request::ajax()){
            $result = DB::Select("select *,trips.seats tripSeat,trips.id tripId from trips "
                    . "join ctr_routes on trips.route = ctr_routes.id "
                    . "join vehicles on trips.vehicle_id = vehicles.id "
                    . "join drivers on trips.driver_id = drivers.id "
                    . "where ctr_routes.destinationPoint = '$destination' AND trips.seats != 0;");        
         $value=''; 
        //$value = '<select class="form-control" name="meetPoint" onclick="findDate()">';
        foreach($result as $results){
            $value= $value.'<option value="' . $results->startPoint .'">' .$results->startPoint . '</option>';
        }
        //$value= $value.'</select>';
            
        return $value;
        }
    }
    
        public function showDate($destination,$start){
        if(Request::ajax()){
            $result = DB::Select("select *,trips.seats tripSeat,trips.id tripId from trips "
                    . "join ctr_routes on trips.route = ctr_routes.id "
                    . "join vehicles on trips.vehicle_id = vehicles.id "
                    . "join drivers on trips.driver_id = drivers.id "
                    . "where ctr_routes.destinationPoint = '$destination' AND ctr_routes.startPoint = '$start' AND trips.seats != 0;");        
          $value='';
        //$value = '<select class="form-control" name="meetPoint" onclick="findDate()">';
        foreach($result as $results){
            $value= $value.'<option value="' . $results->date .'">' .$results->date . '</option>';
        }
        //$value= $value.'</select>';
            
        return $value;
        }
    }
    
    public function showTrips($destination,$start,$date){
        if(Request::ajax()){
            $results = DB::Select("select *,trips.seats tripSeat,trips.id tripId from trips "
                    . "join ctr_routes on trips.route = ctr_routes.id "
                    . "join vehicles on trips.vehicle_id = vehicles.id "
                    . "join drivers on trips.driver_id = drivers.id "
                    . "where ctr_routes.destinationPoint = '$destination' AND ctr_routes.startPoint = '$start'  AND trips.date = '$date'  AND trips.seats != 0;");
            $value = '';
            foreach($results as $result){
                $pic ='/uploads/vehicle/'.$result->veFrontPic;
                $value = $value.'<div class ="container item" id="'.$result->tripId.'" style="width: 100%;">';
                $value = $value.'<div class ="col-md-3"><img src="http://hitch.app'.$pic.'" style="height:auto; width:100%;"></div>';
                $value = $value.'<div class ="col-md-9">';
                $value = $value. 'Start: '.$result->startPoint.'<br>';
                $value = $value. 'Date:'.$result->date.'<br>';
                $value = $value. 'Time:'.$result->time.'<br>';
                $value = $value. 'Vehicle:'.$result->veModel.'<br>';               
                $value = $value. 'Available: '.$result->tripSeat.'<br>';
                $value = $value. '</div></div>';
            }
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
        $user->status = 1;
        $user->save();
        return "Approved";
    }
    }
    public function changeVehicleStat($applicant){
    if(Request::ajax()){
        $user = \App\Vehicle::find($applicant);
        $user->veApproved = 4;
        $user->save();
        return "Approved";
    }
    }    
    function saveReservation(){
        if(Request::ajax()){
        
        $seatTaken = Input::get(1);
        $looper = 0;
        //$seat='';
        $trip = \App\Trip::find(Input::get(0));

        
        
        if($trip->seats == 0){
            return "not saved";
        }
        $trip->seats = $trip->seats - $seatTaken;
        $trip->save();
        while($seatTaken > $looper){
        $matchfields=['tripId'=>Input::get(0),'seatno'=>Input::get($looper+2)];
        $seat = \App\Seat::where($matchfields)->first();
        $seat->available = 0;
        $seat->save();
        
        $user = \Auth::user();
        $reserve = new \App\Reservation;
        $reserve->idno = $user->id;
        $reserve->reservedTrip = 20;
        $reserve->reservedSeat = 1;
        $reserve->save();
        $looper=$looper+1;
        }
        
        return redirect('/passenger/reservation/list')->with('success', "Successfully reserved");
        //return "now";
        }
    }
}
