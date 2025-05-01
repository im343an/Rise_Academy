<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class InactiveLogout
{
    public function handle(Request $request, Closure $next)
    {
        $inactiveLimit = 5 * 60; // 5 minutes inactivity limit

        if (Auth::check()) {
            $lastActivity = session('lastActivityTime', time());
            if (time() - $lastActivity > $inactiveLimit) {
                Auth::logout();
                Session::flush();
                return redirect()->route('login')->with('message', 'Session expired! Please log in again.');
            }
            session(['lastActivityTime' => time()]);
        }

        return $next($request);
    }
}
