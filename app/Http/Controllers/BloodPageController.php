<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Page;
use Illuminate\Http\Request;

/**
 * CRUD for tblpages.
 * View name: blood.page-form
 */
class BloodPageController extends Controller
{
    public function create()
    {
        $admins = Admin::orderBy('name')->get();

        return view('blood.page-form', compact('admins'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'admin_id' => 'required|exists:tbladmin,id',
            'page_title' => 'required|string|max:255',
            'page_slug' => 'required|string|max:255|unique:tblpages,page_slug',
            'page_content' => 'nullable|string',
        ]);

        Page::create($data);

        return redirect()
            ->route('blood.page.create')
            ->with('success', 'Page saved.');
    }
}
