<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Show the student form (GET /student).
     */
    public function create()
    {
        return view('student');
    }

    /**
     * Store a new student (POST /student).
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'course' => 'required',
            'age' => 'required|integer',
        ]);

        Student::create([
            'name' => $request->name,
            'course' => $request->course,
            'age' => $request->age,
        ]);

        return redirect('/student')
            ->with('success', 'Student added successfully!');
    }
}
