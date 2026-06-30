<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckIdleTimeout
{
    private $timeout = 30; // 10 detik

    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {

            $lastActivity = session('last_activity');

            if ($lastActivity && (time() - $lastActivity > $this->timeout)) {

                Auth::logout();

                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()
                    ->route('login')
                    ->with('error', 'Sesi berakhir karena tidak ada aktivitas.');
            }

            session(['last_activity' => time()]);
        }

        return $next($request);
    }
}