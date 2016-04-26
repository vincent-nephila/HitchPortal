<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Validator;
use App\User;


use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    public function __construct() {
        $this->middleware('guest');
    }
    //
    public function validator(array $data){
        
        return Validator::make($data,[
            'firstname' => 'required|max:255',
            'middlename' => 'required|max:255',
            'lastname' => 'required|max:255',
            'mobile' => 'required|max:12',
            'email' => 'required|email|max:255|unique:users',
            ]);
    }
    
    public function create(array $data){
        
        $authkey = str_random(30);
              
        $user = new User;
        $user->firstname = $data['firstname'];
        $user->middlename = $data['middlename'];
        $user->lastname = $data['lastname'];        
        $user->email = $data['email'];
        $user->mobile = $data['mobile'];
        $user->confirmation_code= $authkey;
        $user->save();
        
       
        Mail::send('email.welcome',['authkey'=>$authkey,'id'=>$user->id,'name'=>$user->firstname], function($message) {
            $message->to(Input::get('email'), Input::get('firstname'))->subject('Welcome to Hitch');});
       
        return $user;
    }
    
    public function registerOwner(Request $request){
        
        $validator=$this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
        $generator = str_random(5);
              
        $user=$this->create($request->all());
        
        $user->status = env('STATUS_PROCESS');
        $user->accesslevel = env('USER_OWNER');
        $user->user_id=$user->id.'-'.$generator;      
        $user->save();
        
        return redirect('congratulation');
    }
    
    public function registerPassenger(Request $request){
        
        $validator=$this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
        $generator = str_random(5);
        
        $user=$this->create($request->all());
        
        $user->status = env('STATUS_OK');
        $user->accesslevel = env('USER_PASSENGER');
        $user->user_id=$user->id.'-'.$generator;
        $user->save();
        
        return redirect('congratulation');
    }   
  
    public function verifyCode($id,$authkey){
        $matchfields=['id'=>$id,'confirmation_code'=>$authkey,'confirmed'=>0];
        $user=User::where($matchfields)->first();
        if(empty($user)){
            return redirect('/')->with('error', "Invalid token");
            
        }
        else{
            return view('confirmation',compact('user'))->with('success', "Your account has been confirmed");
       }

    }
    
    public function codeVerified(Request $request,$id,$authkey){
               
        $this->validate($request, [
            'password' => 'required|min:6|confirmed',
        ]);   
        $matchfields=['id'=>$id,'confirmation_code'=>$authkey,'confirmed'=>0];
        $user=User::where($matchfields)->first();
        
        $user->password = bcrypt($request->password);
        $user->confirmed = 1;
        $user->save();

        \Auth::loginUsingId($id);
                
        return redirect('portal');
    }    
}


