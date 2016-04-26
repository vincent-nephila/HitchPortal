<?php   

namespace App\Http\Controllers;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;

use App\User;

class RegisterController extends Controller
{
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
