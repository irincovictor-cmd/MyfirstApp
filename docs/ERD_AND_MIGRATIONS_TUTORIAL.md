# Full tutorial: ERD → Laravel migrations

> **Want to build first, theory later?**  
> Start here: **[`docs/BUILD_STUDENT_TABLES_FROM_ZERO.md`](BUILD_STUDENT_TABLES_FROM_ZERO.md)**  
> That file is command-first: start Docker → `make:migration` → paste code → `migrate` → phpMyAdmin.

This document is mainly **what ERD is**, **columns / types / FK**, and reference tables for phpMyAdmin.

Uses the **MyfirstApp** student feature as the main example.

phpMyAdmin: http://localhost:8080  
(Select the same database as `.env` → `DB_DATABASE`, often `laravel`.)

---

## Table of contents

0. [Quick start (commands only)](#0-quick-start-commands-only)
1. [What is an ERD?](#1-what-is-an-erd)
2. [Why ERD before coding?](#2-why-erd-before-coding)
3. [ERD building blocks](#3-erd-building-blocks)
4. [Cardinality](#4-cardinality-how-many-related-rows)
5. [Step-by-step: design an ERD](#5-step-by-step-design-an-erd)
6. [Example ERD: Student system](#6-example-erd-student-system)
7. [Complete schema reference (phpMyAdmin)](#7-complete-schema-reference-phpmyadmin)
8. [Translate ERD → Laravel tables](#8-translate-erd--laravel-tables)
9–19. Theory, checklist, oral defense (below)
20. [Copy-paste sample code + terminal commands](#20-copy-paste-sample-code--terminal-commands)

---

## 0. Quick start (commands only)

```bash
cd ~/project2
docker compose up -d

cd ~/project2/myFirstApp

docker exec -it laravel_php php artisan make:migration create_students_table
docker exec -it laravel_php php artisan make:migration create_studentdetails_table
```

Edit the two new files in `database/migrations/` (paste Schema code from §20).

```bash
docker exec -it laravel_php php artisan migrate
```

Check: http://localhost:8080 → database → tables `students` and `studentdetails`.

**Full step-by-step with explanations:** [`BUILD_STUDENT_TABLES_FROM_ZERO.md`](BUILD_STUDENT_TABLES_FROM_ZERO.md)

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

In class you may **build while learning**. Order still matters: **parent table before child table**.

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

See **Section 20** and **`BUILD_STUDENT_TABLES_FROM_ZERO.md`**.

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
docker exec -it laravel_php php artisan migrate
```

---

## 13. How to check in phpMyAdmin

1. http://localhost:8080  
2. Open DB from `.env` (`DB_DATABASE`)  
3. `students` → Structure  
4. `studentdetails` → Structure + Indexes  

---

## 14–19. Models, optional M:N, tools, checklist, mistakes, oral defense

See Section 20 samples and the dedicated build guide. Theory summary:

- Models use `$fillable` + `hasOne` / `belongsTo`  
- Parent migrates before child  
- Wrong phpMyAdmin database = “missing” data  

---

## 20. Copy-paste sample code + terminal commands

### 20.1 Terminal — Docker

```bash
cd ~/project2
docker compose up -d

cd ~/project2/myFirstApp

docker exec -it laravel_php php artisan make:migration create_students_table
docker exec -it laravel_php php artisan make:migration create_studentdetails_table

# edit migration files, then:
docker exec -it laravel_php php artisan migrate
docker exec -it laravel_php php artisan migrate:status
```

### 20.2 Full migration — students

```php
Schema::create('students', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('course');
    $table->integer('age');
    $table->timestamps();
});
```

### 20.3 Full migration — studentdetails

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

### 20.4 Models (short)

```php
// Student
protected $fillable = ['name', 'course', 'age'];
public function detail() { return $this->hasOne(StudentDetail::class); }

// StudentDetail
protected $table = 'studentdetails';
protected $fillable = ['student_id', 'address', 'contact'];
public function student() { return $this->belongsTo(Student::class); }
```

### 20.5 Order of work

```text
1. docker compose up -d
2. make:migration (students, then studentdetails)
3. Paste Schema::create code
4. migrate
5. models
6. controllers + routes + blade
7. phpMyAdmin Structure
8. Test forms in browser
```

More detail: **`docs/BUILD_STUDENT_TABLES_FROM_ZERO.md`**

---

## Final pipeline

```text
Commands → migration files → migrate → tables in MySQL
ERD explains why those tables/columns/FK exist
phpMyAdmin proves Structure
```

---

## See also

- **`docs/BUILD_STUDENT_TABLES_FROM_ZERO.md`** — start building (commands)  
- `docs/STUDENT_MIGRATION_GUIDE.md`  
- `docs/STUDENT_DB_AND_DEBUGGING.md`  

---

*ERD theory + schema reference. For typing commands first, open BUILD_STUDENT_TABLES_FROM_ZERO.md.*
