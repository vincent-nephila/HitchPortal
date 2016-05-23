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

        $content = '<a class="btn btn-primary form-control menu-button form-group" href="/passenger/reservation"><div class="menu-item">Reserve a Trip</div></a>';
        
        return $content;
    }
    
    public function listReservation(){
        $reservation = DB::Select('select ');
    }
    
    public function makeReservation(){
                $user = \Auth::user();
                $route = DB::Select('select distinct destinationPoint from ctr_routes');
                $menu = $this->menuRenderer();
                return view('passenger.makeReservation',compact('user','route','menu'));
                
    }
    
    public function saveReservation(Request $request){
        $this->validate($request, [
            'trip' => 'required',
            ]);
        $menu = $this->menuRenderer();

        
        $trip = \App\Trip::find($request->trip);
        $vehicle = \App\Vehicle::find($trip->vehicle_id);
        //matchfields=['tripId'=>$request->trip,'seatno'=>$request->seat];
        //$seat = \App\Seat::where('tripId',$request->trip)->get();
        if($vehicle->veSeats == 4){
        $layout = $this->fourSeater();
        }
        if($vehicle->veSeats == 5){
        $layout = $this->fiveSeater();
        }
        if($vehicle->veSeats == 11){
        $layout = $this->elevenSeater();
        }        
        return view('passenger.selectSeat',compact('menu','request','layout','vehicle'));
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
        public function elevenSeater(){
        $content='<div>';
        $content=$content.'<div class="driver">Driver</div>';
        $content=$content.'<div class="seat two" id="1" onclick="addChair()"></div>';
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
