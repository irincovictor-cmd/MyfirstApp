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

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:tbladmin,email',
            'password' => 'required|string|min:4',
        ]);

        $data['password'] = Hash::make($data['password']);
        Admin::create($data);

        return redirect()
            ->route('blood.admin.dashboard')
            ->with('success', 'Admin account created.');
    }
}
