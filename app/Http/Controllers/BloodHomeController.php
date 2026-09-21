<?php

namespace App\Http\Controllers;

use App\Models\BloodDonor;
use App\Models\Page;
use App\Models\Requirer;

class BloodHomeController extends Controller
{
    public function index()
    {
        $donorCount = BloodDonor::count();
        $requestCount = Requirer::count();
        $pageCount = Page::count();

        return view('blood.home', compact('donorCount', 'requestCount', 'pageCount'));
    }
}
