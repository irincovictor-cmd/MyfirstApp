# Student forms, database & debugging notes

Project: **MyfirstApp** (Laravel learning app)  
Paths: `/student`, `/student-details`  
Runtime used in class: **Docker** → http://localhost:8000

---

## 1. What the feature does

Two related forms:

| Page | URL | Saves |
|------|-----|--------|
| Student Information | `/student` | `name`, `course`, `age` into **students** |
| Student Details | `/student-details` | `address`, `contact` linked to a student in **studentdetails** |

Flow:

1. Add a student (basic info).
2. Open student details, **select that student**, add address + contact.
3. Success messages use session flash after redirect.

---

## 2. How the database is structured

### Tables

**students**

| Column | Type | Meaning |
|--------|------|--------|
| id | bigint (PK) | Student id |
| name | string | Full name |
| course | string | Course |
| age | integer | Age |
| created_at / updated_at | timestamps | Laravel defaults |

**studentdetails**

| Column | Type | Meaning |
|--------|------|--------|
| id | bigint (PK) | Detail row id |
| student_id | foreignId (unique) | Links to `students.id` (one detail per student) |
| address | string | Address |
| contact | string | Phone/contact |
| created_at / updated_at | timestamps | |

Foreign key: `student_id` → `students.id`, **onDelete cascade** (deleting a student removes their detail row).

### Eloquent models

- `App\Models\Student` — fillable: name, course, age; `hasOne(StudentDetail::class)`
- `App\Models\StudentDetail` — table `studentdetails`; fillable: student_id, address, contact; `belongsTo(Student::class)`

### Migrations

- `2026_08_26_014638_create_students_table.php`
- `2026_09_14_000001_create_studentdetails_table.php`

Applied inside Docker with:

```bash
docker exec -it laravel_php php artisan migrate:fresh
```

---

## 3. How a request works (end-to-end)

### Add student (`POST /student`)

```text
Browser form
  → routes/web.php  → StudentController@store
  → validate name, course, age
  → Student::create([...])   // INSERT into students
  → redirect /student with flash "Student added successfully!"
```

### Add details (`POST /student-details`)

```text
Browser form (dropdown of students)
  → StudentDetailController@store
  → validate student_id exists, address, contact
  → StudentDetail::create([...])  // INSERT into studentdetails
  → redirect /student-details with success flash
```

### Show details form (`GET /student-details`)

```text
StudentDetailController@create
  → Student::all()
  → view student-details with $students for <select>
```

CSRF: forms use `@csrf`. Session flash needs a working session driver (we use `SESSION_DRIVER=file` in Docker).

---

## 4. Debugging log (readonly database)

### Symptom

```text
SQLSTATE[HY000]: General error: 8 attempt to write a readonly database
```

Often on **sessions** update when opening `/student-details` or other pages.

### Root cause (not the controller logic)

Two ways of running the app were mixed:

| Server | Port | What happened |
|--------|------|----------------|
| Docker `laravel_nginx` + `laravel_php` | **8000** | What the browser used; SQLite not writable for container user |
| Host `php artisan serve` | **8001** (8000 busy) | Host SQLite *was* writable; migrate on host did not fix Docker |

Also:

- Host `.env` had `DB_CONNECTION=sqlite` while **MySQL container** (`laravel_mysql`) existed unused at first.
- `docker-compose.yml` is in **`~/project2/docker-compose.yml`**, not inside `myFirstApp/`.
- Code is bind-mounted: host `~/project2/myFirstApp` → container `/var/www`.

Fixing `chmod` only on the WSL host was not enough for the process inside Docker.

### What fixed it (practical path)

1. Standardize on **http://localhost:8000** (Docker only).
2. Point `.env` at MySQL:

```env
DB_CONNECTION=mysql
DB_HOST=laravel_mysql
DB_PORT=3306
DB_DATABASE=myFirstApp
DB_USERNAME=root
DB_PASSWORD=secret
SESSION_DRIVER=file
```

(Values from `docker inspect laravel_mysql` / compose: `MYSQL_DATABASE=myFirstApp`, `MYSQL_ROOT_PASSWORD=secret`.)

3. Migrate **inside** the PHP container:

```bash
docker exec -it laravel_php php artisan config:clear
docker exec -it laravel_php php artisan migrate:fresh
```

4. Do not rely on host `artisan serve` while Nginx holds port 8000.

Django on **8081** did not conflict; different ports and databases.

---

## 5. Useful commands

```bash
cd ~/project2/myFirstApp

# DB env inside MySQL container
docker inspect laravel_mysql --format '{{range .Config.Env}}{{println .}}{{end}}' | grep MYSQL

# Migrate in Docker
docker exec -it laravel_php php artisan migrate
docker exec -it laravel_php php artisan migrate:fresh   # wipes data

# Compose location
cat ~/project2/docker-compose.yml
```

---

## 6. Files involved

```text
app/Models/Student.php
app/Models/StudentDetail.php
app/Http/Controllers/StudentController.php
app/Http/Controllers/StudentDetailController.php
routes/web.php
resources/views/student.blade.php
resources/views/student-details.blade.php
database/migrations/2026_08_26_014638_create_students_table.php
database/migrations/2026_09_14_000001_create_studentdetails_table.php
docs/STUDENT_DB_AND_DEBUGGING.md
```

---

*School / learning notes — not a production runbook.*
