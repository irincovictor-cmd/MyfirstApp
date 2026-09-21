<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentDetail;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function showLogin()
    {
        if (session('admin_logged_in')) {
            return redirect()->route('admin.index');
        }

        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate(['password' => 'required|string']);

        $expected = env('ADMIN_PASSWORD', 'admin123');

        if (! hash_equals((string) $expected, (string) $request->password)) {
            return back()
                ->withErrors(['password' => 'Incorrect password.'])
                ->onlyInput();
        }

        $request->session()->put('admin_logged_in', true);
        $request->session()->regenerate();

        return redirect()->route('admin.students')->with('success', 'Logged in.');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('admin_logged_in');
        $request->session()->regenerate();

        return redirect()->route('admin.login')->with('success', 'Logged out.');
    }

    /** Student list (assignment uses admin/index for blood). */
    public function index()
    {
        return $this->students();
    }

    public function students()
    {
        $students = Student::with('detail')->orderBy('id')->get();
        $detailsCount = StudentDetail::count();

        return view('admin.students', compact('students', 'detailsCount'));
    }

    public function destroy(Student $student)
    {
        $name = $student->name;
        $student->delete();

        return redirect()
            ->route('admin.students')
            ->with('success', "Deleted student: {$name}");
    }
}
