<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Requirer;
use Illuminate\Http\Request;

/**
 * CRUD for tblrequirer.
 * View name: blood.requirer-form
 */
class RequirerController extends Controller
{
    public function create()
    {
        $admins = Admin::orderBy('name')->get();

        return view('blood.requirer-form', compact('admins'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'admin_id' => 'required|exists:tbladmin,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'blood_type' => 'required|string|max:10',
            'required_date' => 'nullable|date',
            'units_needed' => 'nullable|integer|min:1',
            'hospital' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:50',
        ]);

        $data['units_needed'] = $data['units_needed'] ?? 1;
        $data['status'] = $data['status'] ?? 'pending';

        Requirer::create($data);

        return redirect()
            ->route('blood.requirer.create')
            ->with('success', 'Requirer saved.');
    }
}
