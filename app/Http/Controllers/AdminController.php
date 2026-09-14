<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentDetail;

class AdminController extends Controller
{
    /**
     * Simple admin panel (Django-admin style overview).
     * Lists students and their linked details from the database.
     */
    public function index()
    {
        $students = Student::with('detail')->orderBy('id')->get();
        $detailsCount = StudentDetail::count();

        return view('admin.index', compact('students', 'detailsCount'));
    }
}
