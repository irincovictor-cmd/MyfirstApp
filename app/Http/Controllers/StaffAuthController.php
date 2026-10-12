<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffAuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check() && in_array(Auth::user()->role, ['employee', 'manager', 'supervisor'], true)) {
            return redirect()->route($this->homeRoute(Auth::user()->role));
        }

        return view('staff.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'role' => 'required|in:employee,manager,supervisor',
        ]);

        $email = strtolower(trim($credentials['email']));

        if (! Auth::attempt(
            ['email' => $email, 'password' => $credentials['password']],
            $request->boolean('remember')
        )) {
            return back()
                ->withErrors(['email' => 'Invalid email or password.'])
                ->onlyInput('email', 'role');
        }

        $request->session()->regenerate();

        $user = Auth::user();

        if ($user->role !== $credentials['role']) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()
                ->withErrors(['email' => 'This account is not a '.$credentials['role'].'. Pick the correct role.'])
                ->onlyInput('email', 'role');
        }

        return redirect()
            ->route($this->homeRoute($user->role))
            ->with('success', 'Welcome, '.$user->name.' ('.$user->role.').');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('staff.login')
            ->with('success', 'Logged out.');
    }

    private function homeRoute(string $role): string
    {
        return match ($role) {
            'supervisor' => 'staff.supervisor',
            'manager' => 'staff.manager',
            default => 'staff.employee',
        };
    }
}
