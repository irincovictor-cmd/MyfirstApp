<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\BloodDonor;
use Illuminate\Http\Request;

/**
 * CRUD for tblblooddonors.
 * View name: blood.donor-form
 */
class BloodDonorController extends Controller
{
    public function create()
    {
        $admins = Admin::orderBy('name')->get();

        return view('blood.donor-form', compact('admins'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'admin_id' => 'required|exists:tbladmin,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'blood_type' => 'required|string|max:10',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:50',
        ]);

        $data['status'] = $data['status'] ?? 'pending';

        BloodDonor::create($data);

        return redirect()
            ->route('blood.donor.create')
            ->with('success', 'Blood donor saved.');
    }
}
