<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\ContactUsQuery;
use Illuminate\Http\Request;

/**
 * CRUD for tblcontactusquery.
 * View name: blood.contact-query-form
 */
class ContactUsQueryController extends Controller
{
    public function create()
    {
        $admins = Admin::orderBy('name')->get();

        return view('blood.contact-query-form', compact('admins'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'admin_id' => 'nullable|exists:tbladmin,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
            'status' => 'nullable|string|max:50',
        ]);

        $data['status'] = $data['status'] ?? 'open';

        ContactUsQuery::create($data);

        return redirect()
            ->route('blood.contact-query.create')
            ->with('success', 'Contact query saved.');
    }
}
