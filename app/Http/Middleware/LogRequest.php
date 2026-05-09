<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogRequest
{
    public function handle(Request $request, Closure $next)
    {
        Log::info("OPD Request data", [
            'send_sms_patient' => $request->has('send_sms_patient') ? $request->input('send_sms_patient') : 'NOT_PRESENT',
            'send_sms_collection' => $request->has('send_sms_collection') ? $request->input('send_sms_collection') : 'NOT_PRESENT',
        ]);

        return $next($request);
    }
}