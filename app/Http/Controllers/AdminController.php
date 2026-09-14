<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentDetail;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Show admin login form.
     */
    public function showLogin()
    {
        if (session('admin_logged_in')) {
            return redirect()->route('admin.index');
        }

        return view('admin.login');
    }

    /**
     * Check password from .env (ADMIN_PASSWORD).
     */
    public function login(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        $expected = env('ADMIN_PASSWORD', 'admin123');

        if (!hash_equals((string) $expected, (string) $request->password)) {
            return back()
                ->withErrors(['password' => 'Incorrect password.'])
                ->onlyInput();
        }

        $request->session()->put('admin_logged_in', true);
        $request->session()->regenerate();

        return redirect()
            ->route('admin.index')
            ->with('success', 'Logged in to admin.');
    }

    /**
     * Log out of admin panel.
     */
    public function logout(Request $request)
    {
        $request->session()->forget('admin_logged_in');
        $request->session()->regenerate();

        return redirect()
            ->route('admin.login')
            ->with('success', 'Logged out.');
    }

    /**
     * Simple admin panel — list students and linked details.
     */
    public function index()
    {
        $students = Student::with('detail')->orderBy('id')->get();
        $detailsCount = StudentDetail::count();

        return view('admin.index', compact('students', 'detailsCount'));
    }

    /**
     * Delete a student (details cascade via FK).
     */
    public function destroy(Student $student)
    {
        $name = $student->name;
        $student->delete();

        return redirect()
            ->route('admin.index')
            ->with('success', "Deleted student: {$name}");
    }
}
