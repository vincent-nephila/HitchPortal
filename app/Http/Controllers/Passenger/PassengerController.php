<?php

namespace App\Http\Controllers\Passenger;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Input;
use DB;
class PassengerController extends Controller
{
    public function menuRenderer(){
        $user = \Auth::user();

        
        $content = '<hr>';

        
        
        return $content;
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
            'seat' => 'required',
            ]);
        $user = \Auth::user();
        $reserve = new \App\Reservation;
        $reserve->idno = $user->id;
        $reserve->reservedTrip = $request->trip;
        $reserve->reservedSeat = $request->seat;
        
        $matchfields=['tripId'=>$request->trip,'seatno'=>$request->seat];
        $seat = \App\Seat::where($matchfields)->first();
        $seat->available = 0;
        
        $trip = \App\Trip::find($request->trip);
        $seatAva = $trip->seats - 1;
        $trip->seats = $trip->seats - 1;
        
        
        if($trip->seats == 0){
            return "not saved";
        }
        
        $reserve->save();
        $seat->save();
        $trip->save();
        
        return "OK";
    }
    
}
