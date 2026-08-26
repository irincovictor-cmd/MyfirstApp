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
     * Validates input, saves to students table, then shows the form with success + list.
     */
    public function show(Request $request)
    {
        $validated = $request->validate([
            'name'   => 'required|string|max:100',
            'course' => 'required|string|max:100',
            'age'    => 'required|integer|min:1|max:120',
        ]);

        // Save to the students table (from create_students_table migration)
        $student = Student::create($validated);

        $students = Student::latest()->get();

        return view('student', [
            'name'     => $student->name,
            'course'   => $student->course,
            'age'      => $student->age,
            'students' => $students,
            'success'  => true,
        ]);
    }
}
