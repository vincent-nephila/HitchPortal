<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;


use App\Http\Controllers\Controller;
use App\User;
use Storage;
use File;

class AdminController extends Controller
{
    //
    public function __construct() {
        $this->middleware('auth');
        
    }

    public function completeList(){
        $user = \Auth::user();
        $applicant = User::where('accesslevel',env('USER_OWNER'))->get();
        $driver = $this->driverList(0);
        return view('admin.index',compact('driver','applicant','user'));
    } 

    public function completeDriverList(){
        $user = \Auth::user();
        $applicant = User::where('accesslevel',env('USER_OWNER'))->get();
        $driver = $this->driverList(0);
        return view('admin.driverList',compact('driver','applicant','user'));
    }     
    
    public function driverList($id){
        if($id ==0){
            $drivers = \App\Driver::all(); 
            return $drivers;
        }
        $drivers = \App\Driver::where('owner_id',$id)->get();        
        return $drivers;
    }
    
    public function VehicleList($id){
        $vehicle = \App\Vehicle::where('idno',$id)->get();        
        return $vehicle;
    }    
    
    public function ownerApplication($id){
        $applicant = User::find($id);
        $profile = \App\OwnerProfile::where('idno',$applicant->id)->first();
        $driver = $this->driverList($id);
        $vehicle = $this->VehicleList($id);
        $pic ='/uploads/owner/'.$profile->picture;
        return view('admin.applicantProfile',compact('applicant','profile','pic','driver','vehicle'));
    }
    
    public function driverApplication($id){
        $applicant = \App\Driver::find($id);
        $operator = \App\User::find($applicant->owner_id);
        $profile = \App\DriverProfile::where('idno',$applicant->id)->first();
        $pic ='/uploads/driver/'.$profile->picture;
        return view('admin.driverProfile',compact('applicant','profile','pic','operator'));
    }    
    
    public function vehicleApplication($id){
        $vehicle = \App\Vehicle::find($id);
        $operator = \App\User::find($vehicle->idno);
        $pic1 ='/uploads/vehicle/'.$vehicle->veFrontPic;
        $pic2 ='/uploads/vehicle/'.$vehicle->veSidePic;
        $pic3 ='/uploads/vehicle/'.$vehicle->veBackPic;
        return view('admin.vehicleProfile',compact('vehicle','pic1','pic2','pic3','operator'));
    }       
}
