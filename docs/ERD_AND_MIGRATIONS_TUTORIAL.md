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
4. [Cardinality (how many related rows)](#4-cardinality-how-many-related-rows)
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
6. Verify in phpMyAdmin
```

---

## 3. ERD building blocks

### Entity

A **noun** you care about: `Student`, `Product`, `Teacher`.

In Laravel / MySQL this becomes a **table** (usually plural): `students`.

### Attribute

A **property** of an entity: `name`, `email`, `age`.

In MySQL this becomes a **column** with a **data type**.

### Primary key

Unique id for each row. In Laravel almost always:

```php
$table->id();   // MySQL: BIGINT UNSIGNED, AUTO_INCREMENT, PRIMARY KEY
```

### Relationship

A line between entities, e.g. “Student has one StudentDetail”.

### Foreign key

A column that **stores the other table’s id**, e.g. `student_id`.

In phpMyAdmin you will see it under **Structure** and under **Relation view** / indexes.

---

## 4. Cardinality (how many related rows)

| Name | Meaning | Example |
|------|---------|--------|
| **One-to-one (1:1)** | One A ↔ one B | One student ↔ one detail record |
| **One-to-many (1:N)** | One A ↔ many B | One student ↔ many grades |
| **Many-to-many (M:N)** | Many A ↔ many B | Students ↔ Subjects (needs pivot table) |

Our MyfirstApp student feature is **1:1**:

- one `students` row  
- at most one `studentdetails` row (because `student_id` is **UNIQUE**)

---

## 5. Step-by-step: design an ERD

### Step A — Read the requirement

Example requirement:

> Save student name, course, and age.  
> Later save address and contact for that student.

### Step B — List entities

- Student  
- StudentDetail (or “ContactInfo”)

### Step C — List attributes + planned data types

| Entity | Attribute | Planned type |
|--------|-----------|--------------|
| Student | id | integer, PK, auto |
| Student | name | string / VARCHAR |
| Student | course | string / VARCHAR |
| Student | age | integer / INT |
| StudentDetail | id | integer, PK, auto |
| StudentDetail | student_id | integer, FK, unique |
| StudentDetail | address | string / VARCHAR |
| StudentDetail | contact | string / VARCHAR |

(Plus `created_at`, `updated_at` timestamps on both.)

### Step D — Decide relationships

- Details belong to one student  
- One student has one details row → **1:1**  

### Step E — Mark keys

- Student: `id` **PK**  
- StudentDetail: `id` **PK**, `student_id` **FK** → `students.id` (**UNIQUE**)

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

## 7. Complete schema reference (phpMyAdmin)

This is what you should see after migrations run successfully.  
Compare **Structure** tab in phpMyAdmin to these tables.

> Laravel `$table->string()` → MySQL **VARCHAR(255)** by default  
> Laravel `$table->id()` → MySQL **BIGINT UNSIGNED** AUTO_INCREMENT  
> Laravel `$table->foreignId()` → MySQL **BIGINT UNSIGNED**  
> Laravel `$table->integer()` → MySQL **INT**  
> Laravel `$table->timestamps()` → **TIMESTAMP** nullable columns `created_at`, `updated_at`

Exact display can vary slightly by MySQL version; names and roles stay the same.

---

### 7.1 Table: `students`

**Entity:** Student  
**Purpose:** Store basic student identity (name, course, age).

| Column | MySQL data type (typical) | Null | Key | Default | Extra | Description |
|--------|---------------------------|------|-----|---------|-------|-------------|
| `id` | BIGINT UNSIGNED | NO | **PRI** | NULL | auto_increment | Primary key |
| `name` | VARCHAR(255) | NO | | NULL | | Student full name |
| `course` | VARCHAR(255) | NO | | NULL | | Course (e.g. BSIT) |
| `age` | INT | NO | | NULL | | Age in years |
| `created_at` | TIMESTAMP | YES | | NULL | | Row created time |
| `updated_at` | TIMESTAMP | YES | | NULL | | Row last updated |

**Primary key:** `id`  
**Foreign keys:** none (this is the **parent** table)  
**Indexes:** PRIMARY on `id`

**Laravel migration mapping:**

| Column | Migration code |
|--------|----------------|
| id | `$table->id();` |
| name | `$table->string('name');` |
| course | `$table->string('course');` |
| age | `$table->integer('age');` |
| created_at, updated_at | `$table->timestamps();` |

---

### 7.2 Table: `studentdetails`

**Entity:** StudentDetail  
**Purpose:** Store address and contact linked to one student.

| Column | MySQL data type (typical) | Null | Key | Default | Extra | Description |
|--------|---------------------------|------|-----|---------|-------|-------------|
| `id` | BIGINT UNSIGNED | NO | **PRI** | NULL | auto_increment | Primary key of this row |
| `student_id` | BIGINT UNSIGNED | NO | **UNI** + **FK** | NULL | | Links to `students.id` (one detail per student) |
| `address` | VARCHAR(255) | NO | | NULL | | Home / mailing address |
| `contact` | VARCHAR(255) | NO | | NULL | | Phone or contact number |
| `created_at` | TIMESTAMP | YES | | NULL | | Row created time |
| `updated_at` | TIMESTAMP | YES | | NULL | | Row last updated |

**Primary key:** `id`  
**Foreign key:** `student_id` → `students`.`id`  
**Unique index:** on `student_id` (enforces **1:1**)  
**On delete:** **CASCADE** (delete student → delete their detail row)

**Laravel migration mapping:**

| Column | Migration code |
|--------|----------------|
| id | `$table->id();` |
| student_id | `$table->foreignId('student_id')->unique()->constrained('students')->onDelete('cascade');` |
| address | `$table->string('address');` |
| contact | `$table->string('contact');` |
| timestamps | `$table->timestamps();` |

---

### 7.3 Relationship summary (for ERD + phpMyAdmin)

| Item | Value |
|------|--------|
| Parent table | `students` |
| Child table | `studentdetails` |
| Relationship type | **One-to-one (1:1)** |
| Parent PK | `students.id` |
| Child FK column | `studentdetails.student_id` |
| FK references | `students.id` |
| FK constraint name (typical) | `studentdetails_student_id_foreign` |
| Unique constraint (typical) | `studentdetails_student_id_unique` |
| Delete rule | **ON DELETE CASCADE** |
| Update rule | often RESTRICT / NO ACTION (MySQL default for FK) |

**In words:**  
Each row in `studentdetails` must point to exactly one existing `students.id`.  
Each `students.id` may appear **at most once** in `studentdetails.student_id`.

---

### 7.4 Sample data (how rows look when linked)

**`students`**

| id | name | course | age | created_at | updated_at |
|----|------|--------|-----|------------|------------|
| 1 | victor | bsit | 21 | 2026-... | 2026-... |
| 2 | maria | bsit | 20 | 2026-... | 2026-... |

**`studentdetails`**

| id | student_id | address | contact | created_at | updated_at |
|----|------------|---------|---------|------------|------------|
| 1 | 1 | Tawala, Panglao | 09XXXXXXXXX | 2026-... | 2026-... |

Here `student_id = 1` means “details for victor”.  
Student `maria` (id 2) has **no** details row yet.

---

### 7.5 Other tables you may see in phpMyAdmin

Laravel also creates system tables (not part of your student ERD):

| Table | Role |
|-------|------|
| `migrations` | Log of which migrations already ran |
| `users` | Default Laravel users |
| `cache`, `jobs`, `sessions`, … | Framework extras |

For the **student ERD**, focus only on **`students`** and **`studentdetails`**.

---

## 8. Translate ERD → Laravel tables

| ERD idea | Laravel | MySQL result |
|----------|---------|--------------|
| Entity Student | Table `students` | Table `students` |
| Attribute name | `$table->string('name')` | VARCHAR(255) |
| PK | `$table->id()` | BIGINT PK AI |
| FK student_id | `$table->foreignId(...)->constrained(...)` | BIGINT + FK |
| 1:1 | FK + `->unique()` | UNIQUE index on FK |
| Timestamps | `$table->timestamps()` | created_at, updated_at |

### Naming rules (Laravel habits)

| Thing | Convention |
|-------|------------|
| Table | plural snake: `students` |
| Model | singular Studly: `Student` |
| FK | `{model}_id` → `student_id` |

Our details table is named **`studentdetails`** (course style). Eloquent default would be `student_details`, so the model sets `protected $table = 'studentdetails'`.

---

## 9. Create migration files

```bash
php artisan make:migration create_students_table
php artisan make:migration create_studentdetails_table
```

Docker:

```bash
docker exec -it laravel_php php artisan make:migration create_students_table
docker exec -it laravel_php php artisan make:migration create_studentdetails_table
```

**Rule:** parent table migration must run **before** child table (students before studentdetails).

---

## 10. Write the migrations

### 10.1 Students (parent entity)

```php
public function up(): void
{
    Schema::create('students', function (Blueprint $table) {
        $table->id();                 // PK
        $table->string('name');       // VARCHAR(255)
        $table->string('course');
        $table->integer('age');       // INT
        $table->timestamps();         // created_at, updated_at
    });
}

public function down(): void
{
    Schema::dropIfExists('students');
}
```

### 10.2 Student details (child entity + relationship)

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

### Map ERD line → code → phpMyAdmin

| ERD | Migration | phpMyAdmin |
|-----|-----------|------------|
| student_id → Student | `foreignId(...)->constrained('students')` | FK on `student_id` |
| only one detail per student | `->unique()` | UNIQUE on `student_id` |
| delete student removes detail | `->onDelete('cascade')` | FK delete rule CASCADE |

---

## 11. Foreign keys in plain English

```php
$table->foreignId('student_id')
    ->unique()
    ->constrained('students')
    ->onDelete('cascade');
```

| Part | Meaning | phpMyAdmin |
|------|--------|------------|
| `foreignId('student_id')` | Column holds a student id | Column `student_id` |
| `constrained('students')` | Must match `students.id` | Foreign key relation |
| `unique()` | One details row per student | Unique index |
| `onDelete('cascade')` | Delete student → delete detail | ON DELETE CASCADE |

---

## 12. Run migrations

```bash
php artisan migrate
docker exec -it laravel_php php artisan migrate
php artisan migrate:status

# WARNING: wipes all tables then rebuilds
php artisan migrate:fresh
```

---

## 13. How to check in phpMyAdmin

1. Open **http://localhost:8080**  
2. Log in (root / secret for this Docker stack, if unchanged)  
3. Open the database from `.env` (`DB_DATABASE` — often **`laravel`**)  
4. Click table **`students`** → **Structure** → compare to [section 7.1](#71-table-students)  
5. Click table **`studentdetails`** → **Structure** → compare to [section 7.2](#72-table-studentdetails)  
6. Open **Indexes** (or Relation view) on `studentdetails` → confirm **UNIQUE** + **FOREIGN** on `student_id`  
7. **Browse** data after using the web forms at `/student` and `/student-details`  

If forms save but you see no new rows, you are likely viewing the **wrong database** (e.g. `myFirstApp` vs `laravel`).

---

## 14. Models after the ERD

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

| ERD relationship | Eloquent | DB |
|------------------|----------|-----|
| Student has one Detail | `hasOne` | 1:1 via unique FK |
| Detail belongs to Student | `belongsTo` | `student_id` → `students.id` |

---

## 15. Bigger example (optional)

Many-to-many: students ↔ subjects via `enrollments`.

```php
Schema::create('enrollments', function (Blueprint $table) {
    $table->id();
    $table->foreignId('student_id')->constrained()->onDelete('cascade');
    $table->foreignId('subject_id')->constrained()->onDelete('cascade');
    $table->timestamps();
    $table->unique(['student_id', 'subject_id']);
});
```

| Column | Role |
|--------|------|
| student_id | FK → students.id |
| subject_id | FK → subjects.id |
| unique pair | same student+subject only once |

---

## 16. Drawing tools for ERD

| Tool | Notes |
|------|--------|
| Paper / whiteboard | Fast for exams |
| [dbdiagram.io](https://dbdiagram.io) | Type tables, get diagram |
| draw.io | Free boxes and arrows |
| phpMyAdmin Designer | Can show relations after FK exists |
| MySQL Workbench | Reverse-engineer from live DB |

### dbdiagram syntax for our example

```text
Table students {
  id bigint [pk, increment]
  name varchar
  course varchar
  age int
  created_at timestamp
  updated_at timestamp
}

Table studentdetails {
  id bigint [pk, increment]
  student_id bigint [unique, ref: - students.id]
  address varchar
  contact varchar
  created_at timestamp
  updated_at timestamp
}
```

---

## 17. Checklist for midterm

- [ ] Entities listed  
- [ ] Attributes + **data types** listed  
- [ ] PK marked  
- [ ] FK marked with referenced table  
- [ ] Cardinality (1:1 / 1:N / M:N) labeled  
- [ ] Migration parent then child  
- [ ] `constrained` + `unique` if 1:1  
- [ ] `migrate` OK  
- [ ] phpMyAdmin **Structure** matches section 7  
- [ ] Sample insert visible under **Browse**  

---

## 18. Common mistakes

| Mistake | What you see |
|---------|----------------|
| Wrong DB in phpMyAdmin | Empty `students` while app works |
| Child migrated before parent | FK creation error |
| No `unique()` on 1:1 FK | Multiple details per student allowed |
| Only model, no migration | Table missing in phpMyAdmin |
| Forgot Docker migrate | Host DB updated, app DB not |

---

## 19. Oral defense lines

**What is an ERD?**  
“A diagram of entities, attributes, and relationships that plans the database.”

**What tables did you create?**  
“`students` with id, name, course, age; `studentdetails` with id, student_id, address, contact.”

**What is the FK?**  
“`studentdetails.student_id` references `students.id`.”

**Why unique on student_id?**  
“To enforce one-to-one: one details row per student.”

**How do you verify?**  
“phpMyAdmin Structure for columns/types and Indexes for the foreign key.”

---

## Final pipeline

```text
Problem → ERD (tables, columns, types, PK, FK, cardinality)
       → Migrations
       → php artisan migrate
       → phpMyAdmin verifies Structure + data
       → Models / forms use the tables
```

**ERD is the map. Migrations build the tables. phpMyAdmin proves they exist.**

---

## See also

- `docs/STUDENT_MIGRATION_GUIDE.md` — full student feature walkthrough  
- `docs/STUDENT_DB_AND_DEBUGGING.md` — Docker / DB debugging  
- Migrations: `database/migrations/2026_08_26_*students*` and `2026_09_14_*studentdetails*`  

---

*For BSIT study / midterm: ERD, columns, data types, FK — verifiable in phpMyAdmin.*
