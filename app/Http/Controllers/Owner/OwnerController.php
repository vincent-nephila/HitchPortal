<?php

namespace App\Http\Controllers\Owner;

use Illuminate\Http\Request;

use App\User;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class OwnerController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        //$this->middleware('status');
        
        //if (Auth::user()->accesslevel == env('USER_OWNER')){
        //    return redirect('/');
       // }
    }
    
    
    
    public function uploadRequirements(Request $request){
        
        
        $this->validate($request, [
            'bdate' => 'required|date',
            'address' => 'required|max:255',
            'picture' => 'required|mimes:jpeg,png,pdf',
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
        $profile->birthDate = $request->bdate;
        $profile->address = $request->address;
        $profile->picture = $picture.'.'.$pictureExt;
        $profile->validId1 = $id1.'.'.$id1Ext;
        $profile->validId2 = $id2.'.'.$id2Ext;
        $profile->save();
        
        $user = User::find(\Auth::user()->id);
        $user->status = 1;
        $user->save();
        
        return redirect('portal/owner/approval');
             
    }
    
    public function addVehicle(){
        $result = DB::Select('select distinct maker from ctr_vehicles;');
        $model = DB::Select('select model from ctr_vehicles;');
        $user = \Auth::user();
        
        return view('owner.addVehicle',compact('result','model','user'));
    }
    public function saveVehicle(Request $request){
        
        $this->validate($request, [
            'plateNo' => 'required|max:7',
            'model' => 'required|max:255',
            'color' => 'required|max:255',
            'registration' => 'required|mimes:jpeg,png',
            'insurance' => 'required|mimes:jpeg,png',
            'front' => 'required|mimes:jpeg,png',
            'side' => 'required|mimes:jpeg,png',
            'back' => 'required|mimes:jpeg,png',
            
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
            'email' => 'required|email|max:255|unique:users',            
        ]);     
        
        $driver = new \App\Driver;
        $driver->owner_id = \Auth::user()->id;
        $driver->firstname = $request->firstname;
        $driver->middlename = $request->middlename;
        $driver->lastname = $request->lastname;
        $driver->extname = $request->ext;
        $driver->mobile = $request->mobile;
        $driver->email = $request->email;
        $driver->acctStatus = 0;
        $driver->status = 0;
        $driver->save();
        /*
        $driverProfile = new \App\DriverProfile;
        $profile->idno = $driver->id;
        if ($request->has('bdate')) {
            $driverProfile->birthDate = $request->bdate;          
        }
        if ($request->has('address')) {
            $profile->address = $request->address;
        }
        
        if ($request->has('licenseNo')) {
            $profile->licNo = $request->licenseNo;
        }
        if ($request->has('licExpDate')) {
            $driverProfile->licExp = $request->licExpDate;          
        }
        
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
        $driverProfile->save();*/
        return redirect('portal/owner/addDriver');
        
    }
}

