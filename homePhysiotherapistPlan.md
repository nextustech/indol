# HomePhysiotherapist Patient Access Control Plan

## Objective
When user role is `HomePhysiotherapist`, they should only see patients that were added by themselves.

## Current Implementation (Already Working)
- `PatientController::index()` - lines 54-56 filters patients by `created_by`
- `PatientController::show()` - lines 140-144 restricts view access

## Required Changes

### 1. OpdController.php - Store Patient
**Location:** `app/Http/Controllers/OpdController.php:168`

**Current:**
```php
$patient = Patient::create($request->except('branch_id'));
```

**Change to:**
```php
$patient = Patient::create($request->except('branch_id') + ['created_by' => Auth::id()]);
```

---

### 2. PatientController.php - searchP()
**Location:** `app/Http/Controllers/PatientController.php:327-349`

Add HomePhysiotherapist filter before `->get()`:

```php
$user = loggedUser();
if ($user->roles->pluck('name')->first() === 'HomePhysiotherapist') {
    $patients->where('created_by', $user->id);
}
```

---

### 3. PatientController.php - searchPatientByRegDate()
**Location:** `app/Http/Controllers/PatientController.php:371-393`

Add HomePhysiotherapist filter after branch filter:

```php
$user = loggedUser();
if ($user->roles->pluck('name')->first() === 'HomePhysiotherapist') {
    $patients = $patients->where('created_by', $user->id);
}
```

---

### 4. PatientController.php - hiddenPatients()
**Location:** `app/Http/Controllers/PatientController.php:362-365`

**Current:**
```php
$patients = Patient::where('status',1)->latest()->paginate(10);
```

**Change to:**
```php
$user = loggedUser();
$patients = Patient::where('status',1);
if ($user->roles->pluck('name')->first() === 'HomePhysiotherapist') {
    $patients = $patients->where('created_by', $user->id);
}
$patients = $patients->latest()->paginate(10);
```

---

### 5. HomeController.php - listPatientsResult()
**Location:** `app/Http/Controllers/HomeController.php:240-251`

Add HomePhysiotherapist filter:

```php
$user = loggedUser();
$patients = Patient::where('status',null)->whereBetween('date', [$start, $to])->orderBy('date', 'asc');
if ($user->roles->pluck('name')->first() === 'HomePhysiotherapist') {
    $patients = $patients->where('created_by', $user->id);
}
$patients = $patients->get();
```

---

### 6. HomeController.php - hiddenPatientsLists()
**Location:** `app/Http/Controllers/HomeController.php:265-268`

Add HomePhysiotherapist filter:

```php
$user = loggedUser();
$patients = Patient::where('status',1);
if ($user->roles->pluck('name')->first() === 'HomePhysiotherapist') {
    $patients = $patients->where('created_by', $user->id);
}
$patients = $patients->latest()->paginate(10);
```

---

### 7. HomeController.php - duesDetails()
**Location:** `app/Http/Controllers/HomeController.php:271-283`

Add HomePhysiotherapist filter:

```php
$user = loggedUser();
$patients = Patient::with(['branches:id,branchName'])
    ->withSum('payments as total_payable', 'amount')
    ->withSum('collections as total_collection', 'amount')
    ->withSum('collections as total_discount', 'discount')
    ->havingRaw('(COALESCE(total_payable,0) - (COALESCE(total_collection,0) + COALESCE(total_discount,0))) >= 1');

if ($user->roles->pluck('name')->first() === 'HomePhysiotherapist') {
    $patients = $patients->where('created_by', $user->id);
}

$patients = $patients->paginate(120);
```

---

## Summary of Files to Modify
1. `app/Http/Controllers/OpdController.php` - Add `created_by` on patient creation
2. `app/Http/Controllers/PatientController.php` - Add filters in 3 methods
3. `app/Http/Controllers/HomeController.php` - Add filters in 3 methods

## Helper Function
Consider creating a helper to reduce repetition:

```php
// In Patient model or a trait
public function scopeOwnedByUser($query, $user)
{
    if ($user->roles->pluck('name')->first() === 'HomePhysiotherapist') {
        return $query->where('created_by', $user->id);
    }
    return $query;
}
```

Then use: `$patients->ownedByUser($user)`