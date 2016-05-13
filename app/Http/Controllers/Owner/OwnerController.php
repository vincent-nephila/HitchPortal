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
        $this->middleware('status',['except' => ['uploadRequirements','addVehicle','saveVehicle','saveDriver']]);
        
        //if (Auth::user()->accesslevel == env('USER_OWNER')){
        //    return redirect('/');
       // }
    }
    
    public function menuRenderer(){
        $user = \Auth::user();
        $vehicle = \App\Vehicle::where('idno',$user->id)->first();
        $driver = \App\Driver::where('owner_id',$user->id)->first();
        
        $content = '<hr>';
        if($user->status==env('STATUS_PROCESS')){
            if($vehicle == null){
                $content = $content.'<a href="/portal/owner/addVehicle"><div class="menu-item">Register Vehicle</div></a>';
                $content = $content.'<hr>';
            }
            if($driver == null){
                $content = $content.'<a href="/portal/owner/addDriver"><div class="menu-item">Register Driver</div></a>';
                $content = $content.'<hr>';
            }        
            if(($driver != null)&&($vehicle != null)){
                $content = $content.'<a href="/changeStat"><div class="menu-item">Set me a schedule</div></a>';
                $content = $content.'<hr>';                
            }
        }
        
        return $content;
    }
    
    public function uploadRequirements(Request $request){
        $this->validate($request, [
            'bdate' => 'required|date',
            'address' => 'required|max:255',
            'picture' => 'required|mimes:JPG,jpeg,png,pdf',
            'id1' => 'required|mimes:jpeg,png,pdf',
            'id2' => 'required|mimes:jpeg,png,pdf',
            
        ]);
        /*
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
          */              
        
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
        return redirect('portal/owner/addDriver');
             
    }
    
    public function addVehicle(){
        
        $user = \Auth::user();
        $vehicle = \App\Vehicle::where('idno',$user->id)->count();
        
       
        $result = DB::Select('select distinct maker from ctr_vehicles;');
        $menu = $this->menuRenderer();
       if(((\Auth::user()->status == env('STATUS_PROCESS'))&&($vehicle == 0))||(\Auth::user()->status == env('STATUS_OK'))){
        return view('owner.addVehicle',compact('result','menu','user'));
       }
       else{
           return view('own',compact('menu','user'));
       }
    }
    public function saveVehicle(Request $request){
        $this->validate($request, [
            'plateNo' => 'required|max:7',
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
        $vehicle->veModel = $request->model;
        $vehicle->veColor = $request->color;
        $vehicle->veRegistration = $reg.'.'.$regExt;
        $vehicle->veInsurance = $insr.'.'.$insrExt;
        $vehicle->veFrontPic = $front.'.'.$frontExt;
        $vehicle->veBackPic = $side.'.'.$sideExt;
        $vehicle->veSidePic = $back.'.'.$backExt;
        $vehicle->veApproved = 0;
        $vehicle->save();
        
        
        return redirect('portal/owner/addVehicle');
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
            'licenseNo' => 'required|max:20',
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
        $driverProfile->licNo = $request->licenseNo;
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

        return "Hello";
        
    }
}

