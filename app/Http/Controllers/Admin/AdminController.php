<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;


use App\Http\Controllers\Controller;
use App\User;
use Storage;
use File;
use DB;

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
        $route = $this->routeList();
        return view('admin.index',compact('driver','applicant','user','route'));
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
    
    public function routeList(){
            $route = \App\ctrRoute::all(); 
            return $route;
    }    
    
    public function VehicleList($id){
        $vehicle = \App\Vehicle::where('idno',$id)->get();        
        return $vehicle;
    }    
    
    public function ownerApplication($id){
        $applicant = User::find($id);
        if($applicant->status == env('STATUS_OK')){
        $profile = \App\OwnerProfile::where('idno',$applicant->id)->first();
        }
        else{
            $profile = '';
        }
        $driver = $this->driverList($id);
        $vehicle = $this->VehicleList($id);
        if($applicant->status == env('STATUS_OK')){
        $pic ='/uploads/owner/'.$profile->picture;
        $id1 ='/uploads/owner/'.$profile->validId1;
        $id2 ='/uploads/owner/'.$profile->validId2;
        }
        else{
        $pic ='/images/profile.jpg';
        $id1 ='/images/file.jpg';
        $id2 ='/images/file.jpg';        
        }
       
                
        return view('admin.applicantProfile',compact('applicant','profile','pic','id1','id2','driver','vehicle'));
        //return ;
    }
    
    public function driverApplication($id){
        $applicant = \App\Driver::find($id);
        $operator = \App\User::find($applicant->owner_id);
        $profile = \App\DriverProfile::where('idno',$applicant->id)->first();
        $pic1 ='/uploads/driver/'.$profile->picture;
        $pic2 ='/uploads/driver/'.$profile->lic;
        $pic3 ='/uploads/driver/'.$profile->nbi;
        return view('admin.driverProfile',compact('applicant','profile','pic1','pic2','pic3','operator'));
    }    
    
    public function vehicleApplication($id){
        $vehicle = \App\Vehicle::find($id);
        $operator = \App\User::find($vehicle->idno);
        $pic1 ='/uploads/vehicle/'.$vehicle->veFrontPic;
        $pic2 ='/uploads/vehicle/'.$vehicle->veSidePic;
        $pic3 ='/uploads/vehicle/'.$vehicle->veBackPic;
        
        $or ='/uploads/vehicle/'.$vehicle->veReceipt;
        $cr='/uploads/vehicle/'.$vehicle->veRegistration;
        $insr ='/uploads/vehicle/'.$vehicle->veInsurance;
        return view('admin.vehicleProfile',compact('vehicle','pic1','pic2','pic3','operator','or','cr','insr'));
    }
}
