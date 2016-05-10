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
        //$applicant = User::all();
        return view('admin.index',compact('applicant','user'));
    }    
    
    public function viewApplication($id){
        $applicant = User::find($id);
        $profile = \App\OwnerProfile::where('idno',$applicant->id)->first();
        $pic ='/uploads/owner/'.$profile->picture;
        return view('admin.applicantProfile',compact('applicant','pic'));
        
    }
}
