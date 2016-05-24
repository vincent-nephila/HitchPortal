<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;



class MainController extends Controller
{

    
    
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('status',['except'=>['redirectRequirement','redirectApproval','redirectSuspended']]);
    }

    public function ownerMenuRenderer(){
        $user = \Auth::user();
        $userProfile = \App\OwnerProfile::where('idno',$user->id)->count();
        $userProf = \App\OwnerProfile::where('idno',$user->id)->first();
        $vehicle = \App\Vehicle::where('idno',$user->id)->first();
        $driver = \App\Driver::where('owner_id',$user->id)->first();
        $pic = '/uploads/owner/'.$userProf->picture;
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
    
    public function passengerMenuRenderer(){
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
        $content = $content.'<a class="btn btn-primary form-control menu-button form-group" href="/passenger/reservation/list"><div class="menu-item">Reserved Trip</div></a>';
        $content = $content.'</div>';
        return $content;
    }    
    
    public function index(){
        $accesslevel = \Auth::user()->accesslevel;
        $user = \Auth::user();
        switch($accesslevel){
            case env('USER_PASSENGER');
                $menu=$this->passengerMenuRenderer();
                return view('passenger.index',compact('user','menu'));
                break;
            case env('USER_OWNER');
                $user = \Auth::user();
                $profile = \App\OwnerProfile::where('idno',$user->id)->first();                
                $pic ='/uploads/owner/'.$profile->picture;
                $menu=$this->ownerMenuRenderer();
                return view('owner.index',compact('user','pic','profile','menu'));
                break;
            case env('USER_ADMIN');
                return redirect('/admin');
                break;        
            case env('USER_DRIVER');
                return view('owner.index',compact('user'));
                break;        
        }
    }
    
    public function ownerProfile(){
        $driver = $this->driverList($id);
        $vehicle = $this->VehicleList($id);
        
        return view('admin.applicantProfile',compact('applicant','profile','pic','driver','vehicle'));
    }    
 /*   
    public function redirectApproval(){
        if(! \Auth::user()->status == env('STATUS_APPROVAL')){
            return redirect('portal');
        }
        else{
        return view('owner.approval');
        }

    }
    
    public function redirectRequirement(){
        if(! \Auth::user()->status == env('STATUS_PROCESS')){
            return redirect('portal');
        }
        else{
            return view('owner.requirement');
        }

    }
    
    public function redirectSuspended() {
        if(! \Auth::user()->status == env('STATUS_SUSPENDED')){
            return redirect('portal');
        }
        else{
        return view('suspended');
        }
        
    }*/

}