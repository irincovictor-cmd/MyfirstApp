<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentDetail;
use Illuminate\Http\Request;

class StudentDetailController extends Controller
{
    /**
     * Show form to add address/contact for an existing student.
     */
    public function create()
    {
        $students = Student::all();

        return view('student-details', compact('students'));
    }

    /**
     * Store student details linked to a student_id.
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'address' => 'required',
            'contact' => 'required',
        ]);

        StudentDetail::create([
            'student_id' => $request->student_id,
            'address' => $request->address,
            'contact' => $request->contact,
        ]);

        return redirect('/student-details')
            ->with('success', 'Student details saved successfully!');
    }
}
