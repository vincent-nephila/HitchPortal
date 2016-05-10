<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => ['web']], function () {
    //Guest Routes
    Route::get('/',['middleware' => 'guest',function(){return view('main');}]);
    Route::get('congratulation',['middleware' => 'guest',function(){return view('congratulation');}]);
    
    
    //Registration
    Route::get('confirm/{id}/{authkey}','Auth\RegisterController@verifyCode');
    Route::post('confirmed/{id}/{authkey}','Auth\RegisterController@codeVerified');
    
    Route::get('registerOwner',['middleware' => 'guest',function(){return view('owner.register');}]);
    Route::post('registerOwner','Auth\RegisterController@registerOwner');
    
    Route::get('registerPassenger',['middleware' => 'guest',function(){return view('passenger.register');}]);
    Route::post('registerPassenger','Auth\RegisterController@registerPassenger');
    
    Route::get('/admin','Admin\AdminController@ownerApplicationList');
    Route::get('/admin/user/{id}','Admin\AdminController@viewApplication');
       
    //Password Reset
    Route::get('password/email', 'Auth\PasswordController@getEmail');
    Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
    
    //Common user Routes
    Route::auth();
    Route::get('portal','MainController@index');
    
    Route::get('portal/owner/addVehicle','Owner\OwnerController@addVehicle');
    Route::post('portal/owner/addVehicle','Owner\OwnerController@saveVehicle');
    
    Route::get('/portal/owner/addDriver',['middleware' => 'auth',function(){
        $user = \Auth::user();
        return view('owner.addDriver',compact('user'));
    }]);
    Route::post('/portal/owner/addDriver','Owner\OwnerController@saveDriver');
    Route::get('portal/suspendWarning',['middleware' => 'auth',function(){        
        if(! \Auth::user()->status == env('STATUS_SUSPENDED')){
            return redirect('portal');
        }
        else{
        return view('suspended');
        }
        }]);
    Route::get('portal/owner/approval',['middleware' => 'auth',function(){        if(! \Auth::user()->status == env('STATUS_APPROVAL')){
            return redirect('portal');
        }
        else{
        return view('owner.approval');
        }}]);
    Route::get('portal/owner/requirement',['middleware' => 'auth',function(){        
        if(! \Auth::user()->status == env('STATUS_PROCESS')){
            return redirect('portal');
        }
        else{
            return view('owner.requirement');
        }
}]);
Route::post('portal/owner/requirement','Owner\OwnerController@uploadRequirements'); 
Route::get('/addVehicle/{maker}/model','AjaxController@getModel');


});

//Route::get('/addVehicle/{maker}/model','AjaxController@getModel');


    