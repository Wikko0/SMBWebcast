<?php

namespace App\Http\Middleware;

use App\Models\Webhook;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Expire
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $check = Webhook::where('payer_email', Auth::user()->email)->first();
        $start_time = $check->start_time;
        $end_time = $check->end_time;
        $difference = $end_time - $start_time;

        if ($difference <= 0) {
            return response()->json(['error' => 'Your free trial has expired!'], 400);
        }

        return $next($request);
    }
}
