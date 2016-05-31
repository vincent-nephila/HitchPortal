<?php

namespace App\Http\Controllers\Passenger;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class PassengerController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('passenger');
        
        view()->share('user', \Auth::user());
        
    }    
    
    public function menuRenderer(){

        $user = \Auth::user();
    
        $content ='<div style="padding:20px">';
        $content = $content.'<div class="col-md-6">';
        //$content = $content.'<img src="'.$pic.'" style="width:120px;height:auto;float:right;">';
        $content = $content.'</div>';
        $content = $content.'<div class="col-md-6">';
        $content = $content.$user->firstname.'<br>';
        $content = $content.$user->lastname;
        $content = $content.'</div>';
        $content = $content.'</div>';
        $content = $content.'<div>';
        $content = $content.'<a class="btn btn-primary form-control menu-button form-group" href="/passenger/reservation/list"><div class="menu-item">Reserved Trips</div></a>';
        $content = $content.'</div>';
        return $content;
    }
    
    public function listReservation(){
            $user = \Auth::user();
            $results = DB::Select("select * from reservations "
                    . "join trips on trips.id = reservations.reservedTrip "
                    . "join ctr_routes on trips.route = ctr_routes.id "
                    . "join vehicles on trips.vehicle_id = vehicles.id "
                    . "join drivers on trips.driver_id = drivers.id "
                    . "where reservations.idno = '$user->id'");
            
            $menu = $this->menuRenderer();
            return view('passenger.listReservation',compact('menu','results'));

    }
    
    public function makeReservation(){
                $user = \Auth::user();
                $route = DB::Select('select distinct destination from ctr_routes');
                $menu = $this->menuRenderer();
                return view('passenger.makeReservation',compact('user','route','menu'));
                
    }
    
    public function saveReservation(Request $request){
        $this->validate($request, [
            'trip' => 'required',
            ]);
        $menu = $this->menuRenderer();
        
        $trip = \App\Trip::find($request->trip);
        $driverVehicle = \App\driver_vehicle::find($trip->drVeId);
        $vehicle = \App\Vehicle::find($driverVehicle->veId);
        $matchfields=['tripId'=>$request->trip,'available'=>0];
        $takenSeat = \App\Seat::where($matchfields)->get();
        if($vehicle->veSeats == 4){
        $layout = $this->fourSeater();
        }
        if($vehicle->veSeats == 5){
        $layout = $this->fiveSeater();
        }
        if($vehicle->veSeats == 8){
        $layout = $this->eightSeater();
        }        
        if($vehicle->veSeats == 11){
        $layout = $this->elevenSeater();
        }        
        
        return view('passenger.selectSeat',compact('menu','request','layout','vehicle','takenSeat'));
        /*
        if($trip->seats == 0){
            return "not saved";
        }
        
        $reserve->save();
        $seat->save();
        $trip->save();
        
        return \Auth::user()->id;*/
    }
    
    public function fourSeater(){
        $content='<div>';
        $content=$content.'<div class="driver">Driver</div>';
        $content=$content.'<div class="seat" id="1"></div>';
        $content=$content.'</div>';
        $content=$content.'<div>';
        $content=$content.'<div class="seat" id="2"></div>';
        $content=$content.'<div class="seat" id="3"></div>';
        $content=$content.'</div>';
        $content=$content.'<div id="count"></div>';
        
        return $content;
    }
    public function fiveSeater(){
        $content='<div>';
        $content=$content.'<div class="driver">Driver</div>';
        $content=$content.'<div class="seat" id="1"></div>';
        $content=$content.'</div>';
        $content=$content.'<div>';
        $content=$content.'<div class="seat" id="2"></div>';
        $content=$content.'<div class="seat" id="3"></div>';
        $content=$content.'<div class="seat" id="4"></div>';
        $content=$content.'</div>';
        $content=$content.'<div id="count"></div>';
        
        return $content;
    }    
    
        public function eightSeater(){
        $content='<div>';
        $content=$content.'<div class="driver">Driver</div>';
        $content=$content.'<div class="seat" id="1"></div>';
        $content=$content.'</div>';
        $content=$content.'<div>';
        $content=$content.'<div class="seat" id="2"></div>';
        $content=$content.'<div class="seat" id="3"></div>';
        $content=$content.'<div class="seat" id="4"></div>';
        $content=$content.'</div>';
        $content=$content.'<div>';
        $content=$content.'<div class="seat" id="5"></div>';
        $content=$content.'<div class="seat" id="6"></div>';
        $content=$content.'<div class="seat" id="7"></div>';
        $content=$content.'</div>';        
        $content=$content.'<div id="count"></div>';
        
        return $content;
    }    
        public function elevenSeater(){
        $content='<div>';
        $content=$content.'<div class="driver">Driver</div>';
        $content=$content.'<div class="seat two" id="1"></div>';
        $content=$content.'</div>';
        $content=$content.'<div>';
        $content=$content.'<div class="seat" id="2"></div>';
        $content=$content.'<div class="seat" id="3"></div>';
        $content=$content.'<div class="seat" id="4"></div>';
        $content=$content.'</div>';
        $content=$content.'<div>';
        $content=$content.'<div class="seat" id="5"></div>';
        $content=$content.'<div class="seat two" id="6"></div>';
        $content=$content.'</div>';
        $content=$content.'<div>';
        $content=$content.'<div class="seat" id="7"></div>';
        $content=$content.'<div class="seat two" id="8"></div>';
        $content=$content.'</div>';
        $content=$content.'<div>';
        $content=$content.'<div class="seat" id="9"></div>';
        $content=$content.'<div class="seat two" id="10"></div>';
        $content=$content.'</div>';        
        $content=$content.'<div id="count"></div>';
        
        return $content;
    } 
    
}
