<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class HomePhysiotherapistMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            $role = $user->roles->pluck('name')->first();

            if ($role === 'HomePhysiotherapist') {
                return $next($request);
            }

            abort(403, "This area is restricted to HomePhysiotherapist role only.");
        }

        return redirect('/login');
    }
}