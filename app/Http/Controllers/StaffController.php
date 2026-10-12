<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

/**
 * Staff hierarchy demo (Supervisor > Manager > Employee).
 * Uses users table + role column from BloodLink.
 *
 * Access (from class whiteboard):
 * - Employee  → employee dashboard only
 * - Manager   → employee + manager + supervisor pages; can add/edit/delete employees
 * - Supervisor → supervisor + employee dashboards; cannot open manager page
 */
class StaffController extends Controller
{
    public function employee()
    {
        return view('staff.employee', [
            'user' => Auth::user(),
        ]);
    }

    public function manager()
    {
        $employees = User::where('role', 'employee')->orderBy('name')->get();

        return view('staff.manager', [
            'user' => Auth::user(),
            'employees' => $employees,
        ]);
    }

    public function supervisor()
    {
        $counts = [
            'employees' => User::where('role', 'employee')->count(),
            'managers' => User::where('role', 'manager')->count(),
            'supervisors' => User::where('role', 'supervisor')->count(),
        ];

        return view('staff.supervisor', [
            'user' => Auth::user(),
            'counts' => $counts,
        ]);
    }

    /** Manager: create employee account. */
    public function storeEmployee(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:4',
        ]);

        User::create([
            'name' => $data['name'],
            'email' => strtolower(trim($data['email'])),
            'password' => $data['password'],
            'role' => 'employee',
        ]);

        return back()->with('success', 'Employee created: '.$data['email']);
    }

    /** Manager: update employee name/email/password. */
    public function updateEmployee(Request $request, User $user)
    {
        if ($user->role !== 'employee') {
            return back()->with('error', 'You can only edit employee accounts.');
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => 'nullable|string|min:4',
        ]);

        $user->name = $data['name'];
        $user->email = strtolower(trim($data['email']));
        if (! empty($data['password'])) {
            $user->password = $data['password'];
        }
        $user->save();

        return back()->with('success', 'Employee updated: '.$user->email);
    }

    /** Manager: delete employee. */
    public function destroyEmployee(User $user)
    {
        if ($user->role !== 'employee') {
            return back()->with('error', 'You can only delete employee accounts.');
        }

        $email = $user->email;
        $user->delete();

        return back()->with('success', 'Employee deleted: '.$email);
    }
}
