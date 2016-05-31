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
    
    public function pickUp($id){
        $route = \App\ctrRoute::where('id',$id)->first();
        $content = '<label class="control-label col-md-2">Pickup:</label>';
        $content=$content.'<div class="col-md-10">';
        $content=$content.$route->pointOrigin;
        $content=$content.'</div>';
        return $content;
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
    //if(Request::ajax()){
        $user = \App\Vehicle::find($applicant);
        $user->veApproved = 4;
        $user->veStatus = 1;
        $user->save();
        
        $drivehicle = new \App\driver_vehicle;
        $drivehicle->veId = $applicant;
        
        $drivehicle->save();

        return "Approved";
    //}
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
    
    function ownerFilter($filter){
        $content = '';
        if($filter == 3){
            $applicant = \App\User::where('accesslevel',env('USER_OWNER'))->get();
            foreach($applicant as $applicants){
                $content = $content.'<tr class="clickable-row" data-href="/admin/user/'.$applicants->id.'">';
                $content = $content.'<td>'.$applicants->lastname.', '.$applicants->firstname.' '.$applicants->middlename.'</td><td style="text-align:center">';
                if($applicants->status == env('STATUS_OK')){
                    $content = $content.'OK';
                }
                if($applicants->status == env('STATUS_APPROVAL')){
                    $content = $content.'FOR ASSESSMENT';
                }
                if($applicants->status == env('STATUS_PROCESS')){
                    $content = $content.'INC. REQUIREMENT';
                }
                $content = $content.'</td>';
                $content = $content.'</tr>';
            }
              return $content; 
        }
        $matchfields=['accesslevel'=>env('USER_OWNER'),'status'=>$filter];
        $applicant = \App\User::where($matchfields)->get();
        if($applicant->isEmpty()){
            return "No content to show";
        }
            foreach($applicant as $applicants){
                $content = $content.'<tr class="clickable-row" data-href="/admin/user/'.$applicants->id.'">';
                $content = $content.'<td>'.$applicants->lastname.', '.$applicants->firstname.' '.$applicants->middlename.'</td><td style="text-align:center">';
                if($applicants->status == env('STATUS_OK')){
                    $content = $content.'OK';
                }
                if($applicants->status == env('STATUS_APPROVAL')){
                    $content = $content.'FOR ASSESSMENT';
                }
                if($applicants->status == env('STATUS_PROCESS')){
                    $content = $content.'INC. REQUIREMENT';
                }
                $content = $content.'</td>';
                $content = $content.'</tr>';
            }        
        return $content;
    }
    
    function driverFilter($filter){
        $content = '';
        if($filter == 3){
            $applicant = \App\Driver::get();
            foreach($applicant as $applicants){
                $content = $content.'<tr class="clickable-row" data-href="/admin/user/'.$applicants->id.'">';
                $content = $content.'<td>'.$applicants->lastname.', '.$applicants->firstname.' '.$applicants->middlename.'</td><td style="text-align:center;">';
                if($applicants->acctStatus == env('DRIVER_OK')){
                    $content = $content.'OK';
                }
                if($applicants->acctStatus == env('DRIVER_PROCESS')){
                    $content = $content.'FOR ASSESSMENT';
                }
                if($applicants->acctStatus == env('DRIVER_SUSPENDED')){
                    $content = $content.'SUSPENDED';
                }
                $content = $content.'</td>';
                $content = $content.'</tr>';
            }
              return $content; 
        }
        $matchfields=['acctStatus'=>$filter];
        $applicant = \App\Driver::where($matchfields)->get();
        if($applicant->isEmpty()){
            return "No content to show";
        }
            foreach($applicant as $applicants){
                $content = $content.'<tr class="clickable-row" data-href="/admin/user/'.$applicants->id.'">';
                $content = $content.'<td>'.$applicants->lastname.', '.$applicants->firstname.' '.$applicants->middlename.'</td><td style="text-align:center">';
                if($applicants->acctStatus == env('DRIVER_OK')){
                    $content = $content.'OK';
                }
                if($applicants->acctStatus == env('DRIVER_PROCESS')){
                    $content = $content.'FOR ASSESSMENT';
                }
                if($applicants->acctStatus == env('DRIVER_SUSPENDED')){
                    $content = $content.'SUSPENDED';
                }
                $content = $content.'</td>';
                $content = $content.'</tr>';
            }        
        return $content;
    }
    
    function availableDriver(){
        $matchfields = ['acctStatus'=>1,'status'=>env('DRASSIGNMENT_AVAILABLE'),'owner_id'=>\Auth::user()->id];
        $drivers = \App\Driver::where($matchfields)->get();
        
        $content = '<div class="btn btn-success setDriver"  style="display: inline-block;border-top-right-radius: 0px;border-bottom-right-radius:">OK</div><select class="form-control" id="drivers" name="driver" style="display: inline-block;width: 80%;border-top-left-radius: 0px;border-bottom-left-radius: 0px;">';
    foreach($drivers as $driver){
        $content= $content.'<option value="'.$driver->id.'">'.$driver->firstname.' '.$driver->lastname.'</option>';
    }
    $content =$content.'</select>';
    
    return $content;
        
    }
    
    function setDriver(){
       // if(Request::ajax()){
        
            $driver = Input::get(0);
            $vehicle = Input::get(1);
            $orgDriver = Input::get(2);
            //$driver = 3;
            //$vehicle = 2;
            //$orgDriver = 1;
            $driver_vehicle = \App\driver_vehicle::where('veId',$vehicle)->first();
            $driver_vehicle->drId=$driver;
            $driver_vehicle->save();

            
            if($orgDriver > 0){
            $orgdriverstat = \App\Driver::find($orgDriver)->first();
            $orgdriverstat->status = env('DRASSIGNMENT_AVAILABLE');
            $orgdriverstat->save();            
            }
            
            $driverstat = \App\Driver::where('id',$driver)->first();
            $driverstat->status = 0;
            $driverstat->save();            
            
            $showdrive = DB::Select("SELECT * FROM `driver_vehicles` dv left join `drivers` d on d.id = dv.drId left join `driver_profiles` dp on d.id = dp.idno where veId='$vehicle'");
            $pic = '/uploads/driver/'.$showdrive[0]->picture;
            //$change=$this->swapDriver($driver);
            $display = '<img src="'.$pic.'" class="img-responsive" height="100%" width="auto" style="max-height:100px;display:inline-block">';
            $display= $display.'<div style="display: inline-block;" id="withDriver">'.$showdrive[0]->firstname.' '.$showdrive[0]->lastname.'</br><div class="btn btn-default myBtn3">Change Driver</div></div>';
            
         return $display;
    }

}
