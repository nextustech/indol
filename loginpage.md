# Login Page Slow Load - Optimization Plan

## Root Cause Analysis

The main performance issue is in `app/Providers/AppServiceProvider.php:31-39`:

```php
// This runs on EVERY request, including login page!
$optionsQuery = Option::all('option_key', 'option_value');
```

This loads **ALL options** from database on every page load, even for unauthenticated users.

### Additional Issues

| Issue | Location | Impact |
|-------|----------|--------|
| View composer `*` | AppServiceProvider:99-102 | Runs on every view |
| External Google Fonts | login.blade.php:9 | Blocks rendering |
| Multiple CSS/JS files | login.blade.php:11-15 | Slow initial load |
| No asset deferral | login.blade.php:97-101 | Blocks page render |

---

## Optimization Plan

### 1. Fix AppServiceProvider (Main Issue)

**Current Code (Slow):**
```php
$optionsQuery = Option::all('option_key', 'option_value');
$GLOBALS['options'] = $options;
```

**Optimized Code:**
```php
// Only load options when user is authenticated
if (auth()->check()) {
    $options = Cache::remember('user_options_'.auth()->id(), 60, function() {
        return Option::pluck('option_value', 'option_key')->toArray();
    });
    $GLOBALS['options'] = $options;
}
```

**Or use global cache:**
```php
$options = Cache::remember('site_options', 3600, function() {
    return Option::pluck('option_value', 'option_key')->toArray();
});
$GLOBALS['options'] = $options;
```

### 2. Optimize View Composer

**Current:**
```php
view()->composer('*', function ($view) {
    $view->with(['testing_variable' => true]);
});
```

**Optimized:**
```php
// Only apply to authenticated views
view()->composer(['home', 'backend.*', 'layouts.app'], function ($view) {
    $view->with(['testing_variable' => true]);
});
```

### 3. Optimize Login Page Assets

**Add preconnect for external fonts:**
```html
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;700&display=swap" rel="stylesheet">
```

**Defer JavaScript:**
```html
<script src="{{ url('backend/plugins/jquery/jquery.min.js') }}" defer></script>
<script src="{{ url('backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}" defer></script>
<script src="{{ url('backend/js/adminlte.min.js') }}" defer></script>
```

**Remove unused social login buttons** (lines 73-80 in login.blade.php) if not used

### 4. Session Optimization

Ensure database session has proper index:
```sql
CREATE INDEX idx_sessions_expires ON sessions(expires_at);
```

Consider shorter session lifetime for login page:
```php
// .env
SESSION_LIFETIME=120
```

### 5. Asset Bundling (Laravel Mix/Vite)

Create `webpack.mix.js` to combine and minify:
- adminlte.min.css (already minified)
- All plugin CSS
- All JS files

---

## Implementation Checklist

- [ ] Fix AppServiceProvider to only load options for auth users
- [ ] Scope view composer to authenticated views
- [ ] Add preconnect for Google Fonts
- [ ] Add defer attribute to scripts
- [ ] Remove unused social login buttons
- [ ] Add database session index
- [ ] Test login page load time (target: < 1 second)

---

## Expected Results

| Metric | Before | After |
|--------|--------|-------|
| TTFB | ~500-2000ms | < 200ms |
| Page Load | ~3-5s | < 1s |
| DB Queries | Multiple | 0-1 |

---

## Notes

- The main fix is in AppServiceProvider - this alone should reduce load time significantly
- Login page should not load any authenticated user data
- Consider implementing full page caching for public pages