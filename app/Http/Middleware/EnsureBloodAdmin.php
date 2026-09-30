<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Admin power: only blood admin session may pass.
 */
class EnsureBloodAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->session()->get('blood_admin_id')) {
            return redirect()
                ->route('blood.login')
                ->with('error', 'Admin access only. Please log in with an admin account.');
        }

        return $next($request);
    }
}
