<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;



class MainController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
        $this->middleware('status',['except'=>['redirectRequirement','redirectApproval','redirectSuspended']]);
    }
    
    public function index(){
        $accesslevel = \Auth::user()->accesslevel;
        $user = \Auth::user();
        switch($accesslevel){
            case env('USER_PASSENGER');
                return view('passenger.index',compact('user'));
                break;
            case env('USER_OWNER');
                return view('owner.index',compact('user'));
                break;
            case env('USER_ADMIN');
                return redirect('/admin');
                break;        
            case env('USER_DRIVER');
                return view('owner.index',compact('user'));
                break;        
        }
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