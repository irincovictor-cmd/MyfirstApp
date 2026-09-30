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

class BloodAdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.index', [
            'admins' => User::where('role', 'admin')->count(),
            'donors' => BloodDonor::count(),
            'requests' => Requirer::count(),
            'messages' => ContactUsQuery::count(),
            'pages' => Page::count(),
            'recentDonors' => BloodDonor::orderByDesc('id')->limit(5)->get(),
            'recentRequests' => Requirer::orderByDesc('id')->limit(5)->get(),
            'recentMessages' => ContactUsQuery::orderByDesc('id')->limit(5)->get(),
        ]);
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

        // Mirror into tbladmin for ERD assignment table
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
