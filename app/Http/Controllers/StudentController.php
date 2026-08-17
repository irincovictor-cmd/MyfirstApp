<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(){
        return view('student');
    }
    public function show(Request $request){
        $name = $request->name;
        $course = $request->course;
        return view('student', ['name' => $name, 'course' => $course]);
    }

}