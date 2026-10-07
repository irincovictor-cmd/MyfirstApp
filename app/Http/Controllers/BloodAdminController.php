<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\BloodDonor;
use App\Models\ContactUsQuery;
use App\Models\Page;
use App\Models\Requirer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class BloodAdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.index', [
            'admins' => User::where('role', 'admin')->count(),
            'users' => User::where('role', 'user')->count(),
            'donors' => BloodDonor::count(),
            'requests' => Requirer::count(),
            'messages' => ContactUsQuery::count(),
            'pages' => Page::count(),
            'recentDonors' => BloodDonor::orderByDesc('id')->limit(5)->get(),
            'recentRequests' => Requirer::orderByDesc('id')->limit(5)->get(),
            'recentMessages' => ContactUsQuery::orderByDesc('id')->limit(5)->get(),
        ]);
    }

    /** List all login accounts (users + admins). */
    public function users()
    {
        $accounts = User::orderBy('role')->orderBy('name')->get();

        return view('admin.users', compact('accounts'));
    }

    /** Change a user's password. */
    public function updatePassword(Request $request, User $user)
    {
        $data = $request->validate([
            'password' => 'required|string|min:4|confirmed',
        ]);

        $user->password = $data['password'];
        $user->save();

        return back()->with('success', 'Password updated for '.$user->email.'.');
    }

    /** Change role: user ↔ admin. */
    public function updateRole(Request $request, User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'You cannot change your own role.');
        }

        $data = $request->validate([
            'role' => 'required|in:user,admin',
        ]);

        // Keep at least one admin
        if ($user->role === 'admin' && $data['role'] === 'user') {
            $adminCount = User::where('role', 'admin')->count();
            if ($adminCount <= 1) {
                return back()->with('error', 'Cannot demote the last admin.');
            }
        }

        $user->role = $data['role'];
        $user->save();

        return back()->with('success', $user->email.' is now '.$data['role'].'.');
    }

    /** Delete a user account. */
    public function destroyUser(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        if ($user->role === 'admin') {
            $adminCount = User::where('role', 'admin')->count();
            if ($adminCount <= 1) {
                return back()->with('error', 'Cannot delete the last admin.');
            }
        }

        $email = $user->email;
        $user->delete();

        return back()->with('success', 'Account deleted: '.$email);
    }

    public function create()
    {
        return view('admin.create');
    }

    public function setupForm()
    {
        if (User::where('role', 'admin')->exists()) {
            return redirect()->route('blood.login')
                ->with('error', 'An admin already exists. Log in as admin.');
        }

        return view('admin.create', ['setup' => true]);
    }

    public function store(Request $request)
    {
        $isSetup = ! User::where('role', 'admin')->exists();

        if (! $isSetup && (! Auth::check() || ! Auth::user()->isAdmin())) {
            return redirect()->route('blood.login')
                ->with('error', 'Admin access required.');
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:4',
        ]);

        $email = strtolower(trim($data['email']));

        $user = User::create([
            'name' => $data['name'],
            'email' => $email,
            'password' => $data['password'],
            'role' => 'admin',
        ]);

        if (! Admin::where('email', $email)->exists()) {
            Admin::create([
                'name' => $data['name'],
                'email' => $email,
                'password' => Hash::make($data['password']),
            ]);
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()
            ->route('blood.admin.dashboard')
            ->with('success', $isSetup
                ? 'First admin created. You are logged in.'
                : 'Admin account created.');
    }
}
