<?php

namespace App\Http\Controllers\Owner;

use Illuminate\Http\Request;

use App\User;
use Log;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class OwnerController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('status',['except' => ['addRequirements','uploadRequirements','addVehicle','saveVehicle','saveDriver','addDriver','listVehicle','listDriver']]);
        
        //if (Auth::user()->accesslevel == env('USER_OWNER')){
        //    return redirect('/');
       // }
    }
    
    public function menuRenderer(){
        $user = \Auth::user();
        $userProfile = \App\OwnerProfile::where('idno',$user->id)->count();
        $vehicle = \App\Vehicle::where('idno',$user->id)->first();
        $driver = \App\Driver::where('owner_id',$user->id)->first();
        
        $content = '<hr>';
        if((($user->status==env('STATUS_PROCESS'))&&($userProfile >=1))||($user->status==env('STATUS_OK'))){

                $content = $content.'<a href="/portal/owner/vehicle"><div class="menu-item">Register Vehicle</div></a>';
                $content = $content.'<hr>';

            
                $content = $content.'<a href="/portal/owner/driver"><div class="menu-item">Register Drivers</div></a>';
                $content = $content.'<hr>';
            
            if(($driver != null)&&($vehicle != null)&&($user->status==env('STATUS_PROCESS'))){
                $content = $content.'<a href="/changeStat"><div class="menu-item">Set me a schedule</div></a>';
                $content = $content.'<hr>';                
            }
        }
        if($user->status==env('STATUS_OK')){
                $content = $content.'<a href="/portal/owner/createTrip"><div class="menu-item">Create a Trips</div></a>';
                $content = $content.'<hr>';
        }
        
        
        return $content;
    }
     
    public function addRequirements(){
        $menu = $this->menuRenderer();
        $profile = \App\OwnerProfile::where('idno',\Auth::user()->id)->count();
        if( \Auth::user()->status == env('STATUS_PROCESS')&&($profile != 0)){
            return redirect('portal');
        }
        else{
            return view('owner.requirement',compact('menu'));
        }
    }
    
    public function uploadRequirements(Request $request){
        $this->validate($request, [
            'bdate' => 'required|date',
            'address' => 'required|max:255',
            'picture' => 'required|mimes:JPG,jpeg,png,pdf',
            'id1' => 'required|mimes:jpeg,png,pdf',
            'id2' => 'required|mimes:jpeg,png,pdf',
            
        ]);          
        
        $time = strtotime($request->bdate);
        $newformat = date('Y-m-d',$time);
        
        $picture = \Auth::user()->id.'-'.str_random(5);
        $id1 = \Auth::user()->id.'-'.str_random(5);
        $id2 = \Auth::user()->id.'-'.str_random(5);
        
        $pictureExt = $request->file('picture')->getClientOriginalExtension();
        $id1Ext = $request->file('id1')->getClientOriginalExtension();
        $id2Ext = $request->file('id2')->getClientOriginalExtension();

        $request->file('picture')->move(public_path().'/uploads/owner',$picture.'.'.$pictureExt);
        $request->file('id1')->move(public_path().'/uploads/owner',$id1.'.'.$id1Ext);
        $request->file('id2')->move(public_path().'/uploads/owner',$id2.'.'.$id2Ext);
        
        $profile = new \App\OwnerProfile;
        $profile->idno = \Auth::user()->id;
        $profile->birthDate = $newformat;
        $profile->address = $request->address;
        $profile->picture = $picture.'.'.$pictureExt;
        $profile->validId1 = $id1.'.'.$id1Ext;
        $profile->validId2 = $id2.'.'.$id2Ext;
        $profile->save();
        /*
        $user = User::find(\Auth::user()->id);
        $user->status = 1;
        $user->save();
        */
        return redirect('/portal/owner/addDriver');
             
    }
    
    public function listVehicle(){
        $menu = $this->menuRenderer();
        $profile = \App\OwnerProfile::where('idno',\Auth::user()->id)->count();
        $vehicleCount = \App\Vehicle::where('idno',\Auth::user()->id)->count();
        $vehicle = \App\Vehicle::where('idno',\Auth::user()->id)->get();
        if($profile == 0){
            return redirect('/');
        }
        else{
            if ($vehicleCount >=1){
            return view('owner.vehicleList',compact('menu','vehicle'));
            }
            else{
                return redirect('portal/owner/addVehicle');
            }
        }
    }
    
    public function addVehicle(){
        
        $user = \Auth::user();
        $profile = \App\OwnerProfile::where('idno',\Auth::user()->id)->count();
        $result = DB::Select('select distinct maker from ctr_vehicles;');
        $menu = $this->menuRenderer();
       if($profile >= 1){
        return view('owner.addVehicle',compact('result','menu','user'));
       }
       else{
           return redirect('/');
       }
    }
    
    public function listDriver(){
        $menu = $this->menuRenderer();
        $profile = \App\OwnerProfile::where('idno',\Auth::user()->id)->count();
        $driverCount = \App\Driver::where('owner_id',\Auth::user()->id)->count();
        if($profile == 0){
            return redirect('portal');
        }
        else{
            if ($driverCount >=0){
            $driver = \App\Driver::where('owner_id',\Auth::user()->id)->get();                
            return view('owner.driverList',compact('menu','driver'));
            }
            else{
                return redirect('portal/owner/addDriver');
            }
        }
    }    
    
    public function addDriver(){
        $user = \Auth::user();
        $menu = $this->menuRenderer();
        $profile = \App\OwnerProfile::where('idno',\Auth::user()->id)->count();
       if($profile >= 0){
        return view('owner.addDriver',compact('user','menu'));
       }
       else{
           return redirect('/');
       }
        
        
    }
    
    public function saveVehicle(Request $request){
        $this->validate($request, [
            'plateNo' => 'required|max:7',
            'maker' => 'required|max:255',
            'model' => 'required|max:255',
            'color' => 'required|max:255',
            'registration' => 'required|mimes:jpg,jpeg,png',
            'insurance' => 'required|mimes:jpg,jpeg,png',
            'front' => 'required|mimes:jpg,jpeg,png',
            'side' => 'required|mimes:jpg,jpeg,png',
            'back' => 'required|mimes:jpg,jpeg,png',
            
        ]);
        
        $reg = \Auth::user()->id.'-'.str_random(5);
        $insr = \Auth::user()->id.'-'.str_random(5);
        $back = \Auth::user()->id.'-'.str_random(5);
        $front = \Auth::user()->id.'-'.str_random(5);
        $side = \Auth::user()->id.'-'.str_random(5);
      
        $regExt = $request->file('registration')->getClientOriginalExtension();
        $insrExt = $request->file('insurance')->getClientOriginalExtension();
        $frontExt = $request->file('front')->getClientOriginalExtension();
        $sideExt = $request->file('side')->getClientOriginalExtension();
        $backExt = $request->file('back')->getClientOriginalExtension();

        $request->file('registration')->move(public_path().'/uploads/vehicle',$reg.'.'.$regExt);
        $request->file('insurance')->move(public_path().'/uploads/vehicle',$insr.'.'.$insrExt);
        $request->file('front')->move(public_path().'/uploads/vehicle',$front.'.'.$frontExt);
        $request->file('side')->move(public_path().'/uploads/vehicle',$side.'.'.$sideExt);
        $request->file('back')->move(public_path().'/uploads/vehicle',$back.'.'.$backExt);
        
        $vehicle = new \App\Vehicle;
        $vehicle->idno = \Auth::user()->id;
        $vehicle->vePlateNo = $request->plateNo;
        $vehicle->veMaker = $request->maker;
        $vehicle->veModel = $request->model;
        $vehicle->veColor = $request->color;
        $vehicle->veRegistration = $reg.'.'.$regExt;
        $vehicle->veInsurance = $insr.'.'.$insrExt;
        $vehicle->veFrontPic = $front.'.'.$frontExt;
        $vehicle->veBackPic = $side.'.'.$sideExt;
        $vehicle->veSidePic = $back.'.'.$backExt;
        $vehicle->veApproved = 0;
        $vehicle->save();
        
        
        return redirect('portal/owner/addVehicle')->with('success', "New vehicle added.");
    }
    
    
    
    public function saveDriver(Request $request){
        $this->validate($request, [
            'firstname' => 'required|max:255',
            'middlename' => 'required|max:255',
            'lastname' => 'required|max:255',
            'mobile' => 'required|max:12',
            'email' => 'required|email|max:255|unique:drivers',
            'bdate' => 'required|date',
            'address' => 'required|max:255',
            'licNo' => 'required|max:20|unique:driver_profiles',
            'licExpDate'=> 'required|date',
            'lic' => 'required|mimes:jpeg,png,pdf',
            'nbi' => 'required|mimes:jpeg,png,pdf',
            'pic' => 'required|mimes:jpeg,png,pdf', 
        ]);     
        
        $time1 = strtotime($request->bdate);
        $newformat1 = date('Y-m-d',$time1);

        $time2 = strtotime($request->licExpDate);
        $newformat2 = date('Y-m-d',$time2);       
        
        
        $driver = new \App\Driver;
        $driver->owner_id = \Auth::user()->id;
        $driver->firstname = $request->firstname;
        $driver->middlename = $request->middlename;
        $driver->lastname = $request->lastname;
        $driver->extname = $request->ext;
        $driver->email = $request->email;
        $driver->mobile = $request->mobile;
        $driver->acctStatus = 0;
        $driver->save();
        
        
        $driverProfile = new \App\DriverProfile;
        $driverProfile->idno = $driver->id;     
        $driverProfile->birthDate = $newformat1;          
        $driverProfile->address = $request->address;  
        $driverProfile->licNo = $request->licNo;
        $driverProfile->licExp = $newformat2;          
        
        if ($request->hasFile('lic')) {
            $lic = \Auth::user()->id.'-'.str_random(5);
            $licExt = $request->file('lic')->getClientOriginalExtension();
            $request->file('lic')->move(public_path().'/uploads/driver',$lic.'.'.$licExt);
            $driverProfile->lic = $lic.'.'.$licExt;
        }
        
        if ($request->hasFile('nbi')) {
            $nbi = \Auth::user()->id.'-'.str_random(5);
            $nbiExt = $request->file('nbi')->getClientOriginalExtension();
            $request->file('nbi')->move(public_path().'/uploads/driver',$nbi.'.'.$nbiExt);
            $driverProfile->nbi = $nbi.'.'.$nbiExt;
        }        

        if ($request->hasFile('pic')) {
            $pic = \Auth::user()->id.'-'.str_random(5);
            $picExt = $request->file('pic')->getClientOriginalExtension();
            $request->file('pic')->move(public_path().'/uploads/driver',$pic.'.'.$picExt);
            $driverProfile->picture = $pic.'.'.$picExt;
        }            
        $driverProfile->save();

        return redirect('portal/owner/driver')->with('success', "New driver added.");
        
    }
    
    public function createTrip(){
        $user = \Auth::user();
        $route = DB::Select('select * from ctr_routes order by destinationPoint,startPoint;');

        $matchfields=['idno'=>$user->id,'veApproved'=>env('VEHICLE_APPROVED'),'veStatus'=>0];
        $vehicle=\App\Vehicle::where($matchfields)->get();  
        
        $matchfield2=['owner_id'=>$user->id,'acctStatus'=>1,'status'=>1];
        $drivers=\App\Driver::where($matchfield2)->get();  
        
        
        $menu = $this->menuRenderer();
        return view('owner.createTrip',compact('route','menu','vehicle','drivers'));
    }
    
    public function saveTrip(Request $request){
        $this->validate($request, [
            'route' => 'required|max:255',
            'date' => 'required|date',
            'time' => 'required|max:20',
            'vehicle' => 'required|max:255',
            'driver' => 'required|max:255',
            
        ]);        
        $date = strtotime($request->date);
        $newformat = date('Y-m-d',$date);        
        
        $time = strtotime($request->time);
        $timeformat = date('H:i',$time); 
        
        $vehicle = \App\Vehicle::find($request->vehicle);
        $driver = \App\Driver::find($request->driver);
        
        $trip = new \App\Trip;
        $trip->idno = \Auth::user()->id;
        $trip->route = $request->route;
        $trip->vehicle_id = $request->vehicle;
        $trip->driver_id = $request->driver;
        $trip->seats = $vehicle->veSeats;
        $trip->date = $newformat;
        $trip->time = $timeformat;
        $trip->save();
        $seatno = 1;
        
        while($seatno <= $vehicle->veSeats){
            $seats = new \App\Seat;
            $seats->tripId = $trip->id;
            $seats->seatno = $seatno;
            $seats->available = 1;
            $seats->save();
            
            $seatno = $seatno+1;
        }
        
        $vehicle->veStatus= 1;
        $vehicle->save();
        
        $driver->status = 2;
        $driver->save();
        return $vehicle->veSeats;
    }
}

