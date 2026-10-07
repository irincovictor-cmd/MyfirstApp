<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\BloodDonor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class BloodDonorController extends Controller
{
    public function index(Request $request)
    {
        $bloodType = $request->query('blood_type');

        $donors = BloodDonor::query()
            ->when($bloodType, fn ($q) => $q->where('blood_type', $bloodType))
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('blood-donors.index', [
            'donors' => $donors,
            'bloodType' => $bloodType,
        ]);
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

        // Users cannot view the full list — send them home
        if (Auth::check() && Auth::user()->isAdmin()) {
            return redirect()->route('blood.donors')
                ->with('success', 'Donor registered.');
        }

        return redirect()->route('blood.home')
            ->with('success', 'Thank you! Your donor registration was submitted and is pending admin review.');
    }

    public function updateStatus(Request $request, BloodDonor $donor)
    {
        $data = $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $donor->update(['status' => $data['status']]);

        return back()->with('success', 'Donor marked '.$data['status'].'.');
    }

    public function destroy(BloodDonor $donor)
    {
        $name = trim($donor->first_name.' '.$donor->last_name);
        $donor->delete();

        return back()->with('success', 'Donor removed: '.$name);
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
