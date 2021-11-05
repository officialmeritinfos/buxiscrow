<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\BaseController as feedBack;

class checkTwoWay
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        $feedback = new feedBack();
        if ($user->twoWay !=1){
            return $next($request);
        }elseif ($user->twoWay ==1 && $user->twowayPassed == 1){
            return $next($request);
        }else{
            return $feedback->sendError('Access Denied',['error'=>'2FA active on account and must be completed'],'401.4','Authorization failed by filter.');
        }
    }
}
