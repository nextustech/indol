# "Add If Not Found" Feature for Dropdowns

**Plan: Create-on-demand (Select2 "add to database") for dropdown lists**

---

## Table of Contents

1. [Problem Statement](#1-problem-statement)
2. [Target Dropdowns](#2-target-dropdowns)
3. [User Flow (UX)](#3-user-flow-ux)
4. [Technical Design](#4-technical-design)
5. [Files to Change](#5-files-to-change)
6. [Permissions](#6-permissions)
7. [Phases](#7-phases)

---

## 1. Problem Statement

**Current behavior (broken):**

The OPD Service Type dropdown in `resources/views/opd/create.blade.php` already enables `tags: true` and a `createTag` callback (lines 143–175). When a user types a value not in the list, Select2 creates a "tag" whose `id` is the **raw typed text** (e.g. `"Knee Rehab"`).

This raw string is then submitted as `service_type_id` into `OpdController@store` (line 196) and `OpdController@old` (lines 377, 405, 421):

```php
$payment->service_type_id = $type;  // $type = raw string like "Knee Rehab"
```

Consequences:
- `payments.service_type_id` and `collections.service_type_id` are FK columns → a non-numeric string causes a **database error** (or silently corrupts data if no FK constraint exists).
- **No `service_types` record is ever created** — the new value is lost.

**Desired behavior:**
1. User types in the dropdown search box.
2. No match found → a prompt appears: **"Add 'Knee Rehab' to the database?"**
3. User confirms → a new `ServiceType` record is created → the dropdown selects it → form uses its real numeric ID.

---

## 2. Target Dropdowns

### Phase 1 (Primary) — Service Type dropdown in OPD

- `#serviceType` in `resources/views/opd/create.blade.php` (wraps both `opd/new.blade.php` and `opd/old.blade.php`)
- Applies to both **new patient registration** and **old patient follow-up**
- Best candidate because the `tags: true` + `createTag` infrastructure already exists.

### Phase 2 (Optional) — Referred By & Diagnosis

- `ref_by` and `diagnosis` are currently **free-text inputs** in `opd/new.blade.php` (lines 144, 149) and `patients/edit.blade.php` (lines 63, 66).
- To make these "add if not found" dropdowns, we need **new lookup tables**:
  - `referrals` table (`name` unique)
  - `diagnoses` table (`name` unique)
- This is more invasive (new tables + relationships + migration of existing free-text values). Recommended as a separate phase.

---

## 3. User Flow (UX)

```
[User types "Knee Rehab" in Service dropdown]
        │
        ▼
Select2 shows "Create option 'Knee Rehab'" (already happens via createTag)
        │
        ▼
User selects the create-option
        │
        ▼
Confirmation modal appears:
  "Knee Rehab not found in the database."
  [Cancel]  [Add to database]
        │
        ▼ (confirm)
AJAX POST → servicetypes.quick { name: "Knee Rehab", amount, days }
        │
        ▼
Returns { id: 42, name: "Knee Rehab" }
        │
        ▼
Dropdown value set to 42; auto-fills amount/days fields
        │
        ▼
Form submitted → service_type_id = 42 (valid FK)
```

---

## 4. Technical Design

### 4.1 Backend — quick-create endpoint

Add `storeQuick(Request $request)` to `ServiceTypeController`:

```php
public function storeQuick(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'amount' => 'nullable|numeric',
        'days' => 'nullable|integer',
    ]);

    // Reuse existing record if it already exists (case-insensitive)
    $service = ServiceType::whereRaw('LOWER(name) = ?', [strtolower($request->name)])->first();
    if ($service) {
        return response()->json(['id' => $service->id, 'name' => $service->name, 'already_exists' => true]);
    }

    $service = ServiceType::create([
        'name' => $request->name,
        'amount' => $request->amount ?? 0,
        'days' => $request->days ?? 1,
        'parentId' => null,
    ]);

    return response()->json(['id' => $service->id, 'name' => $service->name, 'already_exists' => false]);
}
```

Route (in `routes/web.php`, inside auth group):

```php
Route::post('servicetypes/quick', [App\Http\Controllers\ServiceTypeController::class, 'storeQuick'])->name('servicetypes.quick');
```

> Note: place this route **before** `Route::resource('servicetypes', ...)` to avoid `{servicetype}` conflicts (matches existing project trash-route pattern).

### 4.2 Frontend — create.blade.php JS changes

Replace the current `#serviceType` Select2 `createTag` handling (lines 143–196) with:

1. **Keep** `tags: true`, `createTag` (marks result with `isNew: true`).
2. On `select2:select`:
   - If `data.isNew === true`:
     - Show confirmation (use existing SweetAlert if bundled, else Bootstrap modal / `confirm()`):
       - Message: `"<name> not found. Add to database?"`
     - If confirmed → `$.ajax({ url: '{{ route("servicetypes.quick") }}', method: 'POST', data: { name, amount, days, _token } })`
     - On success → set `$('#serviceType').val(data.id).trigger('change')` and auto-fill `#serviceTitle`, `#amount`, `#days` from response.
   - If existing record → existing auto-fill logic (lines 177–196) stays unchanged.

### 4.3 Backend — OpdController hardening (fallback)

As a safety net (in case JS fails or a raw string reaches the server), in both `OpdController@store` and `OpdController@old`:

```php
$type = $request['service_type_id'];
if ($type && !is_numeric($type)) {
    // Auto-create the service type on the fly and use its real ID
    $service = ServiceType::firstOrCreate(['name' => $type], ['amount' => 0, 'days' => 1]);
    $type = $service->id;
    $request['service_type_id'] = $type;
}
```

This guarantees `payments.service_type_id` / `collections.service_type_id` always receive a valid integer.

---

## 5. Files to Change

| File | Change |
|---|---|
| `app/Http/Controllers/ServiceTypeController.php` | Add `storeQuick()` method |
| `routes/web.php` | Add `servicetypes/quick` POST route |
| `resources/views/opd/create.blade.php` | Rewrite `#serviceType` Select2 JS: confirm → AJAX → set real ID |
| `app/Http/Controllers/OpdController.php` | Add `is_numeric` fallback in `store()` and `old()` |

**No DB migration needed** for Phase 1 (reuses existing `service_types` table).

---

## 6. Permissions

- Reuse existing `create-ServiceType` permission on `storeQuick()`:

```php
$this->middleware('permission:create-ServiceType', ['only' => ['storeQuick']]);
```

- If finer-grained control is desired (any user may add), a new permission `quick-add-ServiceType` can be seeded. **Default: reuse `create-ServiceType`.**

---

## 7. Phases

### Phase 1 — Service Type dropdown (primary)
1. Add `ServiceTypeController@storeQuick` + route.
2. Update `#serviceType` Select2 JS in `opd/create.blade.php`.
3. Harden `OpdController@store` / `@old` with numeric fallback.
4. Test: new + old patient registration with a brand-new service name.

### Phase 2 — Referred By & Diagnosis (optional, needs approval)
1. Migrations: `referrals`, `diagnoses` tables.
2. Models: `Referral`, `Diagnosis`.
3. Convert `ref_by` / `diagnosis` free-text inputs in OPD + patient edit to Select2 with the same add-if-not-found flow.
4. Backfill existing free-text values into lookup tables.

---

*Plan saved on: 2026-07-04*
*Project: Rx Physio (Dr. Indolia Physiotherapy Clinic ERP)*
