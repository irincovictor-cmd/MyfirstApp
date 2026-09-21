<?php

namespace App\Http\Controllers;

use App\Models\BloodDonor;
use App\Models\Page;
use App\Models\Requirer;

class BloodHomeController extends Controller
{
    public function index()
    {
        return view('home', [
            'donorCount' => BloodDonor::count(),
            'requestCount' => Requirer::count(),
            'pageCount' => Page::count(),
        ]);
    }
}
