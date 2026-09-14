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
     * Save student details linked to a student_id.
     * student_id is UNIQUE: one detail row per student.
     * If details already exist, update them instead of inserting again.
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'address' => 'required',
            'contact' => 'required',
        ]);

        StudentDetail::updateOrCreate(
            ['student_id' => $request->student_id],
            [
                'address' => $request->address,
                'contact' => $request->contact,
            ]
        );

        return redirect('/student-details')
            ->with('success', 'Student details saved successfully!');
    }
}
