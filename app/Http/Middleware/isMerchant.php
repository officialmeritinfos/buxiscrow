<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Api\BaseController as feedBack;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class isMerchant
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
        $feedBack = new feedBack();
        $user = Auth::user();
        if ($user->accountType == 1){
            return $next($request);
        }else{
            return $feedBack->sendError('Access Denied',['error'=>'unauthorized profile'],401,'Unauthorized Profile');
        }
    }
}
