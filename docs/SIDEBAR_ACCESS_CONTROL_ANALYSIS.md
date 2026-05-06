# Sidebar Menu Access Control System - Analysis & Implementation Plan
## Role: HomePhysiotherapist

---

## 1. Current Access Analysis

### Sidebar Menu Items & Current Protection Status

| # | Menu Item | Sub-items | Current Protection | Vulnerable |
|---|----------|-----------|-------------------|------------|
| 1 | Dashboard | - | None | YES |
| 2 | OPD | Register Patient, Old OPD | `@can('Opd-Registration')` | YES |
| 3 | Patients | List, Search | `@can('list-Patient')` | PARTIAL |
| 4 | **Expenses** | List, Add, Categories | `@can('list-Expense')` | NO |
| 5 | Hide Patients | Search, Hidden | `@can('Hide-Patients')` | YES |
| 6 | Roles & Permissions | Roles, Permissions | `@role()` | YES |
| 7 | Users | List, Add | `@role()` | YES |
| 8 | Invoices | invoice | None | YES |
| 9 | **Branches** | List, Add | None | **CRITICAL** |
| 10 | **Payment Modes** | List, Add | None | **CRITICAL** |
| 11 | Tele Calling | - | None | YES |
| 12 | **Service Types** | List, Add | None | **CRITICAL** |
| 13 | Reports | Multiple | None | PARTIAL |
| 14 | Custom Range | - | `permission:` | PARTIAL |
| 15 | **Website Settings** | Multiple | None | **CRITICAL** |
| 16 | **Zoom Meetings** | All, Create | None | **CRITICAL** |
| 17 | **Contact Messages** | Messages | None | **CRITICAL** |
| 18 | **Settings** | Base | None | **CRITICAL** |

---

## 2. Risk/Security Findings

### CRITICAL ISSUES FOUND:

1. **No Route-Level Protection** - Direct URL access bypasses sidebar
2. **Insufficient Role-Based Menu Hiding** - Only uses `@can` (permission-based)
3. **Missing Backend Filtering** - Branch/Payment Mode/Service Type/Setting routes accessible
4. **No Read-Only Enforcement** - Edit/Delete allowed beyond scope

### Controllers with Existing Filtering:

| Controller | Methods Protected | Filter Field |
|-----------|--------------|------------|
| HomeController | index, today* | `user_id` |
| PatientController | index, show, search* | `created_by` |
| CollectionController | index, edit, update, destroy | `user_id` |
| ExpenseController | index, edit, update, destroy | `user_id` |
| ScheduleController | edit, update, destroy, Daily* | `user_id` |

---

## 3. Recommended Access Structure

### For HomePhysiotherapist:

| Menu Item | Access | Data Restriction |
|----------|--------|-----------------|
| Dashboard | Full | Own data only |
| OPD | Full | Own patients |
| Patients | Read | Own patients only |
| Expenses | Full | Own expenses only |
| Invoices | Read | Own patients only |
| Reports | Read | Own data only |
| Log Out | Full | - |

### Items to HIDE:
- Hide Patients
- Roles & Permissions  
- Users
- Branches
- Payment Modes
- Service Types
- Tele Calling
- Website Settings
- Zoom Meetings
- Contact Messages
- Settings

---

## 4. Implementation Plan

### Phase 1: Files Created

1. ✅ **MenuHelper.php** - Central menu permission configuration
2. ✅ **leftsidebar.blade.php** - Role-based menu visibility
3. ✅ **HomePhysiotherapistMiddleware.php** - Role restriction middleware
4. ✅ **RestrictToOwnData.php** - Data ownership validation
5. ✅ **Kernel.php** - Middleware registration
6. ✅ **HomePhysiotherapistTrait.php** - User model trait
7. ✅ **User.php** - Updated with trait

### Phase 2: Route Protection

```php
// Add to routes/web.php

// Protect admin routes from HomePhysiotherapist
Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::resource('branches', ...);
    Route::resource('modes', ...);
    Route::resource('servicetypes', ...);
});

// Allow HomePhysiotherapist to own data routes
Route::middleware(['auth', 'ownData'])->group(function () {
    Route::resource('patients', ...);
    Route::resource('expenses', ...);
    Route::resource('collection', ...);
});
```

### Phase 3: Controller Enhancements

Replace inline checks with trait methods:

```php
// Before
if ($user->roles->pluck('name')->first() === 'HomePhysiotherapist') {
    $query->where('user_id', $user->id);
}

// After  
$query->ownData();
```

---

## 5. Testing Checklist

### Manual Testing:

- [ ] Login as HomePhysiotherapist
- [ ] Verify sidebar shows only allowed menus
- [ ] Try direct URL `/branches` → Should redirect/403
- [ ] Try direct URL `/patients` → Should show only own
- [ ] Try direct URL `/expenses` → Should show only own
- [ ] Try editing other user's patient → Should 403
- [ ] Try accessing `/admin/*` → Should 403

### Automated Tests:

```php
test('home_physio_cannot_access_admin_routes', function () {
    $user = create(HomePhysiotherapist::class);
    
    $this->actingAs($user);
    
    expect('/branches')->toBeDenied();
});

test('home_physio_can_only_see_own_data', function () {
    $user = create(HomePhysiotherapist::class);
    $otherUser = create(User::class);
    
    $ownExpense = create(Expense::class, ['user_id' => $user->id]);
    $otherExpense = create(Expense::class, ['user_id' => $otherUser->id]);
    
    expect($user->expenses)->toContain($ownExpense);
    expect($user->expenses)->not->toContain($otherExpense);
});
```

---

## 6. Best Practices

### Scalable Role-Based Sidebar Management:

1. **Central Config** - Use MenuHelper for all menu permissions
2. **Middleware Layers** - Route + Controller + Query filtering
3. **Trait-Based Reuse** - Share logic across models
4. **Blade Helpers** - Clean conditional rendering
5. **Audit Logging** - Log unauthorized access attempts

### Code Structure:

```
app/
├── Helpers/
│   └── MenuHelper.php          # Menu config
├── Http/
│   └── Middleware/
│       ├── HomePhysiotherapistMiddleware.php
│       └── RestrictToOwnData.php
├── Models/
│   └── Traits/
│       └── HomePhysiotherapistTrait.php
└── Providers/
    └── MenuServiceProvider.php  # Register helpers
```

---

## 7. Summary

### Changes Made:
- Created 7 new files for access control
- Updated sidebar with role-based visibility
- Added middleware for route protection
- Enhanced User model with reusable trait

### Remaining Work:
- Apply route middleware to web.php
- Refactor controllers to use trait
- Add automated tests
- Monitor logs for unauthorized attempts