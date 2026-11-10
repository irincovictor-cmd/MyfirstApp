# ============================================================
#  myFirstApp (BloodLink) - Windows Setup Script
#  Run this inside the project folder using PowerShell
# ============================================================

Write-Host ""
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "  myFirstApp / BloodLink Setup Script" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

# --- Helper function ---
function Test-Command($cmd) {
    try {
        if (Get-Command $cmd -ErrorAction Stop) { return $true }
    } catch {
        return $false
    }
}

# --- 1. Check PHP ---
Write-Host "[1/6] Checking PHP..." -ForegroundColor Yellow
if (Test-Command "php") {
    $phpVersion = php -v 2>&1 | Select-Object -First 1
    Write-Host "  OK - $phpVersion" -ForegroundColor Green
} else {
    Write-Host "  PHP is NOT installed or not in PATH." -ForegroundColor Red
    Write-Host "  Please install PHP 8.3+ or Laragon first." -ForegroundColor Red
    Write-Host "  Download Laragon: https://laragon.org/download" -ForegroundColor Yellow
    Write-Host "  Then restart PowerShell and run this script again." -ForegroundColor Yellow
    exit 1
}

# --- 2. Check Composer ---
Write-Host "[2/6] Checking Composer..." -ForegroundColor Yellow
if (Test-Command "composer") {
    $composerVersion = composer -V 2>&1 | Select-Object -First 1
    Write-Host "  OK - $composerVersion" -ForegroundColor Green
} else {
    Write-Host "  Composer is NOT installed or not in PATH." -ForegroundColor Red
    Write-Host "  Download: https://getcomposer.org/download" -ForegroundColor Yellow
    Write-Host "  Install it, then restart PowerShell and run this script again." -ForegroundColor Yellow
    exit 1
}

# --- 3. Check Node.js ---
Write-Host "[3/6] Checking Node.js..." -ForegroundColor Yellow
if (Test-Command "node") {
    $nodeVersion = node -v
    Write-Host "  OK - Node $nodeVersion" -ForegroundColor Green
} else {
    Write-Host "  Node.js is NOT installed." -ForegroundColor Red
    Write-Host "  Download LTS from: https://nodejs.org" -ForegroundColor Yellow
    Write-Host "  Install it, then restart PowerShell and run this script again." -ForegroundColor Yellow
    exit 1
}

if (Test-Command "npm") {
    $npmVersion = npm -v
    Write-Host "  OK - npm $npmVersion" -ForegroundColor Green
} else {
    Write-Host "  npm not found. Reinstall Node.js." -ForegroundColor Red
    exit 1
}

# --- 4. Install PHP dependencies ---
Write-Host ""
Write-Host "[4/6] Installing PHP dependencies (composer install)..." -ForegroundColor Yellow
composer install
if ($LASTEXITCODE -ne 0) {
    Write-Host "  composer install failed." -ForegroundColor Red
    exit 1
}
Write-Host "  Composer packages installed." -ForegroundColor Green

# --- 5. Install JS dependencies ---
Write-Host ""
Write-Host "[5/6] Installing JavaScript dependencies (npm install)..." -ForegroundColor Yellow
npm install
if ($LASTEXITCODE -ne 0) {
    Write-Host "  npm install failed." -ForegroundColor Red
    exit 1
}
Write-Host "  npm packages installed." -ForegroundColor Green

# --- 6. Environment + Database + Build ---
Write-Host ""
Write-Host "[6/6] Setting up environment and database..." -ForegroundColor Yellow

if (-Not (Test-Path ".env")) {
    Copy-Item ".env.example" ".env"
    Write-Host "  .env file created." -ForegroundColor Green
} else {
    Write-Host "  .env already exists." -ForegroundColor Green
}

php artisan key:generate

# Create SQLite database if it doesn't exist
if (-Not (Test-Path "database\database.sqlite")) {
    New-Item -Path "database\database.sqlite" -ItemType File -Force | Out-Null
    Write-Host "  SQLite database created." -ForegroundColor Green
}

php artisan migrate --force
Write-Host "  Migrations completed." -ForegroundColor Green

Write-Host ""
Write-Host "Building frontend assets (npm run build)..." -ForegroundColor Yellow
npm run build
Write-Host "  Frontend built." -ForegroundColor Green

# --- Done ---
Write-Host ""
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "  Setup completed successfully!" -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "To start the server, run:" -ForegroundColor Yellow
Write-Host "  php artisan serve" -ForegroundColor White
Write-Host ""
Write-Host "Then open in your browser:" -ForegroundColor Yellow
Write-Host "  http://localhost:8000/blood" -ForegroundColor White
Write-Host "  http://localhost:8000/blood/donors" -ForegroundColor White
Write-Host "  http://localhost:8000/blood/admin" -ForegroundColor White
Write-Host ""
