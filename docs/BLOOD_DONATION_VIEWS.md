# Blood Donation — Blade files to create tomorrow

Controllers + routes are ready. Create these views under `resources/views/blood/`.

## Folder

```bash
mkdir -p resources/views/blood
```

## Files to create

| Blade file | Route (GET form) | POST action | Variables from controller |
|------------|------------------|-------------|---------------------------|
| `admin-form.blade.php` | `/blood/admin` | `route('blood.admin.store')` | — |
| `donor-form.blade.php` | `/blood/donor` | `route('blood.donor.store')` | `$admins` |
| `requirer-form.blade.php` | `/blood/requirer` | `route('blood.requirer.store')` | `$admins` |
| `contact-query-form.blade.php` | `/blood/contact-query` | `route('blood.contact-query.store')` | `$admins` |
| `page-form.blade.php` | `/blood/page` | `route('blood.page.store')` | `$admins` |
| `contact-info-form.blade.php` | `/blood/contact-info` | `route('blood.contact-info.store')` | `$donors`, `$requirers` |

## Minimal form pattern

```blade
@if(session('success'))
  <p>{{ session('success') }}</p>
@endif

<form method="POST" action="{{ route('blood.admin.store') }}">
  @csrf
  {{-- inputs with name="..." matching validation --}}
  <button type="submit">Save</button>
</form>
```

## Field names (must match)

**Admin:** `name`, `email`, `password`  
**Donor:** `admin_id`, `first_name`, `last_name`, `blood_type`, `birth_date`, `gender`, `address`, `status`  
**Requirer:** `admin_id`, `first_name`, `last_name`, `blood_type`, `required_date`, `units_needed`, `hospital`, `status`  
**Contact query:** `admin_id` (optional), `name`, `email`, `subject`, `message`, `status`  
**Page:** `admin_id`, `page_title`, `page_slug`, `page_content`  
**Contact info:** `blooddonor_id`, `requirer_id`, `phone`, `email`, `contact_person`  

## Order to test

1. Create **admin** first (`/blood/admin`) — donors/requirers need `admin_id`  
2. Then donor / requirer  
3. Then contact-info / pages / contact-query  

Check rows in phpMyAdmin after each submit.
