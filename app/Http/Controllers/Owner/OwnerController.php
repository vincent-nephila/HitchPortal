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
        $this->middleware('owner');
        $this->middleware('status',['except' => ['addRequirements','uploadRequirements','addVehicle','saveVehicle','saveDriver','addDriver','listVehicle','listDriver']]);
        
        view()->share('user', \Auth::user());
        //if (Auth::user()->accesslevel == env('USER_OWNER')){
        //    return redirect('/');
       // }
    }
    
    public function menuRenderer(){
        $user = \Auth::user();
        $userProfile = \App\OwnerProfile::where('idno',$user->id)->count();
        $userProf = \App\OwnerProfile::where('idno',$user->id)->first();
        if($userProfile == 0){
            $pic ='/images/profile.jpg';
        }
        else{
            $pic = '/uploads/owner/'.$userProf->picture;
        }
        $vehicle = \App\Vehicle::where('idno',$user->id)->first();
        $driver = \App\Driver::where('owner_id',$user->id)->first();
        $content ='<div style="padding:20px">';
        $content = $content.'<div class="col-md-6">';
        $content = $content.'<img src="'.$pic.'" style="width:120px;height:auto;float:right;">';
        $content = $content.'</div>';
        $content = $content.'<div class="col-md-6">';
        $content = $content.$user->firstname.'<br>';
        $content = $content.$user->lastname;
        $content = $content.'</div>';
        $content = $content.'</div>';
        
        $content = $content.'<div>';
        if((($user->status==env('STATUS_PROCESS'))&&($userProfile >=1))||($user->status==env('STATUS_OK'))){
                $content = $content.'<a class="btn btn-primary form-control menu-button" href="/portal/owner/vehicle"><div class="menu-item">Vehicles</div></a>';
                $content = $content.'<a class="btn btn-primary form-control menu-button" href="/portal/owner/driver"><div class="menu-item">Drivers</div></a>';
                
            
            if(($driver != null)&&($vehicle != null)&&($user->status==env('STATUS_PROCESS'))){
                $content = $content.'<a class="btn btn-primary form-control menu-button" href="/changeStat"><div class="menu-item">Set me a schedule</div></a>';
                               
            }
        }
        if($user->status==env('STATUS_OK')){
                $content = $content.'<a class="btn btn-primary form-control menu-button" href="/portal/owner/createTrip"><div class="menu-item">Create a Trips</div></a>';
                

        }
        $content = $content.'</div>';
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
        //$vehicle = \App\Vehicle::where('idno',\Auth::user()->id)->get();
        $user = \Auth::user()->id;
        $vehicle = DB::Select("SELECT *,v.id ve_id FROM `vehicles` v left join `driver_vehicles` dv on v.id = dv.veId left join `drivers` d on d.id = dv.drId where v.idno='$user'");
        if($profile == 0){
            return redirect('/');
        }
        else{
            if ($vehicleCount > 0){
            return view('owner.vehicleList',compact('menu','vehicle'));
            }
            else{
                return redirect('portal/owner/addVehicle');
            }
        }
    }
    
    public function addVehicle(){
        
        //$user = \Auth::user();
        $profile = \App\OwnerProfile::where('idno',\Auth::user()->id)->count();
        $result = DB::Select('select distinct maker from ctr_vehicles;');
        $menu = $this->menuRenderer();
       if($profile >= 1){
        return view('owner.addVehicle',compact('result','menu'));
       }
       else{
           return redirect('/');
       }
    }
    
    public function listDriver(){
        $user = \Auth::user();
        $menu = $this->menuRenderer();
        $profile = \App\OwnerProfile::where('idno',\Auth::user()->id)->count();
        $driverCount = \App\Driver::where('owner_id',\Auth::user()->id)->count();
        if($profile == 0){
            return redirect('portal');
        }
        else{
            if ($driverCount > 0){
            $driver = \App\Driver::where('owner_id',\Auth::user()->id)->get();                
            return view('owner.driverList',compact('user','menu','driver'));
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
            'year' => 'required|max:255',
            'color' => 'required|max:255',
            'receipt' => 'required|mimes:jpg,jpeg,png',
            'registration' => 'required|mimes:jpg,jpeg,png',
            'insurance' => 'required|mimes:jpg,jpeg,png',
            'front' => 'required|mimes:jpg,jpeg,png',
            'side' => 'required|mimes:jpg,jpeg,png',
            'back' => 'required|mimes:jpg,jpeg,png',
            
        ]);
        
        $reg = \Auth::user()->id.'-'.str_random(5);
        $receipt = \Auth::user()->id.'-'.str_random(5);
        $insr = \Auth::user()->id.'-'.str_random(5);
        $back = \Auth::user()->id.'-'.str_random(5);
        $front = \Auth::user()->id.'-'.str_random(5);
        $side = \Auth::user()->id.'-'.str_random(5);
      
        $regExt = $request->file('registration')->getClientOriginalExtension();
        $receiptExt = $request->file('receipt')->getClientOriginalExtension();
        $insrExt = $request->file('insurance')->getClientOriginalExtension();
        $frontExt = $request->file('front')->getClientOriginalExtension();
        $sideExt = $request->file('side')->getClientOriginalExtension();
        $backExt = $request->file('back')->getClientOriginalExtension();

        $request->file('registration')->move(public_path().'/uploads/vehicle',$reg.'.'.$regExt);
        $request->file('receipt')->move(public_path().'/uploads/vehicle',$receipt.'.'.$receiptExt);
        $request->file('insurance')->move(public_path().'/uploads/vehicle',$insr.'.'.$insrExt);
        $request->file('front')->move(public_path().'/uploads/vehicle',$front.'.'.$frontExt);
        $request->file('side')->move(public_path().'/uploads/vehicle',$side.'.'.$sideExt);
        $request->file('back')->move(public_path().'/uploads/vehicle',$back.'.'.$backExt);
        $matchfields=['maker'=>$request->maker,'model'=>$request->model];

        $vehicleCtr = \App\ctrVehicle::where($matchfields)->first();
        
        $vehicle = new \App\Vehicle;
        $vehicle->idno = \Auth::user()->id;
        $vehicle->vePlateNo = $request->plateNo;
        $vehicle->veMaker = $request->maker;
        $vehicle->veModel = $request->model;
        $vehicle->veProYear = $request->year;
        $vehicle->veColor = $request->color;
        $vehicle->veSeats = $vehicleCtr->seats;
        $vehicle->veRegistration = $reg.'.'.$regExt;
        $vehicle->veReceipt = $receipt.'.'.$receiptExt;
        $vehicle->veInsurance = $insr.'.'.$insrExt;
        $vehicle->veFrontPic = $front.'.'.$frontExt;
        $vehicle->veBackPic = $side.'.'.$sideExt;
        $vehicle->veSidePic = $back.'.'.$backExt;
        $vehicle->veApproved = 0;
        $vehicle->save();
        
        
        return redirect('portal/owner/vehicle')->with('success', "New vehicle added.");
    }
    
    public function saveDriver(Request $request){
    if($request->manage == null){
        $this->validate($request, [
            'firstname' => 'required|max:255',
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

        return redirect('/portal/owner/driver/'.$driver->id)->with('success', "New driver added.");
    }
    else{
            $this->validate($request, [
            'licNo' => 'required|max:20|unique:driver_profiles',
            'licExpDate'=> 'required|date',
            'lic' => 'required|mimes:jpeg,png,pdf',
            'nbi' => 'required|mimes:jpeg,png,pdf',

        ]);     

        $time2 = strtotime($request->licExpDate);
        $newformat2 = date('Y-m-d',$time2);       
        
        $user = \Auth::user();
        $user->driver = 1;
        $user->save();
        
        $userProfile = \App\OwnerProfile::where('idno',$user->id)->first();
        $driver = new \App\Driver;
        $driver->owner_id = $user->id;
        $driver->firstname = $user->firstname;
        $driver->middlename = $user->middlename;
        $driver->lastname = $user->lastname;
        $driver->email = $user->email;
        $driver->mobile = $user->mobile;
        $driver->acctStatus = 0;
        $driver->save();
        
        $driverProfile = new \App\DriverProfile;
        $driverProfile->idno = $driver->id;     
        $driverProfile->birthDate = $userProfile->birthDate;
        $driverProfile->address = $userProfile->address;  
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
        return redirect('/portal/owner/driver/'.$driver->id)->with('success', "You have successfully added yourself as a driver.");
    }
    }
    
    public function driverApplication($id){
        $applicant = \App\Driver::findOrFail($id);
        
        if($applicant->owner_id != \Auth::User()->id){
            return redirect('portal/owner/driver');
        }
        $profile = \App\DriverProfile::where('idno',$applicant->id)->first();
        $pic1 ='/uploads/driver/'.$profile->picture;
        $pic2 ='/uploads/driver/'.$profile->lic;
        $pic3 ='/uploads/driver/'.$profile->nbi;
        $menu = $this->menuRenderer();
        return view('owner.driverProfile',compact('applicant','profile','pic1','pic2','pic3','menu'));
    }
    
    public function vehicleApplication($id){
        $vehicle = \App\Vehicle::find($id);
        $operator = \App\User::find($vehicle->idno);
        $pic1 ='/uploads/vehicle/'.$vehicle->veFrontPic;
        $pic2 ='/uploads/vehicle/'.$vehicle->veSidePic;
        $pic3 ='/uploads/vehicle/'.$vehicle->veBackPic;
        $driver = DB::Select("SELECT * FROM `driver_vehicles` dv left join `drivers` d on d.id = dv.drId left join `driver_profiles` dp on d.id = dp.idno where dv.veId='$vehicle->id'");
        $or ='/uploads/vehicle/'.$vehicle->veReceipt;
        $cr='/uploads/vehicle/'.$vehicle->veRegistration;
        $insr ='/uploads/vehicle/'.$vehicle->veInsurance;

        if(!is_null($driver[0]->drId)){
        $drProfile = '/uploads/driver/'.$driver[0]->picture;}
        else{
            $drProfile = '';
        }
        
        
        $menu = $this->menuRenderer();
        return view('owner.vehicleProfile',compact('vehicle','pic1','pic2','pic3','operator','or','cr','insr','menu','driver','drProfile'));
    }    
    
    public function editDriver($id){
        $applicant = \App\Driver::find($id);
        if($applicant->owner_id != \Auth::User()->id){
            return redirect('portal/owner/driver');
        }
        $profile = \App\DriverProfile::where('idno',$applicant->id)->first();
        $pic1 ='/uploads/driver/'.$profile->picture;
        $pic2 ='/uploads/driver/'.$profile->lic;
        $pic3 ='/uploads/driver/'.$profile->nbi;
        $bdate = date('m/d/Y',strtotime($profile->birthDate));
        $licExp = date('m/d/Y',strtotime($profile->licExp));
        $menu = $this->menuRenderer();
        return view('owner.editDriver',compact('applicant','profile','pic1','pic2','pic3','menu','bdate','licExp'));
    }    
    
    public function updateDriver(Request $request,$id){
        $driverProfile = \App\DriverProfile::where('idno',$id)->first();
        
        $this->validate($request, [
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'mobile' => 'required|max:12',
            'email' => 'required|email|max:255|unique:drivers,email,'.$id,
            'bdate' => 'required|date',
            'address' => 'required|max:255',
            'licNo' => 'required|max:20|unique:driver_profiles,licNo,'.$driverProfile->id,
            'licenseExp'=> 'required|date',
        ]);     
        
        $time1 = strtotime($request->bdate);
        $newformat1 = date('Y-m-d',$time1);

        $time2 = strtotime($request->licenseExp);
        $newformat2 = date('Y-m-d',$time2);       
        
        
        $driver =  \App\Driver::where('id',$id)->first();
        $driver->firstname = $request->firstname;
        $driver->middlename = $request->middlename;
        $driver->lastname = $request->lastname;
        $driver->extname = $request->ext;
        $driver->email = $request->email;
        $driver->mobile = $request->mobile;
        $driver->save();
        
        //$driverProfile = \App\DriverProfile::where('idno',$id)->f;
        $driverProfile->idno = $driver->id;     
        $driverProfile->birthDate = $newformat1;          
        $driverProfile->address = $request->address;  
        $driverProfile->licNo = $request->licNo;
        $driverProfile->licExp = $newformat2;          
        
        if ($request->hasFile('lic')) {
            $lic = $driver->id.'-'.str_random(5);
            $licExt = $request->file('lic')->getClientOriginalExtension();
            $request->file('lic')->move(public_path().'/uploads/driver',$lic.'.'.$licExt);
            $driverProfile->lic = $lic.'.'.$licExt;
        }
        
        if ($request->hasFile('nbi')) {
            $nbi = $driver->id.'-'.str_random(5);
            $nbiExt = $request->file('nbi')->getClientOriginalExtension();
            $request->file('nbi')->move(public_path().'/uploads/driver',$nbi.'.'.$nbiExt);
            $driverProfile->nbi = $nbi.'.'.$nbiExt;
        }        

        if ($request->hasFile('pic')) {
            $pic = $driver->id.'-'.str_random(5);
            $picExt = $request->file('pic')->getClientOriginalExtension();
            $request->file('pic')->move(public_path().'/uploads/driver',$pic.'.'.$picExt);
            $driverProfile->picture = $pic.'.'.$picExt;
        }            
        $driverProfile->save();
        
        return redirect('/portal/owner/driver/'.$driver->id)->with('success', "New driver added.");   
    }
    
    public function createTrip(){
        $user=\Auth::user()->id;
        $destination = DB::Select('select * from ctr_routes order by destination;');        
        $vehicle = DB::Select("SELECT *,v.id,dv.id vrDrId FROM `vehicles` v left join `driver_vehicles` dv on v.id = dv.veId left join `drivers` d on d.id = dv.drId where v.idno='$user' AND dv.status=0 AND drId IS NOT NULL");
        $menu = $this->menuRenderer();
        return view('owner.createTrip',compact('menu','destination','vehicle'));
    }
    
    public function saveTrip(Request $request){
        $this->validate($request, [
            'destination' => 'required|max:255',
            'date' => 'required|date',
            'time' => 'required|max:20',
            'vehicle' => 'required|max:255',
           
            
        ]);        
        $date = strtotime($request->date);
        $newformat = date('Y-m-d',$date);        
        
        $time = strtotime($request->time);
        $timeformat = date('H:i',$time); 
        $driverhicle = \App\driver_vehicle::find($request->vehicle)->first();
        
        $vehicle = \App\Vehicle::find($driverhicle->veId);
        
        
        $trip = new \App\Trip;
        $trip->routeId = $request->destination;
        $trip->drVeId = $request->vehicle;
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
        
        $driverhicle->status=2;
        $driverhicle->save();
        
        return redirect('/portal/owner/trip/'.$trip->id);
    }
    
    public function tripInfo($id){
        $trip = \App\Trip::where('id',$id)->first();
        $vehicle = DB::Select("SELECT *,v.id,dv.id vrDrId FROM `vehicles` v left join `driver_vehicles` dv on v.id = dv.veId left join `drivers` d on d.id = dv.drId where dv.id=$trip->drVeId");
        $route = \App\ctrRoute::where('id',$trip->routeId)->first();
        $menu = $this->menuRenderer();
        return view('owner.tripInfo',compact('trip','vehicle','route','menu'));
        //return $trip.' '.$route.' '.$vehicle[0]->vrDrId;
    }
    public function listTrips(){
                $user = \Auth::user();            
                    $results = DB::Select("select *,trips.seats tripSeat,trips.id tripId from trips "
                    . "join ctr_routes on trips.route = ctr_routes.id "
                    . "join vehicles on trips.vehicle_id = vehicles.id "
                    . "join drivers on trips.driver_id = drivers.id "
                    . "where trips.idno='$user->id'");
                $menu = $this->menuRenderer();
                return view('owner.tripList',compact('results','menu'));

    }
}

