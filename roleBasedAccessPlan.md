# Collections, Expenses, and Schedules - Role-Based Access Control Implementation Plan

## 1. CURRENT ISSUE ANALYSIS

### 1.1 Models & Their `user_id` Fields
| Model | user_id Field | Purpose |
|-------|------------|--------|
| `Collection` | `user_id` | Tracks who created the collection |
| `Expense` | `user_id` | Tracks who created the expense |
| `Schedule` | `user_id` | Tracks who created/assigned the schedule |

### 1.2 Security Risks Currently Present

#### HIGH RISK - No Role-Based Filtering
1. **CollectionController** - All methods fetch all records without user_id filtering:
   - `index()` (line 87): `Collection::all()` - returns ALL collections
   - `collData()` (line 51): No user filtering at all
   - `collectionReport()` (line 348-409): No owner filtering
   - `collectionReportCustom()` (line 423-461): No owner filtering
   - `refundReport()` (line 476-524): No owner filtering
   - `todayCash()` (line 271-328): Only checks `$user->role` and `$user->super`, NOT role name

2. **ExpenseController** - All methods fetch without user_id filtering:
   - `index()` (line 41): Only branch filter, no user filter
   - `expData()` (line 203-224): No user filtering
   - `expenseReport()` (line 236-293): No owner filtering
   - `expenseReportCustom()` (line 304-343): No owner filtering

3. **ScheduleController** - No user-based filtering:
   - `DailyPatients()` (line 400-427): Only branch filter
   - All patient schedule queries have no owner filtering

4. **HomeController** - Dashboard stats show all data:
   - Multiple queries without user filtering
   - Branch-based only, not user-based

### 1.3 Already Working (from Patient analysis)
- `PatientController::index()` filters by `created_by` for HomePhysiotherapist
- `PatientController::show()` restricts access for HomePhysiotherapist

---

## 2. RECOMMENDED ARCHITECTURE

### 2.1 Helper Function for Role Check
Create reusable trait/helper to avoid code duplication:

```php
// app/Helpers/UserAccessHelper.php
<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

trait UserAccessHelper
{
    /**
     * Check if current user is HomePhysiotherapist
     */
    public function isHomePhysiotherapist(): bool
    {
        $user = Auth::user();
        if (!$user) return false;
        
        return $user->roles->pluck('name')->first() === 'HomePhysiotherapist';
    }

    /**
     * Get current user ID
     */
    public function getCurrentUserId(): int
    {
        return Auth::id();
    }

    /**
     * Apply user filtering to query if HomePhysiotherapist
     * Returns modified query
     */
    public function applyUserFilter($query, string $userIdColumn = 'user_id')
    {
        if ($this->isHomePhysiotherapist()) {
            return $query->where($userIdColumn, $this->getCurrentUserId());
        }
        return $query;
    }
}
```

### 2.2 Eloquent Scopes (Recommended)
Add to each model for reusability:

```php
// In Collection Model
public function scopeOwnedBy($query, $userId = null)
{
    if ($userId && $this->isHomePhysiotherapist()) {
        return $query->where('user_id', $userId);
    }
    return $query;
}

// In Expense Model
public function scopeOwnedBy($query, $userId = null)
{
    if ($userId && $this->isHomePhysiotherapist()) {
        return $query->where('user_id', $userId);
    }
    return $query;
}

// In Schedule Model  
public function scopeOwnedBy($query, $userId = null)
{
    if ($userId && $this->isHomePhysiotherapist()) {
        return $query->where('user_id', $userId);
    }
    return $query;
}
```

### 2.3 Middleware Option
Create custom middleware for repeated checks:

```php
// app/Http/Middleware/FilterByUserRole.php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class FilterByUserRole
{
    public function handle(Request $request, Closure $next, string $model): Response
    {
        // Check role and add filtering in queries
        // Can be applied to specific routes
        
        return $next($request);
    }
}
```

---

## 3. FILE-WISE MODIFICATION PLAN

### 3.1 CollectionController.php

| # | Method | Line | Change | Priority |
|---|-------|------|--------|----------|
| 1 | `index()` | 87 | Add user_id filter | HIGH |
| 2 | `collData()` | 51, 62 | Add user_id filter | HIGH |
| 3 | `collectionReport()` | 348 | Add user_id filter | HIGH |
| 4 | `collectionReportCustom()` | 423 | Add user_id filter | HIGH |
| 5 | `refundReport()` | 476 | Add user_id filter | HIGH |
| 6 | `todayCash()` | 271-328 | Fix role check to use role name | MEDIUM |
| 7 | `destroy()` | 207 | Add ownership check | HIGH |
| 8 | `edit()` | 178 | Add ownership check | HIGH |
| 9 | `update()` | 196 | Add ownership check | HIGH |

### 3.2 ExpenseController.php

| # | Method | Line | Change | Priority |
|---|-------|------|--------|----------|
| 1 | `index()` | 41 | Add user_id filter | HIGH |
| 2 | `expData()` | 203 | Add user_id filter | HIGH |
| 3 | `expenseReport()` | 236 | Add user_id filter | HIGH |
| 4 | `expenseReportCustom()` | 304 | Add user_id filter | HIGH |
| 5 | `destroy()` | 178 | Add ownership check | HIGH |
| 6 | `edit()` | 134 | Add ownership check | HIGH |
| 7 | `update()` | 162 | Add ownership check | HIGH |

### 3.3 ScheduleController.php

| # | Method | Line | Change | Priority |
|---|-------|------|--------|----------|
| 1 | `DailyPatients()` | 400 | Add user_id filter | HIGH |
| 2 | `update()` | 170+ | Add ownership check | HIGH |
| 3 | `destroy()` | 354 | Add ownership check | HIGH |

### 3.4 HomeController.php (Dashboard)

| # | Method | Line | Change | Priority |
|---|-------|------|--------|----------|
| 1 | `index()` | 58-100 | Add user_id filter for stats | HIGH |
| 2 | `todayBranchDetails()` | 230-460 | Add user_id filter | HIGH |
| 3 | `cashToday()` | 299-337 | Add user_id filter | HIGH |
| 4 | `onlineToday()` | 343 | Add user_id filter | HIGH |
| 5 | `patientToday()` | 354-362 | Add user_id filter | HIGH |
| 6 | `todaysPatient()` | 395-405 | Add user_id filter | MEDIUM |

---

## 4. DETAILED IMPLEMENTATION STEPS

### Step 1: Add user_id to Collection/Expense/Schedule on create
All create/store methods already set `user_id = Auth::id()`. Verify:
- `CollectionController::store()` line 151: ✅ Already sets user_id
- `ExpenseController::store()` line 89: ✅ Already sets user_id  
- `ScheduleController::store()` line 77, 105: ✅ Already sets user_id

### Step 2: Add user filtering to Collection queries
Add to `CollectionController`:

```php
// In each method that fetches collections
$user = loggedUser();
if ($user->roles->pluck('name')->first() === 'HomePhysiotherapist') {
    $collections = $collections->where('user_id', $user->id);
}
```

### Step 3: Add user filtering to Expense queries
Add to `ExpenseController`:

```php
// In each method that fetches expenses
$user = loggedUser();
if ($user->roles->pluck('name')->first() === 'HomePhysiotherapist') {
    $expenses = $expenses->where('user_id', $user->id);
}
```

### Step 4: Add user filtering to Schedule queries
Add to `ScheduleController`:

```php
// In each method that fetches schedules
$user = loggedUser();
if ($user->roles->pluck('name')->first() === 'HomePhysiotherapist') {
    $schedules = $schedules->where('user_id', $user->id);
}
```

### Step 5: Add ownership checks for edit/update/delete
Add before operations:

```php
// In edit(), update(), destroy() methods
$user = loggedUser();
if ($user->roles->pluck('name')->first() === 'HomePhysiotherapist') {
    if ($collection->user_id !== $user->id) {
        abort(403, 'Unauthorized access');
    }
}
```

### Step 6: Fix todayCash() role check
Current uses `$user->role` which is numeric. Change to role name check:

```php
// Current (WRONG)
if ($user->role == 1 && $user->super == null) { ... }

// Should be
if ($user->roles->pluck('name')->first() === 'HomePhysiotherapist') { ... }
else {
    // Show all data for admin
}
```

---

## 5. AFFECTED FILES LIST

### Controllers (9 files)
| File | Methods to Modify | Risk Level |
|------|------------------|------------|
| `CollectionController.php` | index, collData, collectionReport, collectionReportCustom, refundReport, todayCash, edit, update, destroy | CRITICAL |
| `ExpenseController.php` | index, expData, expenseReport, expenseReportCustom, edit, update, destroy | CRITICAL |
| `ScheduleController.php` | DailyPatients, edit, update, destroy | CRITICAL |
| `HomeController.php` | index, todayBranchDetails, cashToday, onlineToday, patientToday, todaysPatient | HIGH |
| `PatientController.php` | Already done | DONE |
| `OpdController.php` | Already done | DONE |

### Models (3 files)
| File | Changes Needed |
|------|--------------|
| `Collection.php` | Add `scopeOwnedBy` |
| `Expense.php` | Add `scopeOwnedBy` |
| `Schedule.php` | Add `scopeOwnedBy` |

### Views (Check for data exposure)
| File | Check |
|------|-------|
| `resources/views/collections/*` | Verify no direct model access |
| `resources/views/expenses/*` | Verify no direct model access |
| `resources/views/reports/*` | Verify filtering applied |

---

## 6. SUGGESTED CODE SNIPPETS

### 6.1 CollectionController - index() modification
```php
public function index()
{
    $user = loggedUser();
    $query = Collection::query();

    // Role-based filtering
    if ($user->roles->pluck('name')->first() === 'HomePhysiotherapist') {
        $query->where('user_id', $user->id);
    }

    $collections = $query->latest()->paginate(25);
    return view('collections.index', compact('collections'));
}
```

### 6.2 ExpenseController - index() modification
```php
public function index()
{
    $user = loggedUser();
    $brachesId = loggedUser()->branches->pluck('id')->toArray();

    $query = Expense::whereIn('branch_id', $brachesId);

    // Role-based filtering
    if ($user->roles->pluck('name')->first() === 'HomePhysiotherapist') {
        $query->where('user_id', $user->id);
    }

    $expenses = $query->latest()->paginate(25);
    return view('expenses.index', compact('expenses'));
}
```

### 6.3 ScheduleController - DailyPatients() modification
```php
public function DailyPatients(Request $request)
{
    $from = Carbon::now();
    $to = Carbon::now();
    $start = Carbon::createFromFormat('Y-m-d H', $from->toDateString().' 00');
    $to = Carbon::createFromFormat('Y-m-d H', $to->toDateString().' 23');
    $brachesId = loggedUser()->branches->pluck('id')->toArray();
    $user = loggedUser();

    $query = Schedule::whereIn('branch_id', $brachesId)
        ->whereBetween('sittingDate', [$start, $to])
        ->orderBy('attendedAt', 'asc');

    // Role-based filtering
    if ($user->roles->pluck('name')->first() === 'HomePhysiotherapist') {
        $query->where('user_id', $user->id);
    }

    $DailyPatients = $query->get();
    return view('patients.todaysPatient', compact('DailyPatients'));
}
```

### 6.4 Ownership check for edit/update/destroy
```php
public function edit(Collection $collection)
{
    $user = loggedUser();
    
    // HomePhysiotherapist can only edit their own
    if ($user->roles->pluck('name')->first() === 'HomePhysiotherapist') {
        if ($collection->user_id !== $user->id) {
            abort(403, 'Unauthorized access');
        }
    }
    
    return view('collections.edit', compact('collection'));
}

public function update(Request $request, Collection $collection)
{
    $user = loggedUser();
    
    // HomePhysiotherapist can only update their own
    if ($user->roles->pluck('name')->first() === 'HomePhysiotherapist') {
        if ($collection->user_id !== $user->id) {
            abort(403, 'Unauthorized access');
        }
    }
    
    $collection->update($request->all());
    return redirect()->route('collections.index')->with('message', 'Updated Successfully');
}

public function destroy(Collection $collection)
{
    $user = loggedUser();
    
    // HomePhysiotherapist can only delete their own
    if ($user->roles->pluck('name')->first() === 'HomePhysiotherapist') {
        if ($collection->user_id !== $user->id) {
            abort(403, 'Unauthorized access');
        }
    }
    
    Collection::destroy($collection->id);
    return redirect()->back()->with('message', 'Deleted Successfully');
}
```

---

## 7. SECURITY CHECKLIST

- [ ] All Collection queries have user_id filtering
- [ ] All Expense queries have user_id filtering
- [ ] All Schedule queries have user_id filtering
- [ ] Edit/Update/Destroy have ownership checks
- [ ] Admin role has full access (no filtering)
- [ ] Direct URL/API access is blocked
- [ ] Dashboard stats are filtered for HomePhysiotherapist
- [ ] Reports (collection, expense) are filtered
- [ ] Views don't expose unauthorized data
- [ ] No N+1 query issues with role checks

---

## 8. TESTING SCENARIOS

### As Admin/Super User
1. Login as admin
2. View all collections - should see ALL records
3. View all expenses - should see ALL records
4. View all schedules - should see ALL records
5. Edit any record - should succeed
6. Delete any record - should succeed
7. Access via direct URL - should succeed

### As HomePhysiotherapist
1. Login as HomePhysiotherapist
2. Create collection - check user_id is set to self
3. Create expense - check user_id is set to self
4. Create schedule - check user_id is set to self
5. View collections - should see ONLY own records
6. View expenses - should see ONLY own records
7. View schedules - should see ONLY own records
8. Edit other's collection via direct URL - should get 403
9. Edit own collection via direct URL - should succeed
10. Edit other's collection in list - record should not appear

### Security Tests
1. Try to access `/collections/1/edit` as different user - should block
2. Try to access `/expenses/1/edit` as different user - should block
3. Try API endpoints - should filter correctly
4. Try direct URL with other user's ID - should block

---

## 9. PRODUCTION SAFETY CHECKS

- [ ] Use `$user->id` not `Auth::id()` for consistency with helper
- [ ] Handle null user_id (some old records might not have it)
- [ ] Use `whereNull('user_id')` for old records if needed
- [ ] Check eager loading doesn't break with filters
- [ ] Verify pagination works correctly
- [ ] Test with large datasets (no performance issues)

### Null user_id Handling
```php
// If user is HomePhysiotherapist and old records have null user_id
if ($user->roles->pluck('name')->first() === 'HomePhysiotherapist') {
    $query->where(function($q) use ($user) {
        $q->where('user_id', $user->id)
          ->orWhereNull('user_id');
    });
}
```

---

## 10. IMPLEMENTATION ORDER

1. **Phase 1** - Critical (Controllers)
   - CollectionController - index, store, edit, update, destroy
   - ExpenseController - index, store, edit, update, destroy
   - ScheduleController - create, store, edit, update, destroy

2. **Phase 2** - High (Reports & Lists)
   - All report methods
   - Filtered list views

3. **Phase 3** - Dashboard
   - HomeController stats

4. **Phase 4** - Testing & Verification
   - Manual testing
   - Security verification
   - Performance check

---

## SUMMARY

Total files to modify: **9**
- Controllers: 3 (Collection, Expense, Schedule)
- Dashboard: 1 (HomeController)
- Models: 3 (add scopes)

Total methods to modify: **30+**
- Each query needs user_id filter
- Each edit/update/destroy needs ownership check

Priority: HIGH - This is a security issue that allows unauthorized data access