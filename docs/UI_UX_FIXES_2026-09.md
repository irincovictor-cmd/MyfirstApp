# UI/UX & QA fixes — 2026-09

This documents every change made in this pass, following up on the QA
review and BloodLink UI review earlier in the project history. Read this
before touching the files below — it explains *why* things are the way
they are now, not just what changed.

## ⚠️ Action required after pulling these changes

**Add `ADMIN_PASSWORD` to your real `.env` file** (not `.env.example` —
that one is just a template and is already updated). The admin login
(`/admin/login`) used to silently fall back to a hardcoded `admin123`
if this was missing. That fallback is now removed — if `ADMIN_PASSWORD`
isn't set, login will throw a `500` error on purpose (fail closed,
not fail open). Without this, **both** `/admin/students` and the new
`/blood/admin` dashboard will be unreachable.

```
# in your real .env
ADMIN_PASSWORD=choose-something-here
```

Then, if running via Docker:
```bash
docker compose restart php
```

---

## 1. Deleted dead code: `resources/views/blood/` (11 files)

This entire folder — including `blood/layout.blade.php`,
`blood/donors.blade.php`, `blood/home.blade.php`, etc. — was **never
routed to**. Every controller actually renders views from
`blood-donors/`, `blood-request/`, `requirers/`, `pages/`,
`contact-queries/`, `contact-info/`, and `admin/`, all extending
`resources/views/layouts/blood.blade.php`.

This was a real risk: editing `resources/views/blood/donors.blade.php`
(the dead one) would have looked like it worked in a text editor but
produced zero visible change on the actual site — the same class of
mix-up we already hit once with the Django project's Windows-path
duplicate folder.

**If you were mid-edit on anything in `resources/views/blood/`, that
work needs to be redone in the corresponding live file** — see the
table in `BLOOD_DONATION_VIEWS.md` for the mapping.

Also deleted: `resources/views/studentDetails.blade.php` (unrelated,
orphaned duplicate of `student-details.blade.php`, confirmed unreferenced
by any controller or route before deletion).

## 2. Admin auth hardening

**Files:** `app/Http/Controllers/AdminController.php`, `config/app.php`,
`routes/web.php`

- `AdminController::login()` no longer defaults to `admin123` when
  `ADMIN_PASSWORD` is unset — it now aborts with a clear 500 instead of
  silently accepting a known password. See "Action required" above.
- The password is now read via `config('app.admin_password')`
  (defined in `config/app.php`) instead of calling `env()` directly in
  the controller. This matters because `env()` returns `null` once
  `php artisan config:cache` runs — calling it outside `config/` files
  is a known Laravel foot-gun.
- `session()->regenerate()` now runs **before** setting
  `admin_logged_in`, closing a narrow session-fixation window.
- `POST /admin/login` is now throttled (`throttle:5,1` — 5 attempts per
  minute) to prevent brute-forcing the shared password.

## 3. BloodLink admin dashboard is no longer public

**File:** `routes/web.php`

`/blood/admin`, `/blood/admin/register` (GET + POST) are now wrapped in
the same `->middleware('admin')` group used by the Student panel. This
was previously **fully open** — anyone could view donor/request/message
data and register new admin rows without logging in. It now shares the
one login at `/admin/login` (see item 2). Logging in there unlocks both
`/admin/students` and `/blood/admin`.

This also fixes a UI issue: the "Admin" nav link is styled as the most
visually prominent button in the header on every BloodLink page — it
now actually leads somewhere gated, instead of being the loudest CTA
on a public site pointing at an open admin panel.

## 4. Blood-type filter (Donors + Requests)

**Files:** `app/Http/Controllers/BloodDonorController.php`,
`app/Http/Controllers/RequirerController.php`,
`resources/views/blood-donors/index.blade.php`,
`resources/views/blood-request/index.blade.php`

Both list pages now have a `<select>` filter (`?blood_type=O-`, etc.)
that submits on change. This was the biggest functional gap in the
original UI review: blood-type matching is the actual point of the
site, and there was previously no way to narrow either list by type.
Empty states now say "No {type} donors yet" when a filter returns
nothing, with a "Clear filter" link.

## 5. Pagination (Donors + Requests)

**Files:** same as above, plus new
`resources/views/vendor/pagination/custom.blade.php`

Both lists used `->get()` with no limit — every row rendered on one
page, with no ceiling. Both now use `->paginate(10)->withQueryString()`
(the `withQueryString()` keeps the blood-type filter active across
pages). The pagination partial is custom-written to match this app's
own CSS (`.btn`, `.btn-ghost`) rather than Laravel's default Tailwind
pagination views, since this project doesn't load Tailwind.

## 6. Urgency sorting + badge (Requests only)

**Files:** `app/Http/Controllers/RequirerController.php`,
`resources/views/blood-request/index.blade.php`

Requests are now ordered by `required_date` ascending (soonest need
first; rows with no date sort last), via:
```php
->orderByRaw('required_date IS NULL, required_date ASC')
```
Any request due within 2 days (or already overdue) gets a red
"Urgent" badge next to its date. Previously every request looked
equally weighted regardless of how soon it was needed — for a blood
request list specifically, that's the one piece of information that
should visually stand out.

Note: the day-difference math uses plain `strtotime()` arithmetic
rather than Carbon's `diffInDays()`, deliberately — Carbon's sign
convention for `diffInDays($other, false)` isn't something we could
verify without a live PHP runtime while writing this, so `strtotime()`
was used to avoid shipping an unverified sign bug.

## 7. Mobile scroll hint

**Files:** both index views + `layouts/blood.blade.php` (new
`.scroll-hint` CSS, visible only under 640px)

Tables already scrolled horizontally on narrow screens
(`overflow-x: auto`), but nothing indicated that extra columns existed
off-screen. A small "Swipe left/right to see more columns →" hint now
appears above each table on mobile only.

## Not included in this pass (still open)

From the earlier full QA review, these are unrelated to BloodLink and
were left alone to keep this change set focused:
- Django project: `DEBUG=True`, `ALLOWED_HOSTS=['*']`, committed
  `SECRET_KEY`, unused Postgres container, unpinned `requirements.txt`.
- Laravel: no automated test coverage beyond the default
  `ExampleTest.php` stubs; `OperatorController`'s loose `==` zero-check.

Ask for these explicitly if you want them addressed next.
