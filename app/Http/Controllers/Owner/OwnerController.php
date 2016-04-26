<?php

namespace App\Http\Controllers\Owner;

use Illuminate\Http\Request;
use App\OwnerProfile;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Response;



class OwnerController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    
    public function uploadRequirements(Request $request){
        
        $picture = $request->file('pix');
        $allowedFileTypes = config('app.allowedFileTypes');
        $maxFileSize = config('app.maxFileSize');
        
        $validator = Validator::make($request->all(),[
            'picture' => 'required|image|max:1000',
        ]);
        
        if($validator->fails()){
            return response('There are errors in the form',400);
        }
  /*      $this->validate($request, [
            //'birthdate' => 'required|date',
            //'address' => 'required|max:255',
            'pix' => 'required|mimes:'.$allowedFileTypes.'|max:'.$maxFileSize,           
        ]);          */
  

        return redirect('/logout');
    }
}
