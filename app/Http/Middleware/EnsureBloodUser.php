<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/** Any logged-in user (role user or admin). */
class EnsureBloodUser
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check()) {
            return redirect()
                ->route('blood.login')
                ->with('error', 'Please log in to continue.');
        }

        return $next($request);
    }
}
