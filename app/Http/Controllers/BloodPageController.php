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
        $this->ensureDefaultPages();

        $pages = Page::orderBy('page_title')->get();

        return view('pages.index', compact('pages'));
    }

    public function show(Page $page)
    {
        return view('pages.show', compact('page'));
    }

    public function create()
    {
        return view('pages.create');
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

        return redirect()->route('blood.pages')->with('success', 'Page created.');
    }

    /**
     * Ensure starter guides exist (by slug).
     * Works even if other test pages already exist in the table.
     */
    private function ensureDefaultPages(): void
    {
        $adminId = $this->defaultAdminId();

        $defaults = [
            [
                'page_title' => 'About BloodLink',
                'page_slug' => 'about',
                'page_content' => "BloodLink is a simple blood donation system for our community.\n\n"
                    ."It helps people register as blood donors, submit blood requests for patients, "
                    ."and lets staff review and update the status of each record.\n\n"
                    ."This project was built with Laravel for learning web development — "
                    ."forms, database tables, login roles, and admin actions.",
            ],
            [
                'page_title' => 'How to donate',
                'page_slug' => 'how-to-donate',
                'page_content' => "1. Create a User account and log in.\n"
                    ."2. Open Donors → + Donor.\n"
                    ."3. Fill in your name, blood type, and contact details.\n"
                    ."4. Submit the form. Your status starts as pending.\n"
                    ."5. An admin will approve or reject your registration.\n\n"
                    ."Tip: Be honest about your blood type and health details so matching is safer.",
            ],
            [
                'page_title' => 'How to request blood',
                'page_slug' => 'how-to-request',
                'page_content' => "1. Log in with a User account.\n"
                    ."2. Open Requests → + Request.\n"
                    ."3. Enter patient name, blood type, units needed, hospital, and date needed.\n"
                    ."4. Submit. Status starts as pending.\n"
                    ."5. Admins can approve, mark fulfilled, or reject the request.\n\n"
                    ."Urgent cases (needed within 2 days) are highlighted on the requests list.",
            ],
            [
                'page_title' => 'FAQ',
                'page_slug' => 'faq',
                'page_content' => "Q: Do I need an account to contact support?\n"
                    ."A: No. Anyone can use the Contact page.\n\n"
                    ."Q: Who can approve donors and requests?\n"
                    ."A: Only Admin accounts.\n\n"
                    ."Q: What blood types are supported?\n"
                    ."A: A+, A-, B+, B-, AB+, AB-, O+, O-.\n\n"
                    ."Q: Can I delete a record?\n"
                    ."A: Admins can delete from the Donors or Requests list.\n\n"
                    ."Q: Where do contact messages go?\n"
                    ."A: They are saved in the database and listed under Admin → Messages.",
            ],
        ];

        foreach ($defaults as $row) {
            Page::firstOrCreate(
                ['page_slug' => $row['page_slug']],
                [
                    'admin_id' => $adminId,
                    'page_title' => $row['page_title'],
                    'page_content' => $row['page_content'],
                ]
            );
        }
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
