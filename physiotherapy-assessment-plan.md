# Structured Physiotherapy Assessment + Treatment Recommendation

**Feature Plan for Rx Physio (Dr. Indolia Physiotherapy Clinic ERP)**

---

## Table of Contents

1. [Objective](#1-objective)
2. [Database Models](#2-database-models)
3. [Relationships Diagram](#3-relationships-diagram)
4. [Controllers](#4-controllers)
5. [Views](#5-views)
6. [Routes](#6-routes)
7. [Permissions](#7-permissions)
8. [Integration Points](#8-integration-points)
9. [Sample Patient Data Mapping](#9-sample-patient-data-mapping)
10. [Implementation Order](#10-implementation-order)

---

## 1. Objective

Digitize the paper-based physiotherapy assessment and treatment recommendation process. The existing system has **no clinical documentation module** — only a free-text `treatment` field on the `Schedule` model. This feature adds:

- Structured assessment forms (Initial / Follow-up / Discharge)
- Investigation tracking (MRI, X-ray, etc.)
- Treatment plans with goals, precautions, and advice
- Exercise prescriptions with dosage parameters
- Printable clinical reports via browser print (`window.print()`)

---

## 2. Database Models

### 2.1 `assessments` Table

| Column | Type | Constraints | Purpose |
|---|---|---|---|
| `id` | bigint PK | auto-increment | |
| `patient_id` | bigint FK | → `patients.id`, NOT NULL | Auto-populated from Patient |
| `branch_id` | bigint FK | → `branches.id`, NOT NULL | Multi-branch |
| `assessed_by` | bigint FK | → `users.id`, NOT NULL | Physiotherapist who performed assessment |
| `assessment_date` | datetime | NOT NULL | Date/time of assessment |
| `type` | enum('initial','follow-up','discharge') | NOT NULL, default 'initial' | Assessment type |
| `chief_complaints` | longtext | NULL | Primary complaints, onset, duration, aggravating/relieving factors |
| `history_of_present_illness` | longtext | NULL | Occupation history, timeline, progression, past interventions |
| `observation` | longtext | NULL | Posture, gait, swelling, deformity, muscle wasting |
| `palpation` | longtext | NULL | Tenderness points, muscle tone, spasm, trigger points |
| `range_of_motion` | longtext | NULL | Active/passive ROM for relevant joints |
| `muscle_strength` | longtext | NULL | MMT grades per muscle group |
| `special_tests` | longtext | NULL | e.g., SLR, Faber, Compression, Distraction, McMurray |
| `neurological` | longtext | NULL | Reflexes, sensation, dermatomes, myotomes |
| `postural_assessment` | longtext | NULL | Postural deviations, leg length discrepancy |
| `clinical_impression` | longtext | NULL | Summary diagnosis / clinical impression |
| `status` | enum('draft','completed') | NOT NULL, default 'draft' | Workflow status |
| `created_at` | timestamp | nullable | |
| `updated_at` | timestamp | nullable | |
| `isDeleted` | tinyint(1) | default 0 | Soft delete flag |
| `deleted_by` | bigint FK | → `users.id`, nullable | Who deleted it |
| `deleted_at` | timestamp | nullable | When deleted |

### 2.2 `investigations` Table

| Column | Type | Constraints | Purpose |
|---|---|---|---|
| `id` | bigint PK | auto-increment | |
| `assessment_id` | bigint FK | → `assessments.id`, NOT NULL | Parent assessment |
| `type` | varchar(100) | NOT NULL | MRI, X-ray, CT, Blood Work, etc. |
| `investigation_date` | date | NULL | When it was performed |
| `findings` | longtext | NULL | Full text of findings |
| `facility` | varchar(255) | NULL | Where it was done |
| `created_at` | timestamp | nullable | |
| `updated_at` | timestamp | nullable | |
| `isDeleted` | tinyint(1) | default 0 | |
| `deleted_by` | bigint FK | → `users.id`, nullable | |
| `deleted_at` | timestamp | nullable | |

### 2.3 `treatment_plans` Table

| Column | Type | Constraints | Purpose |
|---|---|---|---|
| `id` | bigint PK | auto-increment | |
| `assessment_id` | bigint FK | → `assessments.id`, NOT NULL | Parent assessment |
| `patient_id` | bigint FK | → `patients.id`, NOT NULL | Denormalized for quick access |
| `short_term_goals` | longtext | NULL | e.g., "Reduce pain to 3/10 in 2 weeks" |
| `long_term_goals` | longtext | NULL | e.g., "Return to work without restriction in 8 weeks" |
| `precautions` | longtext | NULL | Forward bending, weight lifting, long sitting, etc. |
| `advice` | longtext | NULL | Posture change, LS belt, western toilet, sleep position, etc. |
| `follow_up_instructions` | longtext | NULL | Frequency of visits, next review date |
| `status` | enum('active','completed','discontinued') | NOT NULL, default 'active' | |
| `created_by` | bigint FK | → `users.id`, NOT NULL | |
| `created_at` | timestamp | nullable | |
| `updated_at` | timestamp | nullable | |
| `isDeleted` | tinyint(1) | default 0 | |
| `deleted_by` | bigint FK | → `users.id`, nullable | |
| `deleted_at` | timestamp | nullable | |

### 2.4 `exercise_prescriptions` Table

| Column | Type | Constraints | Purpose |
|---|---|---|---|
| `id` | bigint PK | auto-increment | |
| `treatment_plan_id` | bigint FK | → `treatment_plans.id`, NOT NULL | Parent treatment plan |
| `exercise_name` | varchar(255) | NOT NULL | Name of the exercise |
| `description` | longtext | NULL | Step-by-step instructions |
| `category` | enum('stretching','strengthening','mobilization','stabilization','balance','gait','postural','breathing','other') | NOT NULL, default 'other' | |
| `sets` | varchar(50) | NULL | e.g., "3" or "2-3" |
| `repetitions` | varchar(50) | NULL | e.g., "10" or "10-15" |
| `frequency` | varchar(100) | NULL | e.g., "3 times/day" or "5 days/week" |
| `duration` | varchar(100) | NULL | e.g., "4 weeks" or "until next review" |
| `precautions` | longtext | NULL | Per-exercise cautions |
| `notes` | longtext | NULL | Additional clinical notes |
| `created_at` | timestamp | nullable | |
| `updated_at` | timestamp | nullable | |
| `isDeleted` | tinyint(1) | default 0 | |
| `deleted_by` | bigint FK | → `users.id`, nullable | |
| `deleted_at` | timestamp | nullable | |

---

## 3. Relationships Diagram

```
Patient (1) ────────── (many) Assessment (1) ────── (many) Investigation
                                │
                                │ (1)
                                │
                          TreatmentPlan (1) ─── (many) ExercisePrescription
                                │
                                │ (belongs to User = created_by)
                                │
                          Schedule (optional FK)
```

Model relationships:

- **Patient** `hasMany` **Assessment**
- **Assessment** `belongsTo` **Patient**, **Branch**, **User** (assessed_by)
- **Assessment** `hasMany` **Investigation**
- **Assessment** `hasOne` **TreatmentPlan**
- **TreatmentPlan** `belongsTo` **Assessment**, **Patient**, **User** (created_by)
- **TreatmentPlan** `hasMany` **ExercisePrescription**
- **ExercisePrescription** `belongsTo` **TreatmentPlan**
- **Schedule** (optional) `belongsTo` **TreatmentPlan**

---

## 4. Controllers

All controllers will follow the existing project pattern:
- Permission-based middleware in constructor
- Trash/bulk operations matching existing standard
- `SoftDeleteWithUser` trait usage

### 4.1 `AssessmentController`

| Method | Description |
|---|---|
| `index()` | DataTable list with branch filter, search by patient name/ID |
| `create()` | Show create form — select patient (AJAX search), auto-fill patient details |
| `store(Request)` | Validate + create assessment |
| `show($id)` | Full assessment view with treatment plan and exercises |
| `edit($id)` | Edit form |
| `update(Request, $id)` | Validate + update |
| `destroy($id)` | Soft delete |
| `trash()` | List trashed assessments |
| `restore($id)` | Restore soft-deleted |
| `forceDelete($id)` | Permanently remove |
| `bulkDestroy()` | Bulk soft delete |
| `bulkRestore()` | Bulk restore |
| `bulkForceDelete()` | Bulk permanent delete |
| `print($id)` | Return browser-print view |

### 4.2 `TreatmentPlanController`

| Method | Description |
|---|---|
| `index()` | List treatment plans (filterable) |
| `create($assessment_id)` | Create plan for a specific assessment |
| `store(Request)` | Validate + create |
| `show($id)` | View plan with exercises |
| `edit($id)` | Edit form |
| `update(Request, $id)` | Validate + update |
| `destroy($id)` | Soft delete |
| Trash/restore/forceDelete/bulk methods | Matching pattern |

### 4.3 `ExercisePrescriptionController`

| Method | Description |
|---|---|
| `store(Request, $treatment_plan_id)` | Add exercise to plan |
| `update(Request, $id)` | Edit exercise |
| `destroy($id)` | Soft delete exercise |
| (Used inline within treatment plan views) |

---

## 5. Views

### 5.1 `resources/views/assessments/`

#### `index.blade.php`
- DataTable with columns: `#`, `Patient Name`, `Patient ID`, `Date`, `Type`, `Assessed By`, `Status`, `Actions`
- Branch filter dropdown
- Export buttons (via DataTable pdfmake)
- Styled per AdminLTE 3 card pattern

#### `create.blade.php`
- **Patient search** (AJAX auto-complete, same as existing OPD pattern)
- **Collapsible card sections** (matching the paper form flow):
  1. **Patient Info** (auto-populated after patient selection)
  2. **Assessment Type & Date**
  3. **Chief Complaints** — large textarea
  4. **History of Present Illness** — large textarea
  5. **Observation** — large textarea
  6. **Palpation** — large textarea
  7. **Range of Motion** — large textarea
  8. **Muscle Strength** — large textarea
  9. **Special Tests** — large textarea
  10. **Neurological** — large textarea
  11. **Postural Assessment** — large textarea
  12. **Clinical Impression** — large textarea
  13. **Investigations** — dynamic sub-form (type, date, findings, facility — add/remove rows via JS)
  14. **Treatment Plan** — inline section (goals, precautions, advice, follow-up)
  15. **Exercises** — dynamic sub-form (name, description, category, sets, reps, frequency, duration, precautions — add/remove rows via JS)

#### `edit.blade.php`
- Same structure as create, pre-filled

#### `show.blade.php`
- **Read-only view** styled as a clinical report card
- Sections displayed as labeled cards
- Treatment plan displayed as a bordered highlight section
- Exercises displayed as a table with dosage parameters
- **Print Button** → triggers `window.print()` view
- **Edit Button** (if permitted)
- **Delete Button** (if permitted)

#### `print.blade.php`
- Clean, minimal layout for browser printing (`@media print` CSS)
- No sidebar, no nav — full-width
- Clinic logo/header + patient info + all assessment sections + treatment plan + exercises
- Follows existing pattern: `resources/views/collections/print.blade.php`

#### `trash.blade.php`
- DataTable of soft-deleted assessments with restore/force-delete actions

### 5.2 Patient Show Integration

Modify `resources/views/patients/show.blade.php`:
- Add a **"Assessments" tab** (Bootstrap tab pane)
- List all assessments for this patient in a table
- Each row: date, type, assessed by, status, action (view / print)
- Button to **"New Assessment"** linking to `assessments.create?patient_id=X`

### 5.3 Dashboard Integration

Modify `HomeController` dashboard view:
- Add an **info box** (AdminLTE small-box) showing "Today's Assessments" count
- Add a **"Recent Assessments" table** below existing dashboard tables
- Each row: Patient name, date, type, assessed by

---

## 6. Routes

```php
// ===== Assessments =====
Route::prefix('assessments')->name('assessments.')->group(function () {
    Route::get('trash', [AssessmentController::class, 'trash'])->name('trash');
    Route::post('bulk-destroy', [AssessmentController::class, 'bulkDestroy'])->name('bulkDestroy');
    Route::post('bulk-restore', [AssessmentController::class, 'bulkRestore'])->name('bulkRestore');
    Route::post('bulk-force-delete', [AssessmentController::class, 'bulkForceDelete'])->name('bulkForceDelete');
});
Route::resource('assessments', AssessmentController::class);
Route::get('assessmentPrint/{assessment}', [AssessmentController::class, 'print'])->name('assessmentPrint');

// ===== Treatment Plans =====
Route::prefix('treatment-plans')->name('treatment-plans.')->group(function () {
    Route::get('trash', [TreatmentPlanController::class, 'trash'])->name('trash');
    Route::post('bulk-destroy', [TreatmentPlanController::class, 'bulkDestroy'])->name('bulkDestroy');
    Route::post('bulk-restore', [TreatmentPlanController::class, 'bulkRestore'])->name('bulkRestore');
    Route::post('bulk-force-delete', [TreatmentPlanController::class, 'bulkForceDelete'])->name('bulkForceDelete');
});
Route::resource('treatment-plans', TreatmentPlanController::class);

// ===== Exercises (nested under treatment plans) =====
Route::post('treatment-plans/{treatment_plan}/exercises', [ExercisePrescriptionController::class, 'store'])
    ->name('treatment-plans.exercises.store');
Route::put('exercises/{exercise}', [ExercisePrescriptionController::class, 'update'])
    ->name('exercises.update');
Route::delete('exercises/{exercise}', [ExercisePrescriptionController::class, 'destroy'])
    ->name('exercises.destroy');
```

---

## 7. Permissions

Seed into `permissions` table (following existing project pattern with `guard_name = 'web'`):

| Permission Name | Description |
|---|---|
| `list-Assessment` | View assessment list |
| `create-Assessment` | Create new assessment |
| `edit-Assessment` | Edit existing assessment |
| `delete-Assessment` | Soft-delete assessment |
| `show-AssessmentProfile` | View full assessment details |
| `print-Assessment` | Print assessment report |
| `list-TreatmentPlan` | View treatment plan list |
| `create-TreatmentPlan` | Create treatment plan |
| `edit-TreatmentPlan` | Edit treatment plan |
| `delete-TreatmentPlan` | Delete treatment plan |

Assign to roles as appropriate (typically `Owner`, `DIRECTOR`, `Admin`, `HomePhysiotherapist`).

---

## 8. Integration Points

| Existing Component | Integration |
|---|---|
| **Patient show page** (`patients/show.blade.php`) | Add "Assessments" tab with list + "New Assessment" button |
| **OPD Registration** (`OpdController`) | Add option to create initial assessment immediately after OPD registration |
| **Dashboard** (`HomeController`) | "Today's Assessments" info box + recent assessments table |
| **Schedule** (`schedules` table) | Optional `treatment_plan_id` FK to link attendance to active plan |
| **Sidebar navigation** (`layouts/parts/sidebar.blade.php`) | Add "Assessments" menu item under Clinical section |
| **Reports** (`resources/views/reports/`) | New "Assessment Summary" report by date range / branch / physiotherapist |

---

## 9. Sample Patient Data Mapping

The provided patient detail maps to the feature as follows:

| Sample Data Field | Feature Component | Database Column |
|---|---|---|
| "Lower back pain, increase from 5 months, aggravates during sitting & laying" | Chief Complaints | `assessments.chief_complaints` |
| "Occupation – Mechanical Engineer. LBP from 2020. Daily walking 4–5 km." | History of Present Illness | `assessments.history_of_present_illness` |
| "Mild B/L hamstring tightness" | Objective: Palpation / ROM | `assessments.palpation` |
| "B/L PSIS pain present" | Objective: Palpation | `assessments.palpation` |
| "L4/L5 L5/S1 mild pain and tenderness present" | Objective: Palpation | `assessments.palpation` |
| "Sacrococcygeal joint pain and tenderness present" | Objective: Palpation | `assessments.palpation` |
| "Spinal extension pain increase" | Objective: ROM / Special Tests | `assessments.range_of_motion` |
| "MRI (L.S. Spine): Disc desiccation at L5-S1, Grade I retrolisthesis, diffuse disc bulge, posterior annular fissure, AP canal 8.8mm" | Investigation | `investigations` (type="MRI", findings=...) |
| "Avoid: Forward bending, Weight lifting, Jerky movement, Long sitting/standing, Sitting below 17 inches height" | Treatment Plan: Precautions | `treatment_plans.precautions` |
| "Advice: Change posture every 40 min, Use LS belt, Use western toilet only, Rest in supine/side lying with pillows" | Treatment Plan: Advice | `treatment_plans.advice` |

---

## 10. Implementation Order

| Step | Task | Files |
|---|---|---|
| 1 | Create migration: `assessments` table | `database/migrations/XXXX_XX_XX_XXXXXX_create_assessments_table.php` |
| 2 | Create migration: `investigations` table | `database/migrations/XXXX_XX_XX_XXXXXX_create_investigations_table.php` |
| 3 | Create migration: `treatment_plans` table | `database/migrations/XXXX_XX_XX_XXXXXX_create_treatment_plans_table.php` |
| 4 | Create migration: `exercise_prescriptions` table | `database/migrations/XXXX_XX_XX_XXXXXX_create_exercise_prescriptions_table.php` |
| 5 | Create Models | `app/Models/Assessment.php`, `Investigation.php`, `TreatmentPlan.php`, `ExercisePrescription.php` |
| 6 | Seed permissions | `database/seeders/AssessmentPermissionsSeeder.php` |
| 7 | Create controllers | `app/Http/Controllers/AssessmentController.php`, `TreatmentPlanController.php`, `ExercisePrescriptionController.php` |
| 8 | Create assessment views | `resources/views/assessments/{index,create,edit,show,print,trash}.blade.php` |
| 9 | Create treatment plan views | `resources/views/treatment_plans/{index,create,edit,show}.blade.php` (or inline in assessment) |
| 10 | Add routes | `routes/web.php` |
| 11 | Modify patient show view | `resources/views/patients/show.blade.php` — add Assessments tab |
| 12 | Modify sidebar navigation | `resources/views/layouts/parts/sidebar.blade.php` |
| 13 | Modify dashboard | `app/Http/Controllers/HomeController.php` + dashboard view |
| 14 | Run migrations + seeders | `php artisan migrate`, `php artisan db:seed --class=AssessmentPermissionsSeeder` |
| 15 | Verify permissions assignment | Assign permissions to roles via UI |
| 16 | Test full workflow | Create assessment → add treatment plan → add exercises → view → print |

---

*Plan saved on: 2026-07-04*
*Project: Rx Physio (Dr. Indolia Physiotherapy Clinic ERP)*
