# Full tutorial: ERD → Laravel migrations

A beginner guide to **designing an ERD** and **turning it into Laravel migrations**.

Uses the **MyfirstApp** student feature as the main example.

After migrate, you can verify everything in **phpMyAdmin**: http://localhost:8080  
(Select the same database as `.env` → `DB_DATABASE`, often `laravel`.)

---

## Table of contents

1. [What is an ERD?](#1-what-is-an-erd)
2. [Why ERD before coding?](#2-why-erd-before-coding)
3. [ERD building blocks](#3-erd-building-blocks)
4. [Cardinality](#4-cardinality-how-many-related-rows)
5. [Step-by-step: design an ERD](#5-step-by-step-design-an-erd)
6. [Example ERD: Student system](#6-example-erd-student-system)
7. [Complete schema reference (phpMyAdmin)](#7-complete-schema-reference-phpmyadmin)
8. [Translate ERD → Laravel tables](#8-translate-erd--laravel-tables)
9. [Create migration files](#9-create-migration-files)
10. [Write the migrations](#10-write-the-migrations)
11. [Foreign keys in plain English](#11-foreign-keys-in-plain-english)
12. [Run migrations](#12-run-migrations)
13. [How to check in phpMyAdmin](#13-how-to-check-in-phpmyadmin)
14. [Models after the ERD](#14-models-after-the-erd)
15. [Bigger example (optional)](#15-bigger-example-optional)
16. [Drawing tools for ERD](#16-drawing-tools-for-erd)
17. [Checklist for midterm](#17-checklist-for-midterm)
18. [Common mistakes](#18-common-mistakes)
19. [Oral defense lines](#19-oral-defense-lines)
20. [Copy-paste sample code + terminal commands](#20-copy-paste-sample-code--terminal-commands)

---

## 1. What is an ERD?

**ERD** = **Entity Relationship Diagram**.

It is a **picture (or clear sketch)** of:

- **Entities** → things you store (Student, Course, Order…)
- **Attributes** → details of each thing (name, age, email…)
- **Relationships** → how things connect (a student **has** details)

```text
┌─────────────┐         ┌──────────────────┐
│  STUDENT    │         │  STUDENT_DETAIL  │
├─────────────┤         ├──────────────────┤
│ id (PK)     │1───────1│ id (PK)          │
│ name        │         │ student_id (FK)  │
│ course      │         │ address          │
│ age         │         │ contact          │
└─────────────┘         └──────────────────┘
```

**PK** = Primary Key · **FK** = Foreign Key

---

## 2. Why ERD before coding?

```text
1. Understand the problem
2. Draw ERD
3. Write migrations
4. Write models
5. Write controllers / forms
6. Verify in phpMyAdmin
```

---

## 3. ERD building blocks

| Idea | Becomes in MySQL |
|------|------------------|
| Entity | Table |
| Attribute | Column + data type |
| Primary key | `id` PK |
| Foreign key | e.g. `student_id` |
| Relationship | FK (+ unique if 1:1) |

```php
$table->id();   // BIGINT UNSIGNED, AUTO_INCREMENT, PRIMARY KEY
```

---

## 4. Cardinality (how many related rows)

| Name | Meaning | Example |
|------|---------|--------|
| **1:1** | One A ↔ one B | Student ↔ StudentDetail |
| **1:N** | One A ↔ many B | Student ↔ many grades |
| **M:N** | Many A ↔ many B | Students ↔ Subjects (pivot) |

This project: **1:1** (`student_id` is UNIQUE).

---

## 5. Step-by-step: design an ERD

1. Read requirements  
2. List entities  
3. List attributes + types  
4. Decide 1:1 / 1:N / M:N  
5. Mark PK and FK  
6. Draw boxes and lines  

---

## 6. Example ERD: Student system

```text
ENTITY Student
  - id (PK), name, course, age, timestamps

ENTITY StudentDetail
  - id (PK), student_id (FK UNIQUE → Student.id), address, contact, timestamps

RELATIONSHIP: Student (1) ---- (1) StudentDetail
```

```text
   students 1──────────1 studentdetails
   id (PK)  ◄──────────  student_id (FK, UNIQUE)
```

---

## 7. Complete schema reference (phpMyAdmin)

> `$table->string()` → VARCHAR(255)  
> `$table->id()` / `foreignId()` → BIGINT UNSIGNED  
> `$table->integer()` → INT  
> `$table->timestamps()` → created_at, updated_at

### 7.1 Table: `students`

| Column | MySQL type (typical) | Null | Key | Extra | Description |
|--------|----------------------|------|-----|-------|-------------|
| `id` | BIGINT UNSIGNED | NO | **PRI** | auto_increment | Primary key |
| `name` | VARCHAR(255) | NO | | | Full name |
| `course` | VARCHAR(255) | NO | | | e.g. BSIT |
| `age` | INT | NO | | | Age |
| `created_at` | TIMESTAMP | YES | | | Created |
| `updated_at` | TIMESTAMP | YES | | | Updated |

**PK:** `id` · **FK:** none (parent table)

### 7.2 Table: `studentdetails`

| Column | MySQL type (typical) | Null | Key | Extra | Description |
|--------|----------------------|------|-----|-------|-------------|
| `id` | BIGINT UNSIGNED | NO | **PRI** | auto_increment | Primary key |
| `student_id` | BIGINT UNSIGNED | NO | **UNI + FK** | | → `students.id` |
| `address` | VARCHAR(255) | NO | | | Address |
| `contact` | VARCHAR(255) | NO | | | Phone |
| `created_at` | TIMESTAMP | YES | | | Created |
| `updated_at` | TIMESTAMP | YES | | | Updated |

**FK:** `student_id` → `students.id`  
**UNIQUE:** `student_id` (1:1)  
**ON DELETE:** CASCADE  

### 7.3 Relationship summary

| Item | Value |
|------|--------|
| Parent | `students` |
| Child | `studentdetails` |
| Type | **1:1** |
| FK column | `studentdetails.student_id` |
| References | `students.id` |
| Delete rule | CASCADE |

### 7.4 Sample linked rows

**students:** id=1, name=victor, course=bsit, age=21  
**studentdetails:** student_id=1, address=Tawala, contact=09…

---

## 8. Translate ERD → Laravel tables

| ERD | Migration | MySQL |
|-----|-----------|-------|
| Entity Student | `students` | table |
| name | `$table->string('name')` | VARCHAR(255) |
| PK | `$table->id()` | BIGINT PK |
| FK 1:1 | `foreignId` + `unique` | FK + UNIQUE |

---

## 9–11. Migrations & foreign keys

See **Section 20** for full copy-paste files and every command.

Core FK line:

```php
$table->foreignId('student_id')
    ->unique()
    ->constrained('students')
    ->onDelete('cascade');
```

---

## 12. Run migrations

```bash
php artisan migrate
# or Docker:
docker exec -it laravel_php php artisan migrate
```

---

## 13. How to check in phpMyAdmin

1. http://localhost:8080  
2. Open DB from `.env` (`DB_DATABASE`)  
3. `students` → Structure  
4. `studentdetails` → Structure + Indexes (UNIQUE + FOREIGN on `student_id`)  
5. Browse data after using forms  

---

## 14. Models after the ERD

See Section 20 for full model code (`$fillable`, `hasOne`, `belongsTo`).

---

## 15. Bigger example (optional M:N pivot)

```php
$table->foreignId('student_id')->constrained()->onDelete('cascade');
$table->foreignId('subject_id')->constrained()->onDelete('cascade');
$table->unique(['student_id', 'subject_id']);
```

---

## 16. Drawing tools

Paper · [dbdiagram.io](https://dbdiagram.io) · draw.io · phpMyAdmin Designer

---

## 17. Checklist for midterm

- [ ] Entities, columns, data types  
- [ ] PK / FK / cardinality  
- [ ] Migrations run  
- [ ] phpMyAdmin Structure matches section 7  

---

## 18. Common mistakes

Wrong DB in phpMyAdmin · child before parent · no `unique()` on 1:1 · migrate only on host while app uses Docker

---

## 19. Oral defense lines

“ERD plans tables. Migrations create them. `student_id` FK to `students.id` with UNIQUE makes 1:1. phpMyAdmin Structure verifies types and keys.”

---

## 20. Copy-paste sample code + terminal commands

Use this section when you recreate the feature on a midterm project.

### 20.1 Terminal — Docker stack (MyfirstApp style)

```bash
# Go to compose folder (parent of myFirstApp on your PC)
cd ~/project2
docker compose up -d

# Go to Laravel app
cd ~/project2/myFirstApp
git pull origin main

# Optional: see DB settings
grep DB_ .env

# Create migration files (only if starting from zero)
docker exec -it laravel_php php artisan make:migration create_students_table
docker exec -it laravel_php php artisan make:migration create_studentdetails_table

# After you paste migration code into those files:
docker exec -it laravel_php php artisan migrate

# Or rebuild all tables (WIPES DATA)
docker exec -it laravel_php php artisan migrate:fresh

# Check migration status
docker exec -it laravel_php php artisan migrate:status

# Clear caches if pages act weird
docker exec -it laravel_php php artisan config:clear
docker exec -it laravel_php php artisan route:clear
docker exec -it laravel_php php artisan view:clear
```

### 20.2 Terminal — without Docker (host PHP)

```bash
cd ~/project2/myFirstApp

php artisan make:migration create_students_table
php artisan make:migration create_studentdetails_table

# edit the migration files, then:
php artisan migrate
php artisan migrate:status
php artisan serve
```

### 20.3 Full migration — `students`

Path: `database/migrations/xxxx_create_students_table.php`  
(Replace `up` / `down` with this.)

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('course');
            $table->integer('age');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
```

### 20.4 Full migration — `studentdetails`

Path: `database/migrations/xxxx_create_studentdetails_table.php`  
(**Run after** students migration.)

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
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
    }

    public function down(): void
    {
        Schema::dropIfExists('studentdetails');
    }
};
```

### 20.5 Model — `app/Models/Student.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

### 20.6 Model — `app/Models/StudentDetail.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

### 20.7 Create model files via Artisan (optional)

```bash
docker exec -it laravel_php php artisan make:model Student
docker exec -it laravel_php php artisan make:model StudentDetail

# then paste fillable + relationships into the generated files
```

### 20.8 Minimal controller store examples

**Student**

```php
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
```

**StudentDetail**

```php
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
```

### 20.9 Minimal routes

```php
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentDetailController;

Route::get('/student', [StudentController::class, 'create']);
Route::post('/student', [StudentController::class, 'store']);

Route::get('/student-details', [StudentDetailController::class, 'create']);
Route::post('/student-details', [StudentDetailController::class, 'store']);
```

### 20.10 Minimal Blade form bits

```blade
<form method="POST" action="/student">
    @csrf
    <input name="name" required>
    <input name="course" required>
    <input name="age" type="number" required>
    <button type="submit">Save</button>
</form>
```

```blade
<form method="POST" action="/student-details">
    @csrf
    <select name="student_id" required>
        @foreach ($students as $student)
            <option value="{{ $student->id }}">{{ $student->name }}</option>
        @endforeach
    </select>
    <input name="address" required>
    <input name="contact" required>
    <button type="submit">Save</button>
</form>
```

### 20.11 Order of work (follow this)

```text
1. docker compose up -d
2. make:migration (students, then studentdetails)
3. Paste migration code
4. php artisan migrate   (inside laravel_php if Docker)
5. Create/paste models
6. Controllers + routes + blade
7. phpMyAdmin → Structure on both tables
8. Test /student and /student-details in browser
```

### 20.12 URLs to open

| What | URL |
|------|-----|
| Add student | http://localhost:8000/student |
| Add details | http://localhost:8000/student-details |
| phpMyAdmin | http://localhost:8080 |
| Admin (if enabled) | http://localhost:8000/admin |

---

## Final pipeline

```text
ERD → migration code → artisan migrate → phpMyAdmin check → models → forms
```

**ERD is the map. Migrations build the tables. phpMyAdmin proves columns, types, and FK.**

---

## See also

- `docs/STUDENT_MIGRATION_GUIDE.md`  
- `docs/STUDENT_DB_AND_DEBUGGING.md`  
- `database/migrations/2026_08_26_014638_create_students_table.php`  
- `database/migrations/2026_09_14_000001_create_studentdetails_table.php`  

---

*BSIT study / midterm: ERD, columns, types, FK, sample code, and commands.*
