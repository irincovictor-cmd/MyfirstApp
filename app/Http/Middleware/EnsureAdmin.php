<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    /**
     * Only allow access if the session has admin_logged_in.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->session()->get('admin_logged_in')) {
            return redirect()
                ->route('admin.login')
                ->with('error', 'Please log in to open the admin panel.');
        }

        return $next($request);
    }
}
