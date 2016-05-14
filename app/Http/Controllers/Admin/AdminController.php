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

    public function ownerApplicationList(){
        $user = \Auth::user();
        $applicant = User::where('accesslevel',env('USER_OWNER'))->get();
        //$drivers = driverList(0);
        return view('admin.index',compact('applicant','user'));
    }    

    public function driverList($id){
        $drivers = \App\Driver::where('owner_id',$id)->get();        
        return $drivers;
    }    
    
    public function VehicleList($id){
        $vehicle = \App\Vehicle::where('idno',$id)->get();        
        return $vehicle;
    }    
    
    public function viewApplication($id){
        $applicant = User::find($id);
        $profile = \App\OwnerProfile::where('idno',$applicant->id)->first();
        $driver = $this->driverList($id);
        $vehicle = $this->VehicleList($id);
        $pic ='/uploads/owner/'.$profile->picture;
        return view('admin.applicantProfile',compact('applicant','profile','pic','driver','vehicle'));
    }
}
