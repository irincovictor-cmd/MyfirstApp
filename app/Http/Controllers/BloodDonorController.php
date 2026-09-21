<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\BloodDonor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class BloodDonorController extends Controller
{
    public function index()
    {
        $donors = BloodDonor::orderByDesc('id')->get();

        return view('blood-donors.index', compact('donors'));
    }

    public function create()
    {
        return view('blood-donors.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'blood_type' => 'required|string|max:10',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:50',
        ]);

        $data['admin_id'] = $this->defaultAdminId();
        $data['status'] = $data['status'] ?? 'pending';

        BloodDonor::create($data);

        return redirect()->route('blood.donors')->with('success', 'Donor registered successfully.');
    }

    private function defaultAdminId(): int
    {
        $admin = Admin::first();
        if ($admin) {
            return $admin->id;
        }

        return Admin::create([
            'name' => 'System',
            'email' => 'system@blood.local',
            'password' => Hash::make('secret'),
        ])->id;
    }
}
