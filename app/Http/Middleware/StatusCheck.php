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
            return redirect('portal/owner/requirement');
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
