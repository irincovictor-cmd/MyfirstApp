<?php

namespace App\Http\Controllers;

use App\Models\ContactUsQuery;
use Illuminate\Http\Request;

class ContactUsQueryController extends Controller
{
    public function index()
    {
        $messages = ContactUsQuery::orderByDesc('id')->get();

        return view('contact-queries.index', compact('messages'));
    }

    public function create()
    {
        return view('contact-queries.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        $data['status'] = 'open';
        $data['admin_id'] = null;

        ContactUsQuery::create($data);

        return redirect()->route('blood.contact')->with('success', 'Message sent. Thank you.');
    }
}
