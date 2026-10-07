<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Requirer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RequirerController extends Controller
{
    public function index(Request $request)
    {
        $bloodType = $request->query('blood_type');

        $requirers = Requirer::query()
            ->when($bloodType, fn ($q) => $q->where('blood_type', $bloodType))
            ->orderByRaw('required_date IS NULL, required_date ASC')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('blood-request.index', [
            'requirers' => $requirers,
            'bloodType' => $bloodType,
        ]);
    }

    public function requirersIndex()
    {
        $requirers = Requirer::orderByDesc('id')->get();

        return view('requirers.index', compact('requirers'));
    }

    public function create()
    {
        return view('blood-request.create');
    }

    public function requirersCreate()
    {
        return view('requirers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'blood_type' => 'required|string|max:10',
            'required_date' => 'nullable|date',
            'units_needed' => 'nullable|integer|min:1',
            'hospital' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:50',
        ]);

        $data['admin_id'] = $this->defaultAdminId();
        $data['units_needed'] = $data['units_needed'] ?? 1;
        $data['status'] = $data['status'] ?? 'pending';

        Requirer::create($data);

        if (Auth::check() && Auth::user()->isAdmin()) {
            return redirect()->route('blood.requests')
                ->with('success', 'Blood request submitted.');
        }

        return redirect()->route('blood.home')
            ->with('success', 'Thank you! Your blood request was submitted and is pending admin review.');
    }

    public function updateStatus(Request $request, Requirer $requirer)
    {
        $data = $request->validate([
            'status' => 'required|in:pending,approved,fulfilled,rejected',
        ]);

        $requirer->update(['status' => $data['status']]);

        return back()->with('success', 'Request marked '.$data['status'].'.');
    }

    public function destroy(Requirer $requirer)
    {
        $name = trim($requirer->first_name.' '.$requirer->last_name);
        $requirer->delete();

        return back()->with('success', 'Request removed: '.$name);
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
