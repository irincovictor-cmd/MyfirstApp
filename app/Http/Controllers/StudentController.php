<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Show the student form (GET /student)
     */
    public function index()
    {
        return view('student');
    }

    /**
     * Handle form submit (POST /student)
     * Validates input, then shows the same page with the submitted data.
     */
    public function show(Request $request)
    {
        // Validate the form fields
        $validated = $request->validate([
            'name'   => 'required|string|max:100',
            'course' => 'required|string|max:100',
            'year'   => 'nullable|string|max:50',
        ]);

        // Pass the data back to the view so it can be displayed
        return view('student', [
            'name'   => $validated['name'],
            'course' => $validated['course'],
            'year'   => $validated['year'] ?? null,
        ]);
    }
}
