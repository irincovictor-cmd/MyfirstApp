<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        return view('student');
    }

    public function show(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'course' => 'required|string|max:100',
        ]);

        return view('student', [
            'name' => $request->input('name'),
            'course' => $request->input('course'),
        ]);
    }
}
