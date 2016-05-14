<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class StatusCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::user()->status == env('STATUS_PROCESS')){
            $profile = \App\OwnerProfile::where('idno',Auth::user()->id)->count();
            if($profile == 0){
                return redirect('portal/owner/requirement');
            }
                return redirect('portal/owner/addVehicle');
        }
        if(Auth::user()->status == env('STATUS_APPROVAL')){
            return redirect('portal/owner/approval');
        }

        if(Auth::user()->status == env('STATUS_SUSPENDED')){
            return redirect('portal/suspendWarning');
        }

        return $next($request);
    }
}
