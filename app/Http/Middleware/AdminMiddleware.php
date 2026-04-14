<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if(Auth::check()){
                /** @var App\models\User */
            $user = Auth::user();
            if($user->hasRole(['Super-Admin','Admin','owner','DIRECTOR'])){
                return $next($request);
            }
            abort(403, "You do not have Correct Role To Access");
        }else{
            return  redirect('/login');
        }
            abort(401, "You do not have Correct Role To Access");
    }
}
