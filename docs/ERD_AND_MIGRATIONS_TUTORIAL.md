# Full tutorial: ERD → Laravel migrations

A beginner guide to **designing an ERD** and **turning it into Laravel migrations**.

Uses the **MyfirstApp** student feature as the main example.

---

## Table of contents

1. [What is an ERD?](#1-what-is-an-erd)
2. [Why ERD before coding?](#2-why-erd-before-coding)
3. [ERD building blocks](#3-erd-building-blocks)
4. [Cardinality (how many related rows)](#4-cardinality-how-many-related-rows)
5. [Step-by-step: design an ERD](#5-step-by-step-design-an-erd)
6. [Example ERD: Student system](#6-example-erd-student-system)
7. [Translate ERD → Laravel tables](#7-translate-erd--laravel-tables)
8. [Create migration files](#8-create-migration-files)
9. [Write the migrations](#9-write-the-migrations)
10. [Foreign keys in plain English](#10-foreign-keys-in-plain-english)
11. [Run migrations](#11-run-migrations)
12. [Models after the ERD](#12-models-after-the-erd)
13. [Bigger example (optional)](#13-bigger-example-optional)
14. [Drawing tools for ERD](#14-drawing-tools-for-erd)
15. [Checklist for midterm](#15-checklist-for-midterm)
16. [Common mistakes](#16-common-mistakes)
17. [Oral defense lines](#17-oral-defense-lines)

---

## 1. What is an ERD?

**ERD** = **Entity Relationship Diagram**.

It is a **picture (or clear sketch)** of:

- **Entities** → things you store (Student, Course, Order…)
- **Attributes** → details of each thing (name, age, email…)
- **Relationships** → how things connect (a student **has** details)

It is **not** PHP code yet. It is the **plan** for your database.

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

**PK** = Primary Key (unique id of a row)  
**FK** = Foreign Key (points to another table’s PK)

---

## 2. Why ERD before coding?

| Without ERD | With ERD |
|-------------|----------|
| Guess columns while coding | Clear list of tables/columns |
| Forget relationships | Foreign keys planned |
| Hard to explain to teacher | Easy to show on paper/slide |
| Messy migrations | Migrations match the diagram |

**Order good students use:**

```text
1. Understand the problem
2. Draw ERD
3. Write migrations
4. Write models
5. Write controllers / forms
```

---

## 3. ERD building blocks

### Entity

A **noun** you care about: `Student`, `Product`, `Teacher`.

In Laravel this becomes a **table** (usually plural): `students`.

### Attribute

A **property** of an entity: `name`, `email`, `age`.

In Laravel this becomes a **column**.

### Primary key

Unique id for each row. In Laravel almost always:

```php
$table->id();   // column name: id
```

### Relationship

A line between entities, e.g. “Student has one StudentDetail”.

### Foreign key

A column that **stores the other table’s id**, e.g. `student_id`.

---

## 4. Cardinality (how many related rows)

| Name | Meaning | Example |
|------|---------|--------|
| **One-to-one (1:1)** | One A ↔ one B | One student ↔ one detail record |
| **One-to-many (1:N)** | One A ↔ many B | One student ↔ many grades |
| **Many-to-many (M:N)** | Many A ↔ many B | Students ↔ Subjects (needs pivot table) |

Our MyfirstApp student feature is **1:1**:

- one `students` row  
- at most one `studentdetails` row (because `student_id` is **unique**)

---

## 5. Step-by-step: design an ERD

### Step A — Read the requirement

Example requirement:

> Save student name, course, and age.  
> Later save address and contact for that student.

### Step B — List entities

- Student  
- StudentDetail (or “ContactInfo”)

### Step C — List attributes

**Student:** name, course, age  
**StudentDetail:** address, contact  

(Plus system fields: `id`, `created_at`, `updated_at`)

### Step D — Decide relationships

- Details belong to one student  
- One student has one details row → **1:1**  

### Step E — Mark keys

- Student: `id` PK  
- StudentDetail: `id` PK, `student_id` FK → Student.id  

### Step F — Draw boxes and lines

Paper, whiteboard, draw.io, dbdiagram.io — any is fine for class.

---

## 6. Example ERD: Student system

### Text ERD

```text
ENTITY Student
  - id          (PK)
  - name        (string)
  - course      (string)
  - age         (integer)
  - created_at
  - updated_at

ENTITY StudentDetail
  - id          (PK)
  - student_id  (FK → Student.id, UNIQUE)
  - address     (string)
  - contact     (string)
  - created_at
  - updated_at

RELATIONSHIP
  Student (1) ---- (1) StudentDetail
  "A student has one detail; a detail belongs to one student"
```

### ASCII diagram

```text
          1                    1
   students ──────────────── studentdetails
   +------------+            +----------------+
   | id (PK)    |◄───────────| student_id (FK)| UNIQUE
   | name       |            | address        |
   | course     |            | contact        |
   | age        |            | id (PK)        |
   +------------+            +----------------+
```

---

## 7. Translate ERD → Laravel tables

| ERD idea | Laravel |
|----------|--------|
| Entity Student | Table `students` |
| Attribute name | `$table->string('name')` |
| PK | `$table->id()` |
| FK student_id | `$table->foreignId('student_id')->constrained(...)` |
| 1:1 | FK + `->unique()` on `student_id` |
| 1:N | FK **without** unique on the “many” side |
| Timestamps | `$table->timestamps()` |

### Naming rules (Laravel habits)

| Thing | Convention |
|-------|------------|
| Table | plural snake: `students` |
| Model | singular Studly: `Student` |
| FK | `{model}_id` → `student_id` |

Our details table is named **`studentdetails`** (course style). Eloquent default would be `student_details`, so the model sets `protected $table = 'studentdetails'`.

---

## 8. Create migration files

From the project folder:

```bash
php artisan make:migration create_students_table
php artisan make:migration create_studentdetails_table
```

Or inside Docker:

```bash
docker exec -it laravel_php php artisan make:migration create_students_table
docker exec -it laravel_php php artisan make:migration create_studentdetails_table
```

Laravel creates files under `database/migrations/` with a **timestamp** so order is clear.

**Rule:** parent table migration must run **before** child table (students before studentdetails).

---

## 9. Write the migrations

### 9.1 Students (parent entity)

```php
public function up(): void
{
    Schema::create('students', function (Blueprint $table) {
        $table->id();                 // PK
        $table->string('name');       // attribute
        $table->string('course');
        $table->integer('age');
        $table->timestamps();         // created_at, updated_at
    });
}

public function down(): void
{
    Schema::dropIfExists('students');
}
```

### 9.2 Student details (child entity + relationship)

```php
public function up(): void
{
    Schema::create('studentdetails', function (Blueprint $table) {
        $table->id();

        // Relationship from ERD: FK to students, 1:1 → unique
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
```

### Map ERD line → code

| ERD | Migration code |
|-----|----------------|
| student_id points to Student | `foreignId('student_id')->constrained('students')` |
| only one detail per student | `->unique()` |
| delete student → remove detail | `->onDelete('cascade')` |

---

## 10. Foreign keys in plain English

```php
$table->foreignId('student_id')
    ->unique()
    ->constrained('students')
    ->onDelete('cascade');
```

| Part | Meaning |
|------|--------|
| `foreignId('student_id')` | Column that holds a student’s id |
| `constrained('students')` | Must match `students.id` |
| `unique()` | No two details rows share the same student |
| `onDelete('cascade')` | If student is deleted, this row is deleted too |

Without the FK, the database would allow “orphan” details pointing at missing students.

---

## 11. Run migrations

```bash
# apply all pending migrations
php artisan migrate

# Docker
docker exec -it laravel_php php artisan migrate

# see status
php artisan migrate:status

# WARNING: deletes all tables then re-runs migrations
php artisan migrate:fresh
```

After migrate, check with:

- **phpMyAdmin** (http://localhost:8080)  
- or `php artisan tinker` → `Schema::hasTable('students')`  

---

## 12. Models after the ERD

Migrations create **tables**. Models are how **PHP** uses them.

### Student

```php
class Student extends Model
{
    protected $fillable = ['name', 'course', 'age'];

    public function detail()
    {
        return $this->hasOne(StudentDetail::class);
    }
}
```

### StudentDetail

```php
class StudentDetail extends Model
{
    protected $table = 'studentdetails';

    protected $fillable = ['student_id', 'address', 'contact'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
```

| ERD relationship | Eloquent |
|------------------|----------|
| Student has one Detail | `hasOne(StudentDetail::class)` |
| Detail belongs to Student | `belongsTo(Student::class)` |

---

## 13. Bigger example (optional)

Requirement: students enroll in many subjects.

### ERD sketch

```text
Student (1) ─── (N) Enrollment (N) ─── (1) Subject
```

Or many-to-many with pivot `enrollments`:

```text
students  M ─── N  subjects
         via enrollments
         (student_id, subject_id)
```

### Pivot migration idea

```php
Schema::create('enrollments', function (Blueprint $table) {
    $table->id();
    $table->foreignId('student_id')->constrained()->onDelete('cascade');
    $table->foreignId('subject_id')->constrained()->onDelete('cascade');
    $table->timestamps();

    $table->unique(['student_id', 'subject_id']); // same pair once
});
```

That is still the same process: **ERD first → migrations second**.

---

## 14. Drawing tools for ERD

You do **not** need Laravel to draw the ERD.

| Tool | Notes |
|------|--------|
| Paper / whiteboard | Fast for exams |
| [dbdiagram.io](https://dbdiagram.io) | Type tables, get diagram |
| draw.io / diagrams.net | Free boxes and arrows |
| Lucidchart | Polished, often school accounts |
| MySQL Workbench | Can reverse-engineer from DB after migrate |

For midterm, a **clear hand-drawn ERD** is usually enough if labels (PK/FK/1:1) are correct.

### Optional: dbdiagram syntax for our example

```text
Table students {
  id int [pk, increment]
  name varchar
  course varchar
  age int
  created_at datetime
  updated_at datetime
}

Table studentdetails {
  id int [pk, increment]
  student_id int [unique, ref: - students.id]
  address varchar
  contact varchar
  created_at datetime
  updated_at datetime
}
```

---

## 15. Checklist for midterm

- [ ] Entities listed from the problem statement  
- [ ] Attributes listed for each entity  
- [ ] PK marked on each entity  
- [ ] Relationships drawn with cardinality (1:1, 1:N, M:N)  
- [ ] FKs placed on the correct side  
- [ ] Migration for **parent** table first  
- [ ] Migration for **child** table with `foreignId` + `constrained`  
- [ ] 1:1 uses `unique()` on FK when required  
- [ ] `php artisan migrate` succeeds  
- [ ] Models + `$fillable` match columns  
- [ ] Relationships `hasOne` / `belongsTo` / `hasMany` match ERD  

---

## 16. Common mistakes

| Mistake | Problem |
|---------|--------|
| Migrate child before parent | Foreign key fails |
| Forget `constrained()` | Weak or missing FK |
| 1:1 without `unique()` on FK | Allows many details per student |
| Only create model, no migration | Table does not exist |
| Wrong table name in model | Queries hit missing table |
| Put FK on the wrong entity | Relationship inverted |
| `migrate:fresh` on production data | Data wiped |

---

## 17. Oral defense lines

**What is an ERD?**  
“A diagram of entities, attributes, and relationships that plans the database before we code.”

**How does an ERD connect to Laravel?**  
“Each entity becomes a table migration; relationships become foreign keys; models map to those tables.”

**What is a foreign key?**  
“A column that stores the primary key of another table to link rows.”

**Why migrate?**  
“Migrations create the real tables in MySQL so the app can insert and query data.”

**Why 1:1 with unique student_id?**  
“So each student can have only one details record, matching our ERD.”

---

## Final pipeline (memorize this)

```text
Problem story
    → ERD (entities, attributes, PK/FK, cardinality)
    → Migrations (Schema::create)
    → php artisan migrate
    → Models (fillable + relationships)
    → Controllers / forms use the models
```

**ERD is the map. Migrations build the roads. Models are the cars.**

---

## See also in this repo

- `docs/STUDENT_MIGRATION_GUIDE.md` — deeper student/details implementation  
- `docs/STUDENT_DB_AND_DEBUGGING.md` — Docker/MySQL debugging notes  
- Migrations: `database/migrations/2026_08_26_*` and `2026_09_14_*`  

---

*For BSIT study / midterm: ERD design and Laravel migrations.*
