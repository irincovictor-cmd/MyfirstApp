# Blood Donation (BloodLink) — current architecture

> This file previously described a planning stage ("views to create tomorrow"
> under `resources/views/blood/`). That folder was **deleted** — it was
> never wired to any route and had gone stale. This file now documents
> what is actually live. See `UI_UX_FIXES_2026-09.md` for the change log.

## Layout

All BloodLink pages extend **`resources/views/layouts/blood.blade.php`**
(not `blood.layout` / `resources/views/blood/layout.blade.php` — that
file no longer exists). This is the only blood-themed layout in the app.

## Live view folders

| Folder | Used by | Notes |
|---|---|---|
| `resources/views/home.blade.php` | `BloodHomeController::index` | Public landing page |
| `resources/views/blood-donors/` | `BloodDonorController` | Live donor list + form |
| `resources/views/blood-request/` | `RequirerController::index/create/store` | Live request list + form |
| `resources/views/requirers/` | `RequirerController::requirersIndex/requirersCreate` | Duplicate of `blood-request/`, kept only because the assignment rubric requires this exact folder name. **Not linked from navigation.** Not the version to edit for UI changes. |
| `resources/views/pages/` | `BloodPageController` | Info pages |
| `resources/views/contact-queries/` | `ContactUsQueryController` | Public contact form |
| `resources/views/contact-info/` | `ContactInfoController` | Contact info for donors/requirers |
| `resources/views/admin/` | `BloodAdminController`, and (index/create) shared naming with the Student `AdminController` — see below | Dashboard + admin registration |

## Routes (`routes/web.php`)

```
GET  /blood                      blood.home
GET  /blood/donors                blood.donors            (supports ?blood_type=)
GET  /blood/donors/create         blood.donor.create
POST /blood/donors                blood.donor.store
GET  /blood/requests              blood.requests          (supports ?blood_type=, sorted by urgency)
GET  /blood/requests/create       blood.request.create
POST /blood/requests              blood.request.store
GET  /blood/requirers             blood.requirers         (duplicate view, not in nav)
GET  /blood/requirers/create      blood.requirer.create
GET  /blood/contact               blood.contact
POST /blood/contact               blood.contact.store
GET  /blood/contact-queries       blood.contact-queries
GET  /blood/pages                 blood.pages
GET  /blood/pages/create          blood.page.create
POST /blood/pages                 blood.page.store
GET  /blood/contact-info          blood.contact-info.index
GET  /blood/contact-info/create   blood.contact-info.create
POST /blood/contact-info          blood.contact-info.store

-- Auth-gated (middleware: admin) --
GET  /blood/admin                 blood.admin.dashboard
GET  /blood/admin/register        blood.admin.create
POST /blood/admin/register        blood.admin.store
```

## Admin access (important)

`/blood/admin*` now shares the **same login** as the Student admin panel
(`/admin/login`), gated by the `admin` route middleware
(`App\Http\Middleware\EnsureAdmin`, alias registered in `bootstrap/app.php`).
There is **one shared password**, set via `ADMIN_PASSWORD` in `.env`
(see `.env.example`). Logging in at `/admin/login` unlocks both:
- `/admin/students` (Student panel)
- `/blood/admin` (BloodLink dashboard)

This was previously wide open with no auth at all — see
`UI_UX_FIXES_2026-09.md` for why that changed.

## Field names (unchanged, still required for forms)

**Admin:** `name`, `email`, `password`
**Donor (`tblblooddonors`):** `admin_id`, `first_name`, `last_name`, `blood_type`, `birth_date`, `gender`, `address`, `status`
**Requirer (`tblrequirer`):** `admin_id`, `first_name`, `last_name`, `blood_type`, `required_date`, `units_needed`, `hospital`, `status`
**Contact query:** `admin_id` (optional), `name`, `email`, `subject`, `message`, `status`
**Page:** `admin_id`, `page_title`, `page_slug`, `page_content`
**Contact info:** `blooddonor_id`, `requirer_id`, `phone`, `email`, `contact_person`

`admin_id` on donor/requirer rows is auto-filled by `defaultAdminId()` in
their controllers — it's a data-ownership tag, not a login account, so
you don't need to create an admin manually before testing donor/requirer
forms.
