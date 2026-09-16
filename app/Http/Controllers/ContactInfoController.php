<?php

namespace App\Http\Controllers;

use App\Models\BloodDonor;
use App\Models\ContactInfo;
use App\Models\Requirer;
use Illuminate\Http\Request;

/**
 * CRUD for tblcontactinfo.
 * View name: blood.contact-info-form
 */
class ContactInfoController extends Controller
{
    public function create()
    {
        $donors = BloodDonor::orderBy('last_name')->get();
        $requirers = Requirer::orderBy('last_name')->get();

        return view('blood.contact-info-form', compact('donors', 'requirers'));
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
            ->route('blood.contact-info.create')
            ->with('success', 'Contact info saved.');
    }
}
