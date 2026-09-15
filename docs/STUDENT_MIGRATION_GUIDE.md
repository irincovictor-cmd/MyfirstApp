# Student + Student Details — full beginner guide (Laravel)

This guide explains **migrations, models, relationships, and the student / student-details feature** in **MyfirstApp**, as if you are new to Laravel.

Use it to **study for midterm** (migrations, models, foreign keys) and to **rebuild the same idea**.

Repo: https://github.com/irincovictor-cmd/MyfirstApp  
Local (Docker): http://localhost:8000/student  and  http://localhost:8000/student-details

---

## Table of contents

1. [What is Laravel, in simple words?](#1-what-is-laravel-in-simple-words)
2. [What midterm topics this covers](#2-what-midterm-topics-this-covers)
3. [Why two tables (Student vs Student Details)?](#3-why-two-tables-student-vs-student-details)
4. [Project layout](#4-project-layout)
5. [What is a migration?](#5-what-is-a-migration)
6. [Step 1 — Migration for `students`](#6-step-1--migration-for-students)
7. [Step 2 — Migration for `studentdetails`](#7-step-2--migration-for-studentdetails)
8. [How to run migrations](#8-how-to-run-migrations)
9. [What is a model?](#9-what-is-a-model)
10. [Step 3 — Student model](#10-step-3--student-model)
11. [Step 4 — StudentDetail model](#11-step-4--studentdetail-model)
12. [Relationships (hasOne / belongsTo)](#12-relationships-hasone--belongsto)
13. [Step 5 — Controllers](#13-step-5--controllers)
14. [Step 6 — Routes](#14-step-6--routes)
15. [Step 7 — Blade views (forms)](#15-step-7--blade-views-forms)
16. [Full request walk-through](#16-full-request-walk-through)
17. [Unique constraint & updateOrCreate](#17-unique-constraint--updateorcreate)
18. [Database connection (MySQL vs SQLite)](#18-database-connection-mysql-vs-sqlite)
19. [Common errors](#19-common-errors)
20. [Commands cheat sheet](#20-commands-cheat-sheet)
21. [Minimal code you can copy](#21-minimal-code-you-can-copy)
22. [Oral defense one-liners](#22-oral-defense-one-liners)
23. [Laravel vs Django (quick map)](#23-laravel-vs-django-quick-map)

---

## 1. What is Laravel, in simple words?

**Laravel** is a **PHP web framework**.  
It helps you build websites with structure instead of raw PHP files only.

| Everyday idea | Laravel |
|---------------|--------|
| Address of a page | **Route** (`routes/web.php`) |
| What happens when you open it | **Controller** |
| Database table description | **Model** + **Migration** |
| HTML page | **Blade** view (`.blade.php`) |

### Typical flow

```text
Browser → Route → Controller → Model/DB → Blade view → Browser
```

---

## 2. What midterm topics this covers

| Topic | Where in this feature |
|-------|------------------------|
| **Migrations** | Create `students` and `studentdetails` tables |
| **Models** | `Student`, `StudentDetail` |
| **Fillable** | Mass assignment safety |
| **Foreign key** | `student_id` → `students.id` |
| **Relationships** | `hasOne` / `belongsTo` |
| **Validation** | `required`, `integer`, `exists` |
| **CRUD-ish** | Create student, create/update details, delete in admin |
| **Cascade delete** | Deleting student removes details |

---

## 3. Why two tables (Student vs Student Details)?

This is on purpose for learning **related data**.

| Page | Table | Columns |
|------|--------|--------|
| `/student` | `students` | name, course, age |
| `/student-details` | `studentdetails` | student_id, address, contact |

**Flow:**

1. First save a **Student** (who they are).  
2. Then save **Details** linked to that student’s **id**.  

You cannot attach address/contact without choosing an existing student (dropdown).

```text
students                     studentdetails
---------                    --------------
id  ◄────────────────────── student_id  (unique FK)
name                         address
course                       contact
age
```

**One student → at most one details row** (`student_id` is **unique**).

---

## 4. Project layout

```text
MyfirstApp/
├── app/
│   ├── Models/
│   │   ├── Student.php
│   │   └── StudentDetail.php
│   └── Http/Controllers/
│       ├── StudentController.php
│       ├── StudentDetailController.php
│       └── AdminController.php
├── database/migrations/
│   ├── 2026_08_26_014638_create_students_table.php
│   └── 2026_09_14_000001_create_studentdetails_table.php
├── resources/views/
│   ├── student.blade.php
│   ├── student-details.blade.php
│   └── admin/
├── routes/web.php
└── docs/
    ├── STUDENT_DB_AND_DEBUGGING.md
    └── STUDENT_MIGRATION_GUIDE.md   ← this file
```

Docker compose for this machine often lives in **`~/project2/docker-compose.yml`** (parent folder), not inside the app folder.

---

## 5. What is a migration?

A **migration** is a PHP file that tells Laravel **how to build or change database tables**.

Why not only edit the database by hand?

- Your code and DB stay in sync  
- Teammates can run the same `php artisan migrate`  
- You can undo with `migrate:rollback` (when written well)  

### Two methods inside every migration

| Method | When it runs | Job |
|--------|----------------|-----|
| `up()` | `php artisan migrate` | Create/change tables |
| `down()` | `php artisan migrate:rollback` | Undo those changes |

### File name meaning

```text
2026_09_14_000001_create_studentdetails_table.php
│         │       │
│         │       └─ description
│         └─ order / sequence
└─ date
```

Laravel runs migrations **in order** of the filename timestamp.

**Important:**  
Editing `models` alone does **not** change the database.  
You need a migration + `migrate` (unlike forgetting migrate in Django — same idea).

---

## 6. Step 1 — Migration for `students`

File: `database/migrations/2026_08_26_014638_create_students_table.php`

```php
Schema::create('students', function (Blueprint $table) {
    $table->id();              // primary key: id
    $table->string('name');    // VARCHAR
    $table->string('course');
    $table->integer('age');
    $table->timestamps();      // created_at, updated_at
});
```

### What each line means

| Code | Meaning |
|------|--------|
| `Schema::create('students', ...)` | Create table named `students` |
| `$table->id()` | Big integer primary key `id`, auto-increment |
| `$table->string('name')` | Text column |
| `$table->integer('age')` | Whole number |
| `$table->timestamps()` | `created_at` and `updated_at` |

`down()` drops the table if you roll back:

```php
Schema::dropIfExists('students');
```

---

## 7. Step 2 — Migration for `studentdetails`

File: `database/migrations/2026_09_14_000001_create_studentdetails_table.php`

```php
Schema::create('studentdetails', function (Blueprint $table) {
    $table->id();
    $table->foreignId('student_id')
        ->unique()
        ->constrained('students')
        ->onDelete('cascade');
    $table->string('address');
    $table->string('contact');
    $table->timestamps();
});
```

### Foreign key explained slowly

| Piece | Meaning |
|-------|--------|
| `foreignId('student_id')` | Column that stores a student’s `id` |
| `unique()` | Only **one** details row per student |
| `constrained('students')` | Must match an existing `students.id` |
| `onDelete('cascade')` | If student is deleted, this details row is deleted too |

If you try to insert `student_id = 99` and no student 99 exists → database **rejects** it.

If you try to insert a **second** details row for the same student → **Duplicate entry** error (unless you update instead of insert).

---

## 8. How to run migrations

### On the host (WSL)

```bash
cd ~/project2/myFirstApp
php artisan migrate
```

### Inside Docker (what we used for localhost:8000)

```bash
docker exec -it laravel_php php artisan migrate
```

### Wipe and rebuild tables (destroys data)

```bash
docker exec -it laravel_php php artisan migrate:fresh
```

### Useful checks

```bash
php artisan migrate:status
```

Shows which migrations already ran.

### Order matters

`students` must exist **before** `studentdetails`, because of the foreign key.  
Our filenames are ordered so that happens automatically.

---

## 9. What is a model?

A **model** is a PHP class that represents a table so you can write:

```php
Student::create([...]);
Student::all();
$student->delete();
```

instead of raw SQL every time.

Laravel’s ORM is called **Eloquent**.

| Model | Table (default) |
|-------|------------------|
| `Student` | `students` (plural, snake) |
| `StudentDetail` | would default to `student_details`, but we set `studentdetails` |

---

## 10. Step 3 — Student model

File: `app/Models/Student.php`

```php
class Student extends Model
{
    protected $fillable = [
        'name',
        'course',
        'age',
    ];

    public function detail(): HasOne
    {
        return $this->hasOne(StudentDetail::class);
    }
}
```

### `$fillable`

Lists columns allowed in `Student::create([...])` or `update([...])`.

**Why?** Security — blocks unexpected fields from mass assignment.

If a column is not in `$fillable`, `create()` will ignore it (or fail depending on setup).

---

## 11. Step 4 — StudentDetail model

File: `app/Models/StudentDetail.php`

```php
class StudentDetail extends Model
{
    protected $table = 'studentdetails';

    protected $fillable = [
        'student_id',
        'address',
        'contact',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
```

### Why `protected $table = 'studentdetails'`?

Eloquent would guess `student_details`.  
Our migration created **`studentdetails`** (no underscore), so we set the name explicitly.

---

## 12. Relationships (hasOne / belongsTo)

| From | Method | Meaning |
|------|--------|--------|
| Student | `hasOne(StudentDetail::class)` | This student may have one detail row |
| StudentDetail | `belongsTo(Student::class)` | This detail belongs to one student |

### Usage examples

```php
$student = Student::with('detail')->find(1);
$student->detail->address;   // if detail exists

$detail = StudentDetail::with('student')->first();
$detail->student->name;
```

Admin list uses `Student::with('detail')` so address/contact load efficiently.

---

## 13. Step 5 — Controllers

### StudentController — create + store

```php
public function create()
{
    return view('student');
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'course' => 'required',
        'age' => 'required|integer',
    ]);

    Student::create([
        'name' => $request->name,
        'course' => $request->course,
        'age' => $request->age,
    ]);

    return redirect('/student')
        ->with('success', 'Student added successfully!');
}
```

| Part | Meaning |
|------|--------|
| `validate` | Stop and show errors if rules fail |
| `Student::create` | INSERT row (uses `$fillable`) |
| `redirect()->with('success', ...)` | Flash message for next page |

### StudentDetailController — create + store

```php
public function create()
{
    $students = Student::all();
    return view('student-details', compact('students'));
}

public function store(Request $request)
{
    $request->validate([
        'student_id' => 'required|exists:students,id',
        'address' => 'required',
        'contact' => 'required',
    ]);

    StudentDetail::updateOrCreate(
        ['student_id' => $request->student_id],
        [
            'address' => $request->address,
            'contact' => $request->contact,
        ]
    );

    return redirect('/student-details')
        ->with('success', 'Student details saved successfully!');
}
```

| Rule | Meaning |
|------|--------|
| `exists:students,id` | `student_id` must already be in `students` |
| `updateOrCreate` | Insert if new; **update** if that student already has details |

---

## 14. Step 6 — Routes

In `routes/web.php`:

```php
Route::get('/student', [StudentController::class, 'create']);
Route::post('/student', [StudentController::class, 'store']);

Route::get('/student-details', [StudentDetailController::class, 'create']);
Route::post('/student-details', [StudentDetailController::class, 'store']);
```

| HTTP method | When |
|-------------|------|
| **GET** | Show the form |
| **POST** | Submit the form |

Blade forms must use `method="POST"` and `@csrf`.

---

## 15. Step 7 — Blade views (forms)

### CSRF

```blade
@csrf
```

Required on POST forms or Laravel rejects the request (similar idea to Django’s csrf_token).

### Student form fields

- `name`, `course`, `age` — match columns + `$fillable`

### Student details form

- `<select name="student_id">` options from `$students`  
- `address`, `contact`  

**Must have `name="student_id"` on the select** or the server never receives the chosen id.

### Flash success

```blade
@if (session('success'))
    <div>{{ session('success') }}</div>
@endif
```

---

## 16. Full request walk-through

### Add student

```text
GET  /student
  → StudentController@create
  → student.blade.php

POST /student  (name, course, age + _token)
  → validate
  → Student::create → row in `students`
  → redirect /student + success message
```

### Add details

```text
GET  /student-details
  → Student::all() for dropdown
  → student-details.blade.php

POST /student-details  (student_id, address, contact)
  → validate exists:students,id
  → updateOrCreate on studentdetails
  → redirect + success
```

### Delete (admin)

```text
DELETE /admin/students/{id}
  → $student->delete()
  → details removed by ON DELETE CASCADE
```

---

## 17. Unique constraint & updateOrCreate

If you only use `StudentDetail::create(...)` twice for the same student:

```text
SQLSTATE[23000]: Duplicate entry '1' for key 'studentdetails_student_id_unique'
```

That is the database enforcing **one details row per student**.

**Fix we use:**

```php
StudentDetail::updateOrCreate(
    ['student_id' => $request->student_id],  // search key
    ['address' => ..., 'contact' => ...]     // values to set
);
```

---

## 18. Database connection (MySQL vs SQLite)

On your machine:

- Browser **http://localhost:8000** → Docker (`laravel_nginx` + `laravel_php`)  
- `.env` should use MySQL for that stack, for example:

```env
DB_CONNECTION=mysql
DB_HOST=laravel_mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=secret
```

**phpMyAdmin:** http://localhost:8080  
Open the **same** database name as `DB_DATABASE` or you will not see new rows.

(We once looked at `myFirstApp` while the app wrote to `laravel` — different databases.)

Migrate **inside** the container so the DB the app uses gets the tables:

```bash
docker exec -it laravel_php php artisan migrate
```

---

## 19. Common errors

| Error | Cause | Fix |
|-------|--------|-----|
| `no such table: students` | Migrations not run on this DB | `php artisan migrate` in the right environment |
| `Duplicate entry ... student_id_unique` | Second insert for same student | Use `updateOrCreate` |
| `readonly database` (SQLite) | Wrong server / permissions | Prefer MySQL in Docker; don’t mix ports 8000 vs 8001 |
| Data not in phpMyAdmin | Wrong database selected | Match `DB_DATABASE` |
| 404 on `/admin` | Code not pulled / route cache | `git pull`, `route:clear` |
| Mass assignment exception | Column not in `$fillable` | Add to `$fillable` |
| Foreign key fails | Details before student exists | Create student first |

---

## 20. Commands cheat sheet

```bash
cd ~/project2/myFirstApp
git pull origin main

# Docker PHP (recommended for :8000)
docker exec -it laravel_php php artisan migrate
docker exec -it laravel_php php artisan migrate:fresh
docker exec -it laravel_php php artisan migrate:status
docker exec -it laravel_php php artisan route:clear
docker exec -it laravel_php php artisan config:clear
```

URLs:

- http://localhost:8000/student  
- http://localhost:8000/student-details  
- http://localhost:8000/admin  (password protected)  
- http://localhost:8080  (phpMyAdmin)  

---

## 21. Minimal code you can copy

### Migration students

```php
Schema::create('students', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('course');
    $table->integer('age');
    $table->timestamps();
});
```

### Migration studentdetails

```php
Schema::create('studentdetails', function (Blueprint $table) {
    $table->id();
    $table->foreignId('student_id')->unique()
          ->constrained('students')->onDelete('cascade');
    $table->string('address');
    $table->string('contact');
    $table->timestamps();
});
```

### Models (short)

```php
// Student
protected $fillable = ['name', 'course', 'age'];
public function detail() { return $this->hasOne(StudentDetail::class); }

// StudentDetail
protected $table = 'studentdetails';
protected $fillable = ['student_id', 'address', 'contact'];
public function student() { return $this->belongsTo(Student::class); }
```

Then: **migrate → routes → controllers → blade → test.**

---

## 22. Oral defense one-liners

**What is a migration?**  
“A versioned PHP script that creates or changes database tables with `php artisan migrate`.”

**What is a model?**  
“An Eloquent class that represents a table so we can create and query rows in PHP.”

**What is `$fillable`?**  
“The list of columns allowed for mass assignment like `Model::create()`.”

**What is a foreign key here?**  
“`student_id` points to `students.id` so details always belong to a real student.”

**What does `onDelete('cascade')` do?**  
“Deleting a student also deletes their details row.”

**Why two forms?**  
“To practice related tables: identity first, then linked contact info.”

**Why `updateOrCreate`?**  
“Because `student_id` is unique — we update if details already exist instead of crashing.”

---

## 23. Laravel vs Django (quick map)

| Idea | Laravel (this project) | Django (LearnHub contact) |
|------|------------------------|---------------------------|
| Table plan | Migration file | Migration after model |
| Table class | Eloquent Model | Model |
| Save form | `Model::create` / `updateOrCreate` | `ModelForm.save()` |
| Page logic | Controller | View function |
| HTML | Blade | Template |
| CSRF | `@csrf` | `{% csrf_token %}` |
| Admin | Custom `/admin` (+ phpMyAdmin) | Built-in `/admin/` |

Same **ideas**; different **names** and files.

---

## Final mental picture

```text
Migration  →  creates tables in MySQL
Model      →  talks to those tables in PHP
Controller →  validates + create/update
Route      →  URL → controller
Blade      →  form the user sees
```

**Student** = base row.  
**Student details** = related row with **foreign key**.  
**Migrate** = make the tables real before you save data.

---

*Written for BSIT study / midterm (migrations & models). Matches MyfirstApp student + student-details feature.*
