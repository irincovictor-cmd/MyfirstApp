<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentDetail;

class AdminController extends Controller
{
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
     * Delete a student.
     * Related studentdetails row is removed by FK onDelete('cascade').
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
