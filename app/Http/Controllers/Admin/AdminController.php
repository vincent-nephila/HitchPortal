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
        //$applicant = User::where('accesslevel',env('USER_OWNER'));
        $applicant = User::all();
        return view('admin.index',compact('applicant','user'));
    }    
    
    public function viewApplication($id){
        $applicant = User::find($id);
        //$pic = Storage::get('DSC_0945.JPG');
        $pic = storage_path();
        //Request::move($pic,storage_path());        
        return view('admin.applicantProfile',compact('applicant','pic'));
        
    }
}
