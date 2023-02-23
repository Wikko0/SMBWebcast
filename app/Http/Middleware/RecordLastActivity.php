<?php

namespace App\Http\Middleware;

use App\Models\Meeting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecordLastActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        // Check if the user is authenticated and has the 'admin' role
        if (Auth::check() && (Auth::user()->hasRole('admin') || Auth::user()->hasRole('manager') || Auth::user()->hasRole('user'))) {
            // Get the current URL path
            $path = $request->path();

            // Update the last_activity timestamp for the user
            Auth::user()->update(['last_activity' => now()]);

            $meetingId = basename($path);

                // Update the last_activity timestamp for the meeting with the given ID
                Meeting::where('meeting_id', $meetingId)->update(['last_activity' => now()]);

        }

        // Pass the request to the next middleware or controller action
        return $next($request);
    }

}
