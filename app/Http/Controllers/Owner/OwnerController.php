<?php

namespace App\Http\Controllers\Owner;

use Illuminate\Http\Request;
use App\OwnerProfile;
use App\User;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class OwnerController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        
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

        
        $request->file('picture')->move(public_path.'upload',$picture);
        $request->file('id1')->move(public_path.'upload',$id1);
        $request->file('id2')->move(public_path.'upload',$id2);
        
        $profile = new OwnerProfile;
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
        
        return view('owner.addVehicle',compact('result'));
    }
    
    public function addDriver(){
        
    }
}

