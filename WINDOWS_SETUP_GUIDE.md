# Complete Windows Setup Guide – myFirstApp (BloodLink)

This guide documents the full process of setting up the project on a Windows machine, including all common problems and their solutions.

---

## Requirements

| Tool       | Version Needed     | Purpose                    |
|------------|--------------------|----------------------------|
| PHP        | 8.4+ (8.5 works)   | Run Laravel                |
| Composer   | Latest             | Install PHP packages       |
| Node.js    | 18+ LTS            | Frontend (Vite + Tailwind) |
| Git        | Latest             | Clone the repository       |

---

## Step 1: Install PHP

### Recommended: Use Laragon
1. Download Laragon Full → https://laragon.org/download
2. Install and open Laragon
3. Click **Start All**

### Manual PHP Install (what we used)
1. Download PHP 8.5 NTS x64 from https://windows.php.net/download
2. Extract the ZIP (example location):
   ```
   C:\Users\vtemp\Downloads\php-8.5.9-nts-Win32-vs17-x64\
   ```
3. Add that folder to your System PATH

Check:
```powershell
php -v
```

---

## Step 2: Create and Configure `php.ini`

PHP does not load extensions until a proper `php.ini` exists.

1. Go to your PHP folder
2. Copy `php.ini-development` and rename it to `php.ini`
3. Open `php.ini` and make sure these lines exist:

```ini
extension_dir = "C:\Users\vtemp\Downloads\php-8.5.9-nts-Win32-vs17-x64\ext"

extension=curl
extension=fileinfo
extension=gd
extension=mbstring
extension=openssl
extension=pdo_mysql
extension=pdo_sqlite
extension=sqlite3
```

> **Important:** Replace the path in `extension_dir` with the actual location of your PHP `ext` folder.

4. Save the file
5. Close all PowerShell windows and open a new one

Test:
```powershell
php --ini
php -m
```

You must see `openssl`, `curl`, `fileinfo`, `mbstring`, etc. in the list **without** warnings.

---

## Step 3: Install Composer

1. Download Composer-Setup.exe → https://getcomposer.org/download
2. Run the installer (it should detect your PHP automatically)
3. Restart PowerShell after installation

Check:
```powershell
composer -V
```

---

## Step 4: Install Node.js

1. Download LTS version → https://nodejs.org
2. Install with default settings
3. Restart PowerShell

Check:
```powershell
node -v
npm -v
```

---

## Step 5: Clone the Project

```powershell
git clone https://github.com/irincovictor-cmd/myFirstApp.git
cd myFirstApp
```

---

## Step 6: Run the Automatic Setup Script

```powershell
Set-ExecutionPolicy -Scope CurrentUser RemoteSigned
.\setup-windows.ps1
```

The script will:
- Check PHP, Composer, and Node.js
- Run `composer install`
- Run `npm install`
- Create `.env` and generate the app key
- Create SQLite database and run migrations
- Build frontend assets

---

## Step 7: Start the Application

```powershell
php artisan serve
```

Then open in your browser:

| Page     | URL                              |
|----------|----------------------------------|
| Home     | http://localhost:8000/blood      |
| Donors   | http://localhost:8000/blood/donors |
| Requests | http://localhost:8000/blood/requests |
| Contact  | http://localhost:8000/blood/contact |
| Admin    | http://localhost:8000/blood/admin |

---

## Common Problems & Solutions (What We Actually Faced)

### 1. `composer` is not recognized
- Install Composer from https://getcomposer.org/download
- Restart PowerShell after installing

### 2. `nodejs` / `npm` is not recognized
- Install Node.js LTS from https://nodejs.org
- Restart PowerShell

### 3. PHP version too old (needs 8.4+)
- The project uses Laravel 13 + Symfony 8 which requires PHP 8.4+
- Install PHP 8.4 or 8.5

### 4. `openssl extension is required`
This is the most common issue.

**Cause:** No `php.ini` or wrong `extension_dir`

**Fix:**
1. Create `php.ini` in the same folder as `php.exe`
2. Set the correct path:
   ```ini
   extension_dir = "C:\path\to\your\php\ext"
   ```
3. Enable extensions:
   ```ini
   extension=openssl
   extension=curl
   extension=fileinfo
   extension=mbstring
   extension=gd
   extension=pdo_sqlite
   extension=sqlite3
   ```
4. Restart PowerShell and verify with `php -m`

### 5. `Unable to load dynamic library ... (The specified module could not be found)`
- Your `extension_dir` path is wrong
- Make sure it points to the real `ext` folder inside your PHP directory

### 6. `php --ini` shows `(none)`
- PHP is running without a configuration file
- Create `php.ini` in the PHP folder (copy from `php.ini-development`)

---

## Quick Working Commands (After Everything is Installed)

```powershell
cd C:\Users\vtemp\myFirstApp
composer install
npm install
copy .env.example .env
php artisan key:generate
New-Item database\database.sqlite -ItemType File -Force
php artisan migrate
npm run build
php artisan serve
```

---

## Notes

- This project was successfully set up using **PHP 8.5.9 NTS**
- SQLite is used by default (no need for MySQL)
- Always restart PowerShell after installing PHP, Composer, or Node.js
- Always verify extensions with `php -m` before running `composer install`

---

**Last updated:** Based on real troubleshooting session (November 2026)
