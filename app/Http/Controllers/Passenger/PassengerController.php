<?php

namespace App\Http\Controllers\Passenger;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Input;

class PassengerController extends Controller
{
    //
    public function register(Request $request){
        
        $this->validate($request, [
            'firstname' => 'required|max:255',
            'middlename' => 'required|max:255',
            'lastname' => 'required|max:255',
            'mobile' => 'required|max:12',
            'email' => 'required|email|max:255|unique:users',
            
        ]);   
       
        $authkey = str_random(30);
        
        
        
        $user = new User;
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->middlename = $request->middlename;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->status = env('STATUS_OK');
        $user->accesslevel = env('USER_PASSENGER');
        $user->confirmation_code=$authkey;
        $user->save();
        
        $email = User::where('confirmation_code',$authkey)->first();
        
       
        Mail::send('email.welcome',['authkey'=>$authkey,'access'=>$email->id,'name'=>$email->firstname], function($message) {
            $message->to(Input::get('email'), Input::get('firstname'))->subject('Welcome to Hitch');});
       
        return redirect('congratulation');
    }
    
}
