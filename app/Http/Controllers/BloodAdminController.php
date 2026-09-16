<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;

/**
 * CRUD for tbladmin (Blood Donation System).
 * View name: blood.admin-form
 */
class BloodAdminController extends Controller
{
    public function create()
    {
        return view('blood.admin-form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:tbladmin,email',
            'password' => 'required|string|min:4',
        ]);

        $data['password'] = bcrypt($data['password']);

        Admin::create($data);

        return redirect()
            ->route('blood.admin.create')
            ->with('success', 'Admin saved.');
    }
}
