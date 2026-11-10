# Windows Setup Guide – myFirstApp (BloodLink)

This guide helps you install everything needed to run the project on a Windows machine.

---

## Option A – Automatic Script (Recommended)

1. Open **PowerShell as Administrator**
2. Go to the project folder:
   ```powershell
   cd path\to\myFirstApp
   ```
3. Allow scripts to run (only needed once):
   ```powershell
   Set-ExecutionPolicy -Scope CurrentUser RemoteSigned
   ```
4. Run the installer:
   ```powershell
   .\setup-windows.ps1
   ```

The script will check for PHP, Composer, Node.js and guide you through the missing parts.

---

## Option B – Manual Installation

### 1. Install PHP 8.3+

**Easiest way: Laragon**
- Download: https://laragon.org/download
- Install the **Full** version
- Open Laragon → click **Start All**

**Or install PHP manually**
- Download PHP 8.3 Thread Safe from https://windows.php.net/download
- Extract to `C:\php`
- Add `C:\php` to your System PATH

Check:
```powershell
php -v
```

### 2. Install Composer

- Download: https://getcomposer.org/download
- Run `Composer-Setup.exe`
- It should automatically detect your PHP

Check:
```powershell
composer -V
```

### 3. Install Node.js

- Download LTS from https://nodejs.org
- Install with default settings

Check:
```powershell
node -v
npm -v
```

### 4. Clone / Open the Project

```powershell
git clone https://github.com/irincovictor-cmd/myFirstApp.git
cd myFirstApp
```

### 5. Install Dependencies & Run

```powershell
composer install
npm install
copy .env.example .env
php artisan key:generate

# Create SQLite database (easiest)
New-Item database\database.sqlite -ItemType File -Force
php artisan migrate

npm run build
php artisan serve
```

Then open:
- http://localhost:8000/blood
- http://localhost:8000/blood/donors
- http://localhost:8000/blood/admin

---

## Quick Commands (after tools are installed)

```powershell
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

## Troubleshooting

| Problem | Solution |
|---------|----------|
| `composer` not recognized | Restart PowerShell after installing Composer, or re-open terminal |
| `php` not recognized | Add PHP folder to PATH or use Laragon terminal |
| Migration error | Make sure `database\database.sqlite` exists |
| Port 8000 already used | Run `php artisan serve --port=8001` |
