<?php

namespace App\Http\Controllers;

use App\Models\BloodDonor;
use App\Models\ContactInfo;
use App\Models\Requirer;
use Illuminate\Http\Request;

class ContactInfoController extends Controller
{
    public function index()
    {
        $items = ContactInfo::orderByDesc('id')->get();

        return view('contact-info.index', compact('items'));
    }

    public function create()
    {
        $donors = BloodDonor::orderBy('last_name')->get();
        $requirers = Requirer::orderBy('last_name')->get();

        return view('contact-info.create', compact('donors', 'requirers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'blooddonor_id' => 'nullable|exists:tblblooddonors,id',
            'requirer_id' => 'nullable|exists:tblrequirer,id',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email',
            'contact_person' => 'nullable|string|max:255',
        ]);

        ContactInfo::create($data);

        return redirect()
            ->route('blood.contact-info.index')
            ->with('success', 'Contact info saved.');
    }
}
