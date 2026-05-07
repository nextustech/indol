# SMS Notification Implementation Plan
## Complete Architecture for Laravel Application

---

## Executive Summary

Your project has an existing event-based SMS system but with critical issues:
- **Synchronous execution** - blocks patient registration/payment flows
- **No retry mechanism** - failed SMS are lost
- **No logging** - no trackable SMS activity
- **Hardcoded messages** - no template system
- **No admin control** - cannot toggle SMS
- **Duplicate risk** - no deduplication
- **Two SMS providers** - androidSms.php and SmsService.php use different API keys

---

## Phase 1: Foundation (Priority 1 - Critical)

### 1.1 Database Schema Changes

**Create: `database/migrations/XXXX_XX_XX_create_sms_logs_table.php`**

```php
Schema::create('sms_logs', function (Blueprint $table) {
    $table->id();
    $table->string('to', 20);              // Recipient phone
    $table->text('message');              // Message content
    $table->string('template_key', 50)->nullable(); // SMS template identifier
    $table->enum('status', ['pending', 'sent', 'delivered', 'failed', 'cancelled'])->default('pending');
    $table->string('external_id', 100)->nullable();   // External SMS ID
    $table->integer('attempts')->default(0);
    $table->integer('max_attempts')->default(3);
    $table->text('error_message')->nullable();
    $table->morphs('sendable');               // Polymorphic - patient/appointment/payment
    $table->unsignedBigInteger('user_id')->nullable(); // Admin user who triggered (if manual)
    $table->timestamp('sent_at')->nullable();
    $table->timestamp('delivered_at')->nullable();
    $table->timestamps();
    
    $table->index(['to', 'created_at']);
    $table->index(['status', 'created_at']);
    $table->index(['template_key']);
});
```

**Create: `database/migrations/XXXX_XX_XX_create_sms_templates_table.php`**

```php
Schema::create('sms_templates', function (Blueprint $table) {
    $table->id();
    $table->string('key')->unique();           // patient_registration, deposit_received, etc.
    $table->string('name');                 // Display name
    $table->text('content');                 // Template with {{variables}}
    $table->text('description')->nullable();
    $table->boolean('is_active')->default(true);
    $table->integer('priority')->default(0);
    $table->timestamps();
});
```

**Update: `database/migrations/XXXX_XX_XX_add_sms_settings_to_options_table.php`**

```php
// Add to options table via Option model or new settings table
// sms_enabled: 1
// sms_default_device: 0
// sms_rate_limit_per_hour: 100
// sms_retry_attempts: 3
```

---

### 1.2 New Models

**Create: `app/Models/SmsLog.php`**

```php
class SmsLog extends Model
{
    protected $fillable = [
        'to', 'message', 'template_key', 'status',
        'external_id', 'attempts', 'max_attempts',
        'error_message', 'sendable_type', 'sendable_id',
        'user_id', 'sent_at', 'delivered_at'
    ];
    
    public function sendable(); // MorphTo
    public function user();      // BelongsTo
    
    public function scopePending($query);
    public function scopeFailed($query);
}
```

**Create: `app/Models/SmsTemplate.php`**

```php
class SmsTemplate extends Model
{
    protected $fillable = ['key', 'name', 'content', 'description', 'is_active', 'priority'];
    
    public function logs();
    public function scopeActive();
}
```

---

### 1.3 Enhanced SMS Service

**Modify: `app/Services/SmsService.php`**

Key improvements needed:
- Add method to wrap in transaction
- Add logging before/after sending
- Add retry logic
- Add duplicate detection
- Add rate limiting check
- Add queue job dispatching

```php
// New methods to add:
public function sendQueued(SmsLog $smsLog): void;
public function sendWithRetry(string $to, string $message, int $maxAttempts = 3): SmsLog;
public function checkRateLimit(string $to): bool;
public function checkDuplicate(string $to, string $message): ?SmsLog;
```

---

## Phase 2: Queue Implementation (Priority 1 - Critical)

### 2.1 Queue Job

**Create: `app/Jobs/SendSmsJob.php`**

```php
class SendSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    public int $tries = 3;
    public int $backoff = 60; // seconds
    public int $timeout = 30;
    
    public function __construct(
        public SmsLog $smsLog
    ) {}
    
    public function handle(SmsService $smsService): void
    {
        // Update attempt count
        $this->smsLog->increment('attempts');
        
        // Send via API
        $response = $smsService->sendSingleMessage(
            $this->smsLog->to,
            $this->smsLog->message
        );
        
        // Update log with external ID
        $this->smsLog->update([
            'external_id' => $response['ID'] ?? null,
            'status' => 'sent',
            'sent_at' => now()
        ]);
    }
    
    public function failed(Exception $exception): void
    {
        // Log failure - job's max attempts will handle retry
        $this->smsLog->update([
            'error_message' => $exception->getMessage(),
            'status' => $this->smsLog->attempts >= $this->smsLog->max_attempts 
                ? 'failed' 
                : 'pending'
        ]);
    }
}
```

### 2.2 Queue Configuration

**`config/queue.php` - Recommended settings:**

```php
// For LOCAL development:
// 'default' => env('QUEUE_CONNECTION', 'sync'),

// For PRODUCTION:
// 'default' => env('QUEUE_CONNECTION', 'redis'),
```

**`config/database.php`** - Ensure Redis config if using Redis:
```php
'redis' => [
    'client' => env('REDIS_CLIENT', 'phpredis'),
    'default' => [
        'host' => env('REDIS_HOST', '127.0.0.1'),
        'port' => env('REDIS_PORT', 6379),
        'database' => env('REDIS_DB', 0),
    ],
    'queue' => [
        'host' => env('REDIS_HOST', '127.0.0.1'),
        'port' => env('REDIS_PORT', 6379),
        'database' => env('REDIS_QUEUE', 'default'),
    ],
],
```

### 2.3 Supervisor Setup (Production)

**`/etc/supervisor/conf.d/laravel-worker.conf`**

```ini
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/indolia/artisan queue:work redis --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/indolia/storage/logs/worker.log
stopwaitsecs=3600
```

Commands to setup:
```bash
# Start supervisor
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start laravel-worker:*

# Or with multiple queues (recommended for SMS)
command=php /var/www/indolia/artisan queue:work redis --sleep=3 --tries=3 --queue=default,sms,high
```

### 2.4 Queue Worker Startup Script

**Create: `bootstrap/app.php` additions or separate artisan command**

Option A: Use Supervisor with systemd (alternative)

```ini
# /etc/systemd/system/laravel-queue.service
[Unit]
Description=Laravel Queue Worker
After=network.target

[Service]
Type=simple
User=www-data
WorkingDirectory=/var/www/indolia
ExecStart=/usr/bin/php /var/www/indolia/artisan queue:work --sleep=3
Restart=always

[Install]
WantedBy=multi-user.target
```

---

## Phase 3: Template System (Priority 2 - High)

### 3.1 SMS Templates Database Seeder

**Create: `database/seeders/SmsTemplateSeeder.php`**

```php
return [
    [
        'key' => 'patient_registration',
        'name' => 'Patient Registration',
        'content' => "Hi {{patient_name}}, Welcome to {{clinic_name}}! Your registration is confirmed. Patient ID: {{patient_id}}. Call {{clinic_phone}} for appointments.",
    ],
    [
        'key' => 'deposit_received',
        'name' => 'Deposit/Payment Received',
        'content' => "Hi {{patient_name}}, We have received Rs.{{amount}} towards your treatment. Balance: Rs.{{balance}}. Thank you! - {{clinic_name}}",
    ],
    [
        'key' => 'appointment_booked',
        'name' => 'Appointment Booked',
        'content' => "Hi {{patient_name}}, Your appointment is confirmed for {{appointment_date}} at {{appointment_time}} with Dr.{{doctor_name}}. - {{clinic_name}}",
    ],
    [
        'key' => 'appointment_reminder',
        'name' => 'Appointment Reminder',
        'content' => "Reminder: You have an appointment tomorrow at {{appointment_time}} with Dr.{{doctor_name}}. Please arrive 10 min early. - {{clinic_name}}",
    ],
    [
        'key' => 'schedule_update',
        'name' => 'Schedule Update',
        'content' => "Hi {{patient_name}}, Your appointment on {{old_date}} has been rescheduled to {{new_date}} at {{new_time}}. - {{clinic_name}}",
    ],
    [
        'key' => 'due_reminder',
        'name' => 'Due Reminder',
        'content' => "Hi {{patient_name}}, You have an outstanding balance of Rs.{{due_amount}}. Please clear your dues. - {{clinic_name}}",
    ],
    [
        'key' => 'payment_received',
        'name' => 'Payment Received',
        'content' => "Payment Received! Rs.{{amount}} received for Invoice #{{invoice_no}}. Thank you. - {{clinic_name}}",
    ],
    [
        'key' => 'document_ready',
        'name' => 'Document Ready',
        'content' => "Hi {{patient_name}}, Your {{document_type}} is ready for pickup. - {{clinic_name}}",
    ],
];
```

### 3.2 Template Engine Service

**Create: `app/Services/SmsTemplateService.php`**

```php
class SmsTemplateService
{
    public function render(string $templateKey, array $data): string
    {
        $template = SmsTemplate::where('key', $templateKey)->first();
        
        if (!$template || !$template->is_active) {
            return null;
        }
        
        $content = $template->content;
        
        foreach ($data as $key => $value) {
            $content = str_replace("{{{$key}}}", $value, $content);
        }
        
        return $content;
    }
    
    public function getAvailableTemplates(): Collection;
    public function getTemplateByKey(string $key): ?SmsTemplate;
    public function updateTemplate(string $key, array $data): SmsTemplate;
}
```

---

## Phase 4: Event System (Priority 2 - High)

### 4.1 Enhanced Event Classes

**Modify: `app/Events/SmsSendingEvent.php`**

```php
class SmsSendingEvent
{
    public function __construct(
        public string $to,
        public string $templateKey,
        public array $templateData,
        public ?Model $sendable = null,
        public ?User $user = null
    ) {}
}
```

### 4.2 Event Listeners

**Modify: `app/Listeners/SendSmsListener.php`**

```php
class SendSmsListener implements ShouldQueue
{
    public int $tries = 3;
    
    public function __construct(
        public SmsService $smsService,
        public SmsTemplateService $templateService
    ) {}
    
    public function handle(SmsSendingEvent $event): void
    {
        // 1. Check if SMS globally enabled
        if (!settings('sms_enabled')) {
            return;
        }
        
        // 2. Rate limit check
        if (!$this->smsService->checkRateLimit($event->to)) {
            Log::warning("SMS rate limit exceeded for {$event->to}");
            return;
        }
        
        // 3. Check duplicate (within 5 minute window)
        // Configuration: prevent duplicate within X minutes
        $duplicate = $this->smsService->checkDuplicate($event->to, $message);
        if ($duplicate) {
            Log::info("Duplicate SMS skipped", ['log_id' => $duplicate->id]);
            return;
        }
        
        // 4. Render template
        $message = $this->templateService->render(
            $event->templateKey, 
            $event->templateData
        );
        
        if (!$message) {
            Log::warning("SMS template not found or inactive: {$event->templateKey}");
            return;
        }
        
        // 5. Create SMS log
        $smsLog = SmsLog::create([
            'to' => $event->to,
            'message' => $message,
            'template_key' => $event->templateKey,
            'status' => 'pending',
            'sendable_type' => $event->sendable?->getMorphType(),
            'sendable_id' => $event->sendable?->getKey(),
            'user_id' => $event->user?->id,
            'max_attempts' => settings('sms_retry_attempts', 3)
        ]);
        
        // 6. Dispatch to queue
        SendSmsJob::dispatch($smsLog);
    }
    
    // For failed jobs - could add dead letter queue handling
    public function failed(SmsSendingEvent $event, Exception $exception): void
    {
        Log::error("SMS send failed", [
            'to' => $event->to,
            'template' => $event->templateKey,
            'error' => $exception->getMessage()
        ]);
    }
}
```

---

## Phase 5: Observers & Triggers (Priority 2 - High)

### 5.1 Patient Observer

**Create/Update: `app/Observers/PatientObserver.php`**

```php
class PatientObserver
{
    public function created(Patient $patient): void
    {
        if (!$patient->phone && !$patient->mobile) {
            return;
        }
        
        $to = $patient->mobile ?: $patient->phone;
        
        event(new SmsSendingEvent(
            $to,
            'patient_registration',
            [
                'patient_name' => $patient->name,
                'patient_id' => $patient->patientId,
                'clinic_name' => settings('clinic_name', 'Our Clinic'),
                'clinic_phone' => settings('clinic_phone', '')
            ],
            $patient
        ));
    }
    
    public function updated(Patient $patient): void
    {
        // SMS on important updates (optional)
    }
}
```

### 5.2 Collection Observer (Payments/Deposits)

**Modify: `app/Observers/CollectionObserver.php`**

```php
class CollectionObserver
{
    public function created(Collection $collection): void
    {
        $patient = $collection->patient;
        if (!$patient) return;
        
        $to = $patient->mobile ?: $patient->phone;
        
        // Calculate balance
        $balance = $this->calculateBalance($collection->patient_id);
        
        event(new SmsSendingEvent(
            $to,
            'deposit_received',
            [
                'patient_name' => $patient->name,
                'amount' => $collection->amount,
                'balance' => $balance,
                'clinic_name' => settings('clinic_name', 'Our Clinic')
            ],
            $collection
        ));
    }
    
    private function calculateBalance(int $patientId): float
    {
        // Logic to calculate remaining balance
    }
}
```

### 5.3 Appointment Observer

**Create: `app/Observers/AppointmentObserver.php`**

```php
class AppointmentObserver
{
    public function created(Appointment $appointment): void
    {
        // Booking confirmation
        event(new SmsSendingEvent(
            $appointment->phone,
            'appointment_booked',
            [
                'patient_name' => $appointment->patient_name,
                'appointment_date' => $appointment->appointment_date,
                'appointment_time' => $appointment->start_time,
                'doctor_name' => $appointment->appointmentType?->name,
                'clinic_name' => settings('clinic_name')
            ],
            $appointment
        ));
    }
    
    public function updated(Appointment $appointment): void
    {
        if ($appointment->isDirty(['appointment_date', 'start_time', 'end_time'])) {
            // Schedule update
            event(new SmsSendingEvent(
                $appointment->phone,
                'schedule_update',
                [
                    'patient_name' => $appointment->patient_name,
                    'old_date' => $appointment->getOriginal('appointment_date'),
                    'new_date' => $appointment->appointment_date,
                    'new_time' => $appointment->start_time,
                    'clinic_name' => settings('clinic_name')
                ],
                $appointment
            ));
        }
    }
}
```

### 5.4 Due Reminder Command

**Create: `app/Console/Commands/SendDueReminders.php`**

```php
class SendDueReminders extends Command
{
    protected $signature = 'sms:due-reminder {--days=7 : Days after which to send reminder}';
    
    public function handle(): int
    {
        $days = $this->option('days');
        
        // Find patients with outstanding dues older than X days
        $dues = Collection::whereNull('deleted_at')
            ->where('amount', '>', \DB::raw('(SELECT COALESCE(SUM(amount), 0) FROM payments WHERE patient_id = collections.patient_id)'))
            ->whereDate('collectionDate', '<=', now()->subDays($days))
            ->get();
        
        foreach ($dues as $collection) {
            $patient = $collection->patient;
            event(new SmsSendingEvent(
                $patient->mobile ?: $patient->phone,
                'due_reminder',
                [
                    'patient_name' => $patient->name,
                    'due_amount' => $collection->amount,
                    'clinic_name' => settings('clinic_name')
                ],
                $collection
            ));
        }
        
        return self::SUCCESS;
    }
}
```

---

## Phase 6: Admin Interface (Priority 3 - Medium)

### 6.1 Settings Page Updates

**Add to existing settings controller:**

```php
// In SettingsController or OptionController
public function updateSmsSettings(Request $request)
{
    Option::updateOrCreate(['option_key' => 'sms_enabled'], ['option_value' => $request->sms_enabled]);
    Option::updateOrCreate(['option_key' => 'sms_default_device'], ['option_value' => $request->sms_device]);
    Option::updateOrCreate(['option_key' => 'sms_rate_limit_per_hour'], ['option_value' => $request->rate_limit]);
    
    return back()->with('message', 'SMS Settings Updated');
}
```

### 6.2 SMS Activity Log View

**Create: `resources/views/admin/sms-logs.blade.php`**

- Filter by status, date range, phone
- View message details
- Manual resend failed
- Export to CSV

### 6.3 Template Management View

**Create: `resources/views/admin/sms-templates.blade.php`**

- List all templates
- Edit template content
- Toggle active/inactive
- Preview with sample data

---

## Phase 7: Testing & Monitoring (Priority 3 - Medium)

### 7.1 Commands for Testing

**Create: `app/Console/Commands/TestSms.php`**

```php
class TestSms extends Command
{
    protected $signature = 'sms:test {to : Phone number} {message? : Message}';
    
    public function handle(SmsService $smsService): int
    {
        $to = $this->argument('to');
        $message = $this->argument('message') ?? 'Test message from Laravel SMS System';
        
        try {
            $result = $smsService->sendSingleMessage($to, $message);
            $this->info("SMS sent: " . json_encode($result));
            return self::SUCCESS;
        } catch (Exception $e) {
            $this->error("Failed: " . $e->getMessage());
            return self::FAILURE;
        }
    }
}
```

### 7.2 Queue Monitoring

Add to existing health check or admin dashboard:
- Failed jobs count
- Pending SMS count
- Last successful send time
- API balance (if available)

---

## Files to Create (Summary)

### New Files:
| File | Purpose |
|------|---------|
| `app/Models/SmsLog.php` | SMS activity tracking |
| `app/Models/SmsTemplate.php` | Template storage |
| `app/Services/SmsTemplateService.php` | Template rendering |
| `app/Jobs/SendSmsJob.php` | Queue job for SMS |
| `app/Observers/PatientObserver.php` | Trigger on patient create |
| `app/Observers/CollectionObserver.php` | Trigger on payment |
| `app/Observers/AppointmentObserver.php` | Trigger on booking |
| `app/Console/Commands/TestSms.php` | Testing command |
| `app/Console/Commands/SendDueReminders.php` | Due reminders |
| `database/migrations/*_create_sms_logs_table.php` | SMS log table |
| `database/migrations/*_create_sms_templates_table.php` | Templates table |
| `database/seeders/SmsTemplateSeeder.php` | Default templates |
| `resources/views/admin/sms-logs.blade.php` | Activity view |
| `resources/views/admin/sms-templates.blade.php` | Template management |

### Files to Modify:
| File | Changes |
|------|---------|
| `app/Services/SmsService.php` | Add retry, logging, rate limit |
| `app/Listeners/SendSmsListener.php` | Full rewrite for queue |
| `app/Events/SmsSendingEvent.php` | Add template support |
| `app/Observers/DepositeObserver.php` | Migrate to new system |
| `app/Observers/GuestObserver.php` | Migrate to new system |
| `app/Providers/AppServiceProvider.php` | Register observers |
| `app/Providers/EventServiceProvider.php` | Register events |
| `config/queue.php` | Update default driver |
| `composer.json` | Add autoload for helpers (if needed) |

---

## Implementation Priority & Phasing

### Phase 1 (Week 1): Foundation
- [ ] Database migrations
- [ ] SmsLog & SmsTemplate models
- [ ] Queue job class
- [ ] SmsService enhancements

### Phase 2 (Week 2): Core Implementation
- [ ] Template seeder
- [ ] Template service
- [ ] Enhanced event/listener
- [ ] Observer creation

### Phase 3 (Week 3): Integration
- [ ] Register observers in AppServiceProvider
- [ ] Test with patient registration
- [ ] Test with payment collection
- [ ] Test with appointment

### Phase 4 (Week 4): Admin & Polish
- [ ] Settings toggle
- [ ] Activity log view
- [ ] Template management
- [ ] Supervisor setup (production)
- [ ] Testing commands

---

## Configuration Checklist

### Environment Variables (.env)
```bash
# Queue
QUEUE_CONNECTION=redis  # or database for local, redis for production

# Redis (if using redis)
REDIS_HOST=127.0.0.1
REDIS_PORT=6379
REDIS_QUEUE=default

# SMS Settings (optional - can use DB)
SMS_ENABLED=true
SMS_DEFAULT_DEVICE=0
SMS_RETRY_ATTEMPTS=3
SMS_RATE_LIMIT=100
```

### Supervisor Commands (Production)
```bash
# Install supervisor
sudo apt install supervisor

# Create worker config
sudo nano /etc/supervisor/conf.d/laravel-worker.conf

# Start
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start laravel-worker:*
```

---

## Duplicate Prevention Strategy

1. **Time Window**: Check for duplicate SMS within 5 minutes (configurable)
2. **Content Hash**: Use MD5 of (to + message) within time window
3. **Rate Limiting**: Max X SMS per hour per phone number (configurable)

```php
// In SmsService
public function checkDuplicate(string $to, string $message, int $minutes = 5): ?SmsLog
{
    $hash = md5($to . $message);
    
    return SmsLog::where('to', $to)
        ->where('created_at', '>=', now()->subMinutes($minutes))
        ->whereRaw("MD5(CONCAT(to, message)) = ?", [$hash])
        ->first();
}
```

---

## Error Handling Best Practices

1. **Graceful Degradation**: If SMS fails, log and continue (don't block main flow)
2. **Retry with Backoff**: Exponential backoff between retries
3. **Dead Letter Queue**: After max retries, move to failed jobs table
4. **Alerting**: Log to monitoring system for critical failures
5. **Manual Retry**: Admin can manually retry from SMS logs view

---

## Performance Recommendations

1. **Use Redis Queue**: For production (database is fine for development)
2. **Separate SMS Queue**: Process SMS independently from other jobs
3. **Batch Processing**: For bulk SMS, use chunked processing
4. **Connection Pooling**: Ensure cURL connection reuse in SMS service
5. **Timeout Settings**: 30 second timeout for SMS API calls

---

## Migration from Current System

### Steps to Migrate:
1. Deploy new system with SMS disabled (via setting)
2. Migrate templates to database
3. Enable new system
4. Test all triggers
5. Monitor for 24 hours
6. Decommission old observer triggers

### Keep for Reference (Don't Delete):
- `app/Helpers/androidSms.php` - Keep until fully migrated
- `app/Services/SmsService.php` - Merge into new service

---

## Summary Checklist

- [x] Analyzed existing SMS helper
- [x] Identified current methods and parameters
- [x] Found queue configuration
- [x] Existing events and observers mapped
- [x] Two SMS services identified (need consolidation)
- [ ] Create database schema
- [ ] Build queue job
- [ ] Implement template system
- [ ] Wire up observers
- [ ] Configure queue driver
- [ ] Set up supervisor (production)
- [ ] Create admin views
- [ ] Test end-to-end

---

**Next Action**: Review this plan and let me know which phase you'd like to start with, or if you want me to begin implementation.