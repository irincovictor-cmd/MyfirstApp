<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\BloodUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class BloodAuthController extends Controller
{
    public function showLogin()
    {
        if (session('blood_admin_id')) {
            return redirect()->route('blood.admin.dashboard');
        }
        if (session('blood_user_id')) {
            return redirect()->route('blood.home');
        }

        return view('blood-auth.login');
    }

    public function showRegister()
    {
        if (session('blood_user_id') || session('blood_admin_id')) {
            return redirect()->route('blood.home');
        }

        return view('blood-auth.register');
    }

    /**
     * Login as user (blood_users) or admin (tbladmin).
     * role = user | admin
     */
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'role' => 'required|in:user,admin',
        ]);

        $email = strtolower(trim($data['email']));

        if ($data['role'] === 'admin') {
            $admin = Admin::where('email', $email)->first();

            if (! $admin || ! Hash::check($data['password'], $admin->password)) {
                return back()
                    ->withErrors(['email' => 'Invalid admin email or password.'])
                    ->onlyInput('email', 'role');
            }

            $request->session()->forget(['blood_user_id', 'blood_user_name']);
            $request->session()->put('blood_admin_id', $admin->id);
            $request->session()->put('blood_admin_name', $admin->name);
            $request->session()->regenerate();

            return redirect()
                ->route('blood.admin.dashboard')
                ->with('success', 'Welcome, admin '.$admin->name.'.');
        }

        $user = BloodUser::where('email', $email)->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return back()
                ->withErrors(['email' => 'Invalid user email or password.'])
                ->onlyInput('email', 'role');
        }

        $request->session()->forget(['blood_admin_id', 'blood_admin_name']);
        $request->session()->put('blood_user_id', $user->id);
        $request->session()->put('blood_user_name', $user->name);
        $request->session()->regenerate();

        return redirect()
            ->route('blood.home')
            ->with('success', 'Welcome, '.$user->name.'.');
    }

    /** Register a regular BloodLink user (not admin). */
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:blood_users,email',
            'password' => 'required|string|min:4|confirmed',
        ]);

        $user = BloodUser::create([
            'name' => $data['name'],
            'email' => strtolower(trim($data['email'])),
            'password' => Hash::make($data['password']),
        ]);

        $request->session()->forget(['blood_admin_id', 'blood_admin_name']);
        $request->session()->put('blood_user_id', $user->id);
        $request->session()->put('blood_user_name', $user->name);
        $request->session()->regenerate();

        return redirect()
            ->route('blood.home')
            ->with('success', 'Account created. You can register as a donor or request blood.');
    }

    public function logout(Request $request)
    {
        $request->session()->forget([
            'blood_user_id',
            'blood_user_name',
            'blood_admin_id',
            'blood_admin_name',
        ]);
        $request->session()->regenerate();

        return redirect()
            ->route('blood.home')
            ->with('success', 'You have been logged out.');
    }
}
