# Ivor Paine Memorial Hospital — Management System

A full-stack hospital management system built as a Database course project (SP26). Features a normalized SQL Server schema, a PHP REST API backend, and a single-page HTML/JS frontend dashboard.

---

## Tech Stack

| Layer | Technology |
|---|---|
| Database | Microsoft SQL Server (T-SQL) |
| Backend | PHP 8+ with `sqlsrv` driver |
| Frontend | Vanilla HTML/CSS/JS (single-page, no framework) |
| Fonts | DM Serif Display, DM Sans, JetBrains Mono |

---

## Project Structure

```
ivorHospital/
│
├── IvorHospital/                       # SQL scripts
│   ├── Project_DB.sql                  # Schema: tables, constraints, triggers
│   └── Project_db_insertion.sql        # Sample data insertion
│
└── HOSPITAL_WEBSITE/                   # Web application
    ├── api.php                         # REST API — all backend actions
    ├── index.php                       # Frontend SPA (dashboard + queries + forms)
    └── includes/
        └── db.php                      # DB connection + query helpers
```

---

## Database Schema

**15 tables** covering the full hospital domain:

`SPECIALITY` → `WARD` → `CARE_UNIT` → `BED` → `BED_ALLOCATED`

`STAFF` → `DOCTOR` / `NURSE` → `PATIENT`

`TREATMENT` → `PATIENT_TREATMENT` ← `COMPLAINT`

`PERFORMANCE`, `EXPERIENCE`

### Triggers (8)

| Trigger | Purpose |
|---|---|
| `trg_PreventDeleteSpecialityIfReferenced` | Blocks deletion of a speciality still in use |
| `trg_UpdateWardBedCounts` | Auto-updates Total/Occupied/Available beds on BED changes |
| `trg_ValidateDoctorDateJoined` | Rejects future join dates |
| `trg_PreventDuplicateBedAllocation` | Ensures one bed per patient |
| `trg_SetBedStatusOnAllocate` | Marks bed Occupied on allocation |
| `trg_SetBedStatusOnDeallocate` | Marks bed Available on deallocation |
| `trg_ValidatePatientAge` | Validates age matches date of birth |
| `trg_ValidateExperienceDates` | Ensures from_date < to_date in experience records |

---

## API Reference

All requests go to `api.php?action=<action_name>`.

### Dashboard
| Action | Description |
|---|---|
| `dashboard` | Returns counts: patients, doctors, nurses, wards, beds, complaints, treatments |

### Reports (12 Queries)
| Action | Description |
|---|---|
| `q1_consultant_teams` | Consultants and their junior doctor teams |
| `q2_ward_details` | Wards with care units and assigned nurses |
| `q3_patient_treatments` | Patients, their complaints, and treatments |
| `q4_junior_housemen` | Junior housemen, their patients, and staff nurses |
| `q5_unique_speciality` | Consultants who are the sole specialist in their field |
| `q6_complaint_treatment_exp` | Complaints linked to treatments and doctor experience |
| `q7_multi_complaint` | Patients with more than one complaint |
| `q10_patient_details` | Full medical record for a patient (`?patient_id=`) |
| `q11_treatments_by_dates` | Treatments for a complaint within a date range (`?complaint_id=&from=&to=`) |
| `q12_staff_positions` | Staff count grouped by position |

### Forms (Record Lookups)
| Action | Description |
|---|---|
| `get_patient_record` | Patient + doctor + treatment history (`?patient_id=`) |
| `get_ward_record` | Ward + nurses + patients (`?ward_name=`) |
| `get_consultant_team` | Doctor profile + experience + performance (`?staff_id=`) |

### Helpers
| Action | Description |
|---|---|
| `list_patients` | All patients (for dropdowns) |
| `list_doctors` | All doctors |
| `list_wards` | All wards |
| `list_complaints` | All complaints |
| `search_patients` | Live search by name (`?q=`) |

---

## Setup

### Prerequisites
- PHP 8+ with the `sqlsrv` and `pdo_sqlsrv` extensions
- Microsoft SQL Server or SQL Server Express
- A web server (Apache/Nginx) or PHP's built-in dev server

### Steps

1. **Create the database and schema**
   ```sql
   -- Run in SSMS or sqlcmd:
   -- Project_DB.sql
   ```

2. **Insert sample data**
   ```sql
   -- Project_db_insertion.sql
   ```

3. **Configure the connection** in `includes/db.php`:
   ```php
   define('DB_SERVER', 'YOUR_SERVER\SQLEXPRESS');
   define('DB_NAME',   'HospitalDB_v2');
   define('DB_USER',   '');   // leave empty for Windows auth
   define('DB_PASS',   '');
   ```

4. **Serve the project**
   ```bash
   php -S localhost:8000
   ```
   Then open `http://localhost:8000` in your browser.

---

## Features

- **Live Dashboard** — real-time counts for patients, staff, beds, and complaints
- **12 analytical queries** covering consultant teams, ward staffing, patient histories, and more
- **3 record forms** — patient, ward, and consultant lookups
- **Bed management** — automatic status tracking via triggers
- **Dark/light theme** toggle
- **Responsive tables** with search and filtering

---
