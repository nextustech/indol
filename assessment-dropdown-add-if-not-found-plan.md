# Assessment Form: Dropdowns with "Add If Not Found"

**Plan: Structured dropdowns on Assessment creation/editing + create-on-demand values**

---

## Table of Contents

1. [Objective](#1-objective)
2. [Current Assessment Form](#2-current-assessment-form)
3. [Target Dropdowns](#3-target-dropdowns)
4. [User Flow (UX)](#4-user-flow-ux)
5. [Data Model](#5-data-model)
6. [Technical Design](#6-technical-design)
7. [Files to Change](#7-files-to-change)
8. [Permissions](#8-permissions)
9. [Validation & Safety](#9-validation--safety)
10. [Phases](#10-phases)

---

## 1. Objective

Improve the **Physiotherapy Assessment** create/edit form so that commonly repeated clinical values are selectable from dropdowns instead of free-text. When the desired value is **not** in the dropdown, the user can add it on the spot; the new value is persisted and becomes available for all future assessments (reuse consistency, avoids typos / duplicate spellings).

Reference: this feature reuses the same "add if not found" approach already planned for the OPD Service Type dropdown in `add-if-not-found-plan.md`.

> **No implementation happens from this document alone.** Each phase requires explicit approval before coding.

---

## 2. Current Assessment Form

File: `resources/views/assessments/create.blade.php` (mirrored in `edit.blade.php`)

| Section | Field | Control today |
|---|---|---|
| Patient Information | Patient | Select2 (AJAX search) |
| Patient Information | Branch | `<select>` from `branches` |
| Patient Information | Assessment Date | `<input type="date">` |
| Patient Information | Type | Hardcoded `<select>` (initial / follow-up / discharge) |
| Patient Information | Status | Hardcoded `<select>` (draft / completed) |
| Chief Complaints | `chief_complaints` | `<textarea>` free text |
| History | `history_of_present_illness` | `<textarea>` |
| Objective Examination | observation / palpation / ROM / MMT / neurological / postural | `<textarea>` free text |
| Objective Examination | `special_tests` | `<textarea>` free text |
| Objective Examination | `clinical_impression` | `<textarea>` free text |
| Investigations | `investigations[i][type]` | `<input type="text">` free text |
| Treatment Plan | short_term_goals / long_term_goals / precautions / advice / follow_up | `<textarea>` |
| Exercises | `exercises[i][exercise_name]` | `<input type="text">` free text |
| Exercises | `exercises[i][category]` | Hardcoded `<select>` (9 options) |

Drop-in candidates for "dropdown + add if not found" (repeated clinical vocabulary, typing-prone):

- Investigation Type (MRI, X-ray, CT, Blood Work, USG...)
- Exercise Name (SLR, Squats, Bridging, McKenzie extension...)
- Exercise Category (fixed but currently duplicated in JS row templates)
- Special Tests (SLR, Faber, Compression, McMurray...)
- Clinical Impression / Diagnosis
- Chief Complaints (major complaints)

---

## 3. Target Dropdowns

### Phase 1 (core — recommended first)

| Field | Lookup group | Control |
|---|---|---|
| Investigation `type` | `investigation_type` | Select2 single-select with "Add new" |
| Exercise `exercise_name` | `exercise_name` | Select2 single-select with "Add new" |
| Exercise `category` | `exercise_category` | Select2 single-select with "Add new" (seed with the 9 existing values) |

Rationale: these are short, standardized, high-repetition values with a **dedicated column** per value (varchar). Small, safe change.

### Phase 2 (optional — validation vocabulary)

| Field | Lookup group | Control |
|---|---|---|
| `special_tests` | `special_test` | Select2 tags (multi) merged into the textarea |
| `clinical_impression` | `clinical_impression` | Select2 tags merged into the textarea |
| `chief_complaints` | `complaint` | Select2 tags merged into the textarea |

Rationale: longtext fields — the dropdown acts as a smart-typed helper; selected tags are appended to the free-text value. Larger UX change; keep separate.

### Excluded (fixed / managed elsewhere — no add-if-not-found)

- **Assessment Type & Status** — stable enums, 2–3 values, no business value in custom values.
- **Branch** — managed by super admin, not an assessment vocabulary.

---

## 4. User Flow (UX)

```
[User types "MRI" in Investigation Type dropdown — no match]
        │
        ▼
Select2 shows "Create option 'MRI'"  (via createTag/tags)
        │
        ▼
User selects that create-option
        │
        ▼
Confirmation prompt:
  "'MRI' not found. Add to master list?"
  [Cancel]  [Add]
        │
        ▼ (confirm)
AJAX POST → dropdown-options.quick { type: investigation_type, name: MRI }
        │
        ▼
Returns { id: 42, name: "MRI", already_exists: bool }
        │
        ▼
Dropdown value set to the new record's canonical name → form stores it
        │
        ▼
Next assessment: "MRI" already appears in the dropdown (no re-typing)
```

> Values are stored as their **name string** in the existing columns (`investigations.type`, `exercises.exercise_name`, textareas) — **no FK schema change** to existing records (see §9).

---

## 5. Data Model

One generic lookup table powers all dropdown groups (extensible; avoids one table per field):

### `dropdown_options` Table

| Column | Type | Constraints | Purpose |
|---|---|---|---|
| `id` | bigint PK | auto-increment | |
| `type` | varchar(50) | NOT NULL, index | Group key (e.g. `investigation_type`, `exercise_name`) |
| `name` | varchar(255) | NOT NULL | Display + stored value |
| `created_by` | bigint FK | → `users.id`, nullable | Who added it |
| `created_at` | timestamp | nullable | |
| `updated_at` | timestamp | nullable | |
| `isDeleted` | tinyint(1) | default 0 | Soft delete flag |
| `deletedBy` | bigint FK | → `users.id`, nullable | |
| `deleted_at` | timestamp | nullable | |

Unique constraint: `UNIQUE(type, name)` — prevents duplicate spelling within a group (case-insensitive lookup on create).

Relationship: none required on existing models (name-string storage). `DropdownOption` model only.

Seeding for Phase 1 (one-time `database/seeders/DropdownOptionSeeder.php`):
- `investigation_type`: MRI, X-ray, CT Scan, Blood Work, USG, ECG, EMG, NCV
- `exercise_category`: stretching, strengthening, mobilization, stabilization, balance, gait, postural, breathing, other (existing enum values)

---

## 6. Technical Design

### 6.1 Backend — generic quick-create endpoint

New `DropdownOptionController` (or method on `AssessmentController`):

```php
public function storeQuick(Request $request)
{
    $request->validate([
        'type' => 'required|string|max:50|in:investigation_type,exercise_name,exercise_category,special_test,clinical_impression,complaint',
        'name' => 'required|string|max:255',
    ]);

    // Reuse existing record (case-insensitive within the group)
    $option = DropdownOption::where('type', $request->type)
        ->whereRaw('LOWER(name) = ?', [strtolower(trim($request->name))])
        ->first();

    if ($option) {
        return response()->json(['id' => $option->id, 'name' => $option->name, 'already_exists' => true]);
    }

    $option = DropdownOption::create([
        'type' => $request->type,
        'name' => trim($request->name),
        'created_by' => Auth::id(),
    ]);

    return response()->json(['id' => $option->id, 'name' => $option->name, 'already_exists' => false]);
}
```

Route (in `routes/web.php` inside the auth group, **before** `Route::resource('assessments', ...)` to match the existing trash-route pattern):

```php
Route::post('dropdown-options/quick', [DropdownOptionController::class, 'storeQuick'])
    ->name('dropdown-options.quick');
```

Optional lookup endpoint for populating dropdowns (server-rendered `<option>`s are fine for small lists — Phase 1 uses eager-loaded options collections passed to the view, no AJAX search needed).

### 6.2 Frontend — reusable Select2 helper (create + edit views)

Add a JS helper used by every target field:

```js
function initAddIfNotFound($el, type) {
    $el.select2({
        tags: true,
        createTag: (p) => ({ id: p.term, text: p.term, isNew: true }),
    });
    $el.on('select2:select', (e) => {
        const d = e.params.data;
        if (!d.isNew) return;
        const confirmed = confirm(`"${d.text}" not found. Add to master list?`);
        if (!confirmed) { $el.val('').trigger('change'); return; }
        $.post('{{ route('dropdown-options.quick') }}', {
                _token: '{{ csrf_token() }}', type, name: d.text,
            })
            .done((res) => $el.val(res.name).trigger('change'))
            .fail(() => { alert('Could not add value.'); $el.val('').trigger('change'); });
    });
}
```

- Investigation `type` field in JS row-append template (`#add-investigation`): render `<input>` + call `initAddIfNotFound` after append.
- Exercise `exercise_name` / `category` in `#add-exercise` template: same wiring.
- `edit.blade.php`: pre-select the current stored value (add matching `<option>` when it is not in the master list yet).

### 6.3 Data flow on submit

- Select2 selected value = canonical `name` string.
- Submits through existing fields unchanged → `AssessmentController@store/update`, `saveInvestigations`, `saveTreatmentPlan` logic stays untouched.
- Empty selection → null / empty (same as today); no new validation required.

---

## 7. Files to Change

| File | Change |
|---|---|
| `database/migrations/XXXX_create_dropdown_options_table.php` | New table |
| `database/seeders/DropdownOptionSeeder.php` | Seed Phase 1 groups |
| `app/Models/DropdownOption.php` | New model (+ soft delete trait like peers) |
| `app/Http/Controllers/DropdownOptionController.php` | `storeQuick()` |
| `routes/web.php` | `dropdown-options/quick` POST route |
| `resources/views/assessments/create.blade.php` | Select2 + helper on investigation type / exercise name / category; re-init on dynamic add |
| `resources/views/assessments/edit.blade.php` | Same, pre-filled current values |
| `app/Http/Controllers/AssessmentController.php` | Pass `$dropdownOptions` groups to views (optional small change) |
| `physiotherapy-assessment-plan.md` | (Optional) keep in sync — tables remain name-string, so no schema impact on assessments |

No FK migration / data back-fill needed in Phase 1 (existing columns keep storing the chosen name strings).

---

## 8. Permissions

- `storeQuick()` reuses **`create-Assessment`** (anyone who can create an assessment may add a missing clinical vocabulary value). Default recommendation.
- Alternative (more restrictive): seed new permission `quick-add-DropdownOption` and assign to `Owner`, `DIRECTOR`, `Admin`, `HomePhysiotherapist`.
- **Default: reuse `create-Assessment`, no new permission.**

---

## 9. Validation & Safety

Key lesson from the OPD patch plan (`add-if-not-found-plan.md`): a raw typed string must **never** be written into an FK column. In this feature:

- Storage is **varchar/text**, not FK → no DB error risk.
- The quick-add endpoint always returns the **canonical name** of the created/reused record → consistent spelling across assessments.
- `storeQuick` is idempotent (reuses case-insensitive match) → no duplicate rows on double-clicks or retries.
- `UNIQUE(type, name)` enforces cleanliness at DB level.

---

## 10. Phases

| Phase | Scope | Approval gate |
|---|---|---|
| **1** | Investigation Type + Exercise Name + Exercise Category dropdowns (create + edit) | Reviewer approval |
| **2** | Special Tests / Clinical Impression / Chief Complaints tag dropdowns merged into textareas | Reviewer approval |

Phase 1 test checklist:
1. Open `assessments/create` → Investigation Type shows seeded list.
2. Type a brand-new value → confirm prompt → value appears in dropdown and is saved with the assessment.
3. Re-open create → new value is in the list (persisted).
4. Add 2nd investigation row → Select2 works on the new row.
5. Same for Exercise name / category; add exercise row case.
6. Edit an existing assessment → current values pre-selected; adding new works.
7. `php artisan migrate` + seeder run clean; no regression on existing assessments.

---

## 11. Implementation Status

- **Phase 1 — implemented (2026-08-15):**
  - `dropdown_options` table + `DropdownOption` model + `DropdownOptionSeeder`
  - `DropdownOptionController@storeQuick` + `dropdown-options/quick` route
  - Investigation Type / Exercise Name / Exercise Category → Select2 add-if-not-found in `create` + `edit` (incl. dynamic rows)
  - Permissions middleware: `create-Assessment`
- **Phase 2 — implemented (2026-08-15):**
  - Added groups `complaint` (8), `special_test` (12), `clinical_impression` (10); `storeQuick` accepts the new types
  - Special Tests / Clinical Impression / Chief Complaints → multi-tag Select2 merged into their textareas (selections persisted into the same text fields)
- Remaining (not requested): permission gate for quick-add beyond `create-Assessment`; AJAX-search-driven dropdowns for very large lists.

---

*Plan saved on: 2026-08-15*
*Project: Rx Physio (Dr. Indolia Physiotherapy Clinic ERP)*