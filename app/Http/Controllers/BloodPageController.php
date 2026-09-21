<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class BloodPageController extends Controller
{
    public function index()
    {
        $pages = Page::orderByDesc('id')->get();

        return view('blood.pages', compact('pages'));
    }

    public function create()
    {
        return view('blood.page-form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'page_title' => 'required|string|max:255',
            'page_slug' => 'nullable|string|max:255|unique:tblpages,page_slug',
            'page_content' => 'nullable|string',
        ]);

        $data['admin_id'] = $this->defaultAdminId();
        $data['page_slug'] = $data['page_slug']
            ?? Str::slug($data['page_title']).'-'.Str::lower(Str::random(4));

        Page::create($data);

        return redirect()
            ->route('blood.pages')
            ->with('success', 'Page created.');
    }

    private function defaultAdminId(): int
    {
        $admin = Admin::first();
        if ($admin) {
            return $admin->id;
        }

        return Admin::create([
            'name' => 'System',
            'email' => 'system@blood.local',
            'password' => Hash::make('secret'),
        ])->id;
    }
}
