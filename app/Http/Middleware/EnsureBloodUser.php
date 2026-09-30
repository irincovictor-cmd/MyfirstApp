<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * User power: logged-in blood user OR blood admin may pass.
 */
class EnsureBloodUser
{
    public function handle(Request $request, Closure $next): Response
    {
        $isUser = $request->session()->get('blood_user_id');
        $isAdmin = $request->session()->get('blood_admin_id');

        if (! $isUser && ! $isAdmin) {
            return redirect()
                ->route('blood.login')
                ->with('error', 'Please log in as a user to continue.');
        }

        return $next($request);
    }
}
