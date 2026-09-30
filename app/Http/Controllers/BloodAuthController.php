<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BloodAuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return Auth::user()->isAdmin()
                ? redirect()->route('blood.admin.dashboard')
                : redirect()->route('blood.home');
        }

        return view('blood-auth.login');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('blood.home');
        }

        return view('blood-auth.register');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'role' => 'required|in:user,admin',
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
                ->withErrors(['email' => 'This account is not a '.$credentials['role'].'. Pick the correct account type.'])
                ->onlyInput('email', 'role');
        }

        if ($user->isAdmin()) {
            return redirect()
                ->route('blood.admin.dashboard')
                ->with('success', 'Welcome, admin '.$user->name.'.');
        }

        return redirect()
            ->route('blood.home')
            ->with('success', 'Welcome, '.$user->name.'.');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:4|confirmed',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => strtolower(trim($data['email'])),
            'password' => $data['password'],
            'role' => 'user',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()
            ->route('blood.home')
            ->with('success', 'Account created. You can register as a donor or request blood.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('blood.home')
            ->with('success', 'You have been logged out.');
    }
}
