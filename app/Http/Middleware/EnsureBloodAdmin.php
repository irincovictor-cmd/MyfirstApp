<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/** Only users with role = admin. */
class EnsureBloodAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check()) {
            return redirect()
                ->route('blood.login')
                ->with('error', 'Please log in as admin.');
        }

        if (! Auth::user()->isAdmin()) {
            return redirect()
                ->route('blood.home')
                ->with('error', 'Admin access only.');
        }

        return $next($request);
    }
}
