# Session notes — Portfolio hub, master links & BloodLink UI

**Date:** 2026-09-28  
**Repo:** [irincovictor-cmd/MyfirstApp](https://github.com/irincovictor-cmd/MyfirstApp)  
**Base URL (local):** `http://localhost:8000`

---

## Goal of this session

1. Build a **master list of links** for every project inside MyfirstApp.
2. Make the **portfolio page** the central hub so projects open with a click (no typing URLs).
3. **Refresh the BloodLink UI** (color palette).
4. **Fix** a wrong admin link (student admin vs BloodLink admin).

---

## 1. Master list of project links

### Portfolio (central hub)

| Page | URL |
|------|-----|
| Home | http://localhost:8000/home |
| Portfolio | http://localhost:8000/portfolio |
| Work | http://localhost:8000/work |
| About | http://localhost:8000/about |
| Contact | http://localhost:8000/contact |
| Root | http://localhost:8000/ → redirects to `/home` |

### Student system

| Page | URL |
|------|-----|
| Create student | http://localhost:8000/student |
| Student details | http://localhost:8000/student-details |
| Admin login | http://localhost:8000/admin/login |
| Admin – students | http://localhost:8000/admin/students |
| Admin index | http://localhost:8000/admin |

### Blood donation system (BloodLink)

| Page | URL |
|------|-----|
| Home | http://localhost:8000/blood |
| Donors list | http://localhost:8000/blood/donors |
| Add donor | http://localhost:8000/blood/donors/create |
| Blood requests | http://localhost:8000/blood/requests |
| Create request | http://localhost:8000/blood/requests/create |
| Requirers list | http://localhost:8000/blood/requirers |
| Create requirer | http://localhost:8000/blood/requirers/create |
| Contact form | http://localhost:8000/blood/contact |
| Contact queries | http://localhost:8000/blood/contact-queries |
| Pages | http://localhost:8000/blood/pages |
| Create page | http://localhost:8000/blood/pages/create |
| Contact info | http://localhost:8000/blood/contact-info |
| Create contact info | http://localhost:8000/blood/contact-info/create |
| **Admin dashboard** | http://localhost:8000/blood/admin |
| Admin register | http://localhost:8000/blood/admin/register |

### Operator

| Page | URL |
|------|-----|
| Operator index | http://localhost:8000/operator |
| Operator form | http://localhost:8000/operator/{type} |

---

## 2. Portfolio as central hub

**Idea:** Use the portfolio at `localhost:8000` so you click into projects instead of typing each path.

**File changed:** `resources/views/portfolio.blade.php`

### Work section — projects *inside* this app

| # | Card | Link |
|---|------|------|
| 01 | Blood Donation System | `/blood` (`blood.home`) |
| 02 | Student Registration | `/student` (`student.create`) |
| 03 | Operator / Calculator | `/operator` (`operator.index`) |
| 04 | BloodLink Admin | `/blood/admin` (`blood.admin.dashboard`) |

### Work section — outside projects (GitHub, open in new tab)

| # | Card | Link |
|---|------|------|
| 05 | Final Web System | GitHub repo |
| 06 | Whop Toolkit (Web) | GitHub repo |
| 07 | DSA Visualizer | GitHub repo |

**Note:** Outside projects are *not* copied into MyfirstApp. They remain external GitHub links only.

---

## 3. Admin areas — keep them separate

There are **two different** admin systems:

| System | URL | Purpose |
|--------|-----|--------|
| **BloodLink admin** | `/blood/admin` | Donors, requests, blood system |
| **Student admin** | `/admin/login` | Student registration DB |

### Mistake fixed this session

- Portfolio card **04** first pointed at `/admin/login` (student admin) and mixed both systems in the description.
- **Corrected** to BloodLink Admin → `/blood/admin` only.

The BloodLink topbar **Admin** button was already correct (`blood.admin.dashboard`). Only the portfolio card was wrong.

---

## 4. BloodLink UI refresh

**File changed:** `resources/views/layouts/blood.blade.php`  
(Shared layout for all `/blood/*` pages.)

### Why

Old palette mixed **teal/green primary** with **blood red** and cold slate grays. It felt inconsistent.

### New palette (cohesive crimson + warm neutrals)

| Role | Color |
|------|--------|
| Primary / blood | Cardinal crimson `#c41e3a` |
| Soft accent | Blush pink `#fce8ec` |
| Background | Warm off-white `#faf7f5` |
| Text | Warm charcoal `#1c1917` |
| Muted text | Stone gray `#78716c` |
| Topbar | Deep wine-black `#1a1214` |
| Borders | Soft warm gray `#e7e0dc` |

### Other UI polish

- Hero: crimson gradient (no teal)
- Active nav: soft rose highlight
- Form focus rings: red (brand-aligned)
- Form card: stronger shadow
- Quick-link hover: light red glow
- Primary buttons: consistent crimson

Applies to Home, Donors, Requests, Contact, Pages, Admin, and all BloodLink forms.

---

## 5. How to see the changes locally

```bash
cd ~/path/to/MyfirstApp   # or your project path
git pull origin main
```

Hard-refresh the browser (`Ctrl+Shift+R` / `Cmd+Shift+R`).

- Portfolio hub: http://localhost:8000/work  
- BloodLink (new colors): http://localhost:8000/blood  
- BloodLink admin: http://localhost:8000/blood/admin  

---

## 6. Commits from this session (summary)

1. Portfolio Work section → internal project links + external GitHub cards  
2. BloodLink layout → new color palette and UI polish  
3. Portfolio Admin card → fixed to BloodLink admin (`/blood/admin`)  

---

## Quick reference

```
Portfolio home:     http://localhost:8000/home
Work (hub):         http://localhost:8000/work
Student form:       http://localhost:8000/student
Blood home:         http://localhost:8000/blood
Blood donors:       http://localhost:8000/blood/donors
Blood admin:        http://localhost:8000/blood/admin
Student admin:      http://localhost:8000/admin/login
Operator:           http://localhost:8000/operator
```
