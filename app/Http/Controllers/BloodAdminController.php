<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\BloodDonor;
use App\Models\ContactUsQuery;
use App\Models\Page;
use App\Models\Requirer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class BloodAdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.index', [
            'admins' => Admin::count(),
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

    /**
     * Public only when there is NO admin yet (bootstrap first admin).
     */
    public function setupForm()
    {
        if (Admin::count() > 0) {
            return redirect()->route('blood.login')
                ->with('error', 'An admin already exists. Log in as admin.');
        }

        return view('admin.create', ['setup' => true]);
    }

    public function store(Request $request)
    {
        $isSetup = Admin::count() === 0;

        // If admins exist, only logged-in blood admin may create more
        if (! $isSetup && ! $request->session()->get('blood_admin_id')) {
            return redirect()->route('blood.login')
                ->with('error', 'Admin access required.');
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:tbladmin,email',
            'password' => 'required|string|min:4',
        ]);

        $data['password'] = Hash::make($data['password']);
        $admin = Admin::create($data);

        // Auto-login after first setup or when creating while logged in
        $request->session()->forget(['blood_user_id', 'blood_user_name']);
        $request->session()->put('blood_admin_id', $admin->id);
        $request->session()->put('blood_admin_name', $admin->name);
        $request->session()->regenerate();

        return redirect()
            ->route('blood.admin.dashboard')
            ->with('success', $isSetup
                ? 'First admin created. You are logged in.'
                : 'Admin account created.');
    }
}
