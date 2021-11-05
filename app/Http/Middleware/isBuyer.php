<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\BaseController as feedBack;

class isBuyer
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
        if ($user->accountType == 2){
            return $next($request);
        }else{
            return $feedBack->sendError('Access Denied',['error'=>'unauthorized profile'],401,'Unauthorized Profile');
        }
    }
}
