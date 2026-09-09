<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Show the student form and list of saved students (GET /student)
     */
    public function index()
    {
        $students = Student::latest()->get();

        return view('student', compact('students'));
    }

    /**
     * Handle form submit (POST /student)
     */
    public function show(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:100',
            'age'     => 'required|integer|min:1|max:120',
            'contact' => 'required|string|max:50',
            'address' => 'required|string|max:255',
        ]);

        $student = Student::create($validated);

        $students = Student::latest()->get();

        return view('student', [
            'name'     => $student->name,
            'age'      => $student->age,
            'contact'  => $student->contact,
            'address'  => $student->address,
            'students' => $students,
            'success'  => true,
        ]);
    }

    /**
     * Show the Student Details form and list (GET /student-details)
     */
    public function details()
    {
        $students = Student::latest()->get();

        return view('studentDetails', compact('students'));
    }

    /**
     * Handle Student Details form submit (POST /student-details)
     */
    public function storeDetails(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:100',
            'age'     => 'required|integer|min:1|max:120',
            'contact' => 'required|string|max:50',
            'address' => 'required|string|max:255',
        ]);

        $student = Student::create($validated);

        $students = Student::latest()->get();

        return view('studentDetails', [
            'name'     => $student->name,
            'age'      => $student->age,
            'contact'  => $student->contact,
            'address'  => $student->address,
            'students' => $students,
            'success'  => true,
        ]);
    }
}
