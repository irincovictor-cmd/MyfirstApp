# Start building: create student tables in Laravel (command-first)

This is the **hands-on** guide: what to type, in order, to create the database tables.

For **what an ERD is** and column/FK theory, see:

- `docs/ERD_AND_MIGRATIONS_TUTORIAL.md`

This file assumes **MyfirstApp + Docker** on your PC (http://localhost:8000).

---

## What you will build

Two tables in MySQL:

1. **`students`** — name, course, age  
2. **`studentdetails`** — address, contact, linked by `student_id`

---

## Before you start

### 1. Open terminal (WSL)

```bash
wsl -d ubuntu
```

### 2. Start Docker containers

Compose file is usually in the **parent** folder:

```bash
cd ~/project2
docker compose up -d
docker ps
```

You should see `laravel_php`, `laravel_nginx`, `laravel_mysql`, etc.

### 3. Enter the Laravel project

```bash
cd ~/project2/myFirstApp
```

### 4. Check database settings

```bash
grep DB_ .env
```

Example that works with Docker MySQL:

```env
DB_CONNECTION=mysql
DB_HOST=laravel_mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=secret
```

If you change `.env`:

```bash
docker exec -it laravel_php php artisan config:clear
```

---

## Step 1 — Create empty migration files

These commands **do not** create tables yet. They only create PHP files under `database/migrations/`.

```bash
cd ~/project2/myFirstApp

docker exec -it laravel_php php artisan make:migration create_students_table
docker exec -it laravel_php php artisan make:migration create_studentdetails_table
```

List the new files:

```bash
ls -lt database/migrations | head
```

Open the two newest `*_create_students_table.php` and `*_create_studentdetails_table.php` in VS Code.

---

## Step 2 — Put code inside the migrations

### File A — students (parent table first)

Replace the `up` and `down` methods with:

```php
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
```

Keep the `<?php`, `use` statements, and `return new class extends Migration` at the top of the file.

### File B — studentdetails (child table second)

```php
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
```

**Important:** `students` migration must be dated/run **before** `studentdetails` (parent before child).

---

## Step 3 — Run migrations (this creates the tables)

```bash
cd ~/project2/myFirstApp

docker exec -it laravel_php php artisan migrate
```

Expected: lines saying migrations **DONE** for students and studentdetails.

Check status:

```bash
docker exec -it laravel_php php artisan migrate:status
```

### If tables already half-exist or you want a clean rebuild

**Warning:** this deletes data in the database.

```bash
docker exec -it laravel_php php artisan migrate:fresh
```

---

## Step 4 — Confirm in phpMyAdmin

1. Open http://localhost:8080  
2. Login (often user `root`, password `secret`)  
3. Click database name from `.env` (`laravel` or `myFirstApp`)  
4. You should see tables:
   - **`students`**
   - **`studentdetails`**
5. Click **Structure** on each table and check columns.

| Table | Columns you should see |
|-------|------------------------|
| students | id, name, course, age, created_at, updated_at |
| studentdetails | id, student_id, address, contact, created_at, updated_at |

On `studentdetails` → **Indexes**: UNIQUE + FOREIGN on `student_id`.

---

## Step 5 — Create models (PHP classes for the tables)

```bash
docker exec -it laravel_php php artisan make:model Student
docker exec -it laravel_php php artisan make:model StudentDetail
```

Edit the generated files (or copy from the repo).

**`app/Models/Student.php`** — add:

```php
protected $fillable = ['name', 'course', 'age'];

public function detail()
{
    return $this->hasOne(StudentDetail::class);
}
```

**`app/Models/StudentDetail.php`** — add:

```php
protected $table = 'studentdetails';

protected $fillable = ['student_id', 'address', 'contact'];

public function student()
{
    return $this->belongsTo(Student::class);
}
```

---

## Step 6 — Controllers, routes, forms (so you can insert data)

If you are on the full **MyfirstApp** repo, these already exist after `git pull`.

If building midterm from zero, you still need:

1. `StudentController` / `StudentDetailController`  
2. Routes in `routes/web.php`  
3. Blade views with `@csrf`  

Full samples: `docs/ERD_AND_MIGRATIONS_TUTORIAL.md` → **Section 20**.

Quick test URLs after that:

- http://localhost:8000/student  
- http://localhost:8000/student-details  

Then **Browse** the tables again in phpMyAdmin to see new rows.

---

## Command cheat sheet (copy this)

```bash
# 0) start
cd ~/project2 && docker compose up -d
cd ~/project2/myFirstApp

# 1) create migration files
docker exec -it laravel_php php artisan make:migration create_students_table
docker exec -it laravel_php php artisan make:migration create_studentdetails_table

# 2) (edit the two migration files in VS Code — paste Schema::create code)

# 3) create tables in MySQL
docker exec -it laravel_php php artisan migrate

# 4) optional models
docker exec -it laravel_php php artisan make:model Student
docker exec -it laravel_php php artisan make:model StudentDetail

# 5) check
docker exec -it laravel_php php artisan migrate:status
# then open http://localhost:8080
```

### Host PHP only (no Docker)

```bash
cd ~/project2/myFirstApp
php artisan make:migration create_students_table
php artisan make:migration create_studentdetails_table
# edit files...
php artisan migrate
php artisan serve
```

---

## Common errors while building

| Problem | What to do |
|---------|------------|
| `migrate` says connection refused | `docker compose up -d`; `DB_HOST=laravel_mysql` |
| Foreign key error | Create/run **students** migration before **studentdetails** |
| Tables not in phpMyAdmin | Wrong database selected; match `DB_DATABASE` |
| `Address already in use` on 8000 | Docker nginx already serves :8000 — use that URL |
| Forgot to start Docker | `docker compose up -d` first |

---

## What each command does (short)

| Command | Meaning |
|---------|--------|
| `docker compose up -d` | Start MySQL, PHP, Nginx |
| `make:migration ...` | Create a migration **file** (no table yet) |
| `migrate` | Run migrations → **create tables** in MySQL |
| `migrate:fresh` | Drop all tables and migrate again |
| `make:model` | Create Eloquent model class |
| `migrate:status` | List which migrations already ran |

---

## Recommended study order

1. **This file** — type commands, create tables, check phpMyAdmin  
2. **`ERD_AND_MIGRATIONS_TUTORIAL.md`** — understand ERD, columns, types, FK  
3. **`STUDENT_MIGRATION_GUIDE.md`** — models, controllers, full feature  

---

*Hands-on build guide for MyfirstApp / midterm migrations.*
