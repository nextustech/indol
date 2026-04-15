# Optimization Plan for Indolia Physiotherapy System

## Project Overview
- **Framework**: Laravel 10 (PHP 8.1+)
- **Frontend**: Bootstrap 5 + Blade
- **Auth**: Laravel Sanctum
- **RBAC**: Spatie Permission
- **Type**: Physiotherapy Clinic Management System

---

## 1. Query Performance (High Priority)

### 1.1 N+1 Queries in Dashboard
- **Location**: `HomeController::index()` (lines 40-71)
- **Issue**: Multiple separate queries for daily stats
- **Fix**: Use `selectRaw()` to combine SUM queries into single query

### 1.2 Repeated Branch Access
- **Location**: Multiple controllers (HomeController, PatientController, etc.)
- **Issue**: `loggedUser()->branches->pluck('id')->toArray()` called repeatedly
- **Fix**: Cache branch IDs in request or use accessor

### 1.3 Missing Eager Loading
- **Location**: `Patient`, `Collection`, `Payment` models
- **Issue**: Relationships not eager loaded by default
- **Fix**: Add `with()` in queries or use query scopes

### 1.4 Missing Database Indexes
- **Tables affected**: collections, schedules, payments, patients
- **Fix**: Add compound indexes for frequently queried columns

---

## 2. Architecture Improvements (Medium Priority)

### 2.1 Validation
- **Current**: Inline validation in controllers
- **Recommended**: Create FormRequest classes in `app/Http/Requests/`
- **Files to create**:
  - `StorePatientRequest.php`
  - `StorePaymentRequest.php`
  - `StoreCollectionRequest.php`
  - `UpdateScheduleRequest.php`

### 2.2 Business Logic
- **Current**: Logic embedded in controllers
- **Recommended**: Move to Services in `app/Services/`
- **Services to create**:
  - `CollectionService.php` - collection CRUD & calculations
  - `ReportService.php` - report generation logic
  - `BranchService.php` - branch-related operations
  - `DashboardService.php` - dashboard data aggregation

### 2.3 Duplicate Code
- **Issue**: Branch ID extraction repeated across controllers
- **Solution**: Create reusable trait or helper function

---

## 3. Route Issues

### 3.1 Admin Route Problem
- **Location**: `routes/web.php:24-34`
- **Issue**: `/adm` route creates user on every visit
- **Fix**: Remove or add authentication guard

### 3.2 Duplicate Routes
- **Location**: `routes/web.php:67,73`
- **Issue**: `schedules` resource defined twice
- **Fix**: Remove duplicate line

---

## 4. Database Optimizations

### 4.1 Required Indexes

```sql
-- collections table
CREATE INDEX idx_collection_branch_date ON collections(branch_id, collectionDate);
CREATE INDEX idx_collection_mode_date ON collections(mode_id, collectionDate);

-- schedules table
CREATE INDEX idx_schedule_patient_date ON schedules(patient_id, sittingDate);
CREATE INDEX idx_schedule_branch_date ON schedules(branch_id, sittingDate);

-- payments table
CREATE INDEX idx_payment_branch_active ON payments(branch_id, active);
CREATE INDEX idx_payment_patient ON payments(patient_id);

-- patients table
CREATE INDEX idx_patient_status ON patients(status);
```

### 4.2 Model Query Scopes
Add to respective models:

```php
// Patient.php
public function scopeForUserBranches($query, $branchIds) {
    return $query->whereHas('branches', fn($q) => $q->whereIn('branches.id', $branchIds));
}

// Collection.php
public function scopeByDate($query, $date) {
    return $query->whereDate('collectionDate', $date);
}
```

---

## 5. Caching Implementation

### 5.1 Branch Data Cache
```php
// In helper.php or dedicated service
function getUserBranchIds(): array {
    return Cache::remember('user_branches_'.auth()->id(), 60, function() {
        return loggedUser()->branches->pluck('id')->toArray();
    });
}
```

### 5.2 Dashboard Cache
```php
// Cache daily summaries (15 min for 24 hours)
Cache::remember('daily_summary_'.date('Y-m-d').'_'.auth()->id(), 900, function() {
    return [
        'cash' => ...,
        'online' => ...,
        // ...
    ];
});
```

---

## 6. Code Quality Issues

### 6.1 Duplicate Attribute
- **Location**: `app/Models/Collection.php:12`
- **Issue**: `branch_id` appears twice in `$fillable`
- **Fix**: Remove duplicate

### 6.2 Coding Standards
- Add PHPDoc comments for complex methods
- Use consistent naming (camelCase for methods)
- Add type hints where applicable

---

## 7. Implementation Priority

| Priority | Task | Estimated Time |
|----------|------|----------------|
| P1 | Fix /adm route | 5 min |
| P1 | Add database indexes | 15 min |
| P1 | Optimize HomeController queries | 30 min |
| P2 | Create FormRequest classes | 1 hr |
| P2 | Add caching for branch data | 30 min |
| P2 | Extract to services | 2 hr |
| P3 | Add query scopes to models | 1 hr |

---

## 8. Testing Checklist

After implementing optimizations:
- [ ] Dashboard loads without errors
- [ ] Reports generate correctly
- [ ] Patient search works
- [ ] Collection reports accurate
- [ ] No N+1 in debug bar
- [ ] Pagination works on all pages

---

## Notes

- Follow AGENT.md guidelines for all code changes
- Prefer Laravel-native solutions over custom hacks
- Keep changes minimal and focused
- Test thoroughly after each change