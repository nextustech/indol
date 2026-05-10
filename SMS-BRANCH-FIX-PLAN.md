# Patient Observer SMS Branch Information Plan - UPDATED

## Root Cause Confirmed

**Laravel Log shows:**
```
PatientObserver saved: Patient created {"patient_id":14,"was_recently_created":true}
PatientObserver: Branch loaded {"patient_id":14,"branch":null}   // Branch is NULL!
```

**Sequence in Controller and Test:**
```php
$patient = Patient::create($patientData); // saved event fires HERE
$branch_id = $request['branch_id'];
$patient->branches()->attach($branch_id); // Branch attached HERE (AFTER saved)
```

**Problem:** `saved` event fires DURING create(), not AFTER all controller operations. Branch is NULL at that point.

---

## Solution: Use Branch ID from Request Data

### Approach: Pass branch_id through patient data

**Step 1: Modify OpdController.php - Store branch_id in patient data**

In `store()` and `old()` methods:

```php
$patientData = $request->except('branch_id', 'send_sms_patient', 'send_sms_collection');
$patientData['created_by'] = Auth::id();
$patientData['_branch_id'] = $request['branch_id']; // Add this line

$patient = Patient::create($patientData);
$branch_id = $request['branch_id'];
$patient->branches()->attach($branch_id);
```

**Step 2: Modify PatientObserver.php - Load branch from _branch_id**

```php
public function saved(Patient $patient): void
{
    if (!$patient->wasRecentlyCreated) {
        return;
    }

    if (!SmsToggle::shouldSendPatientSms()) {
        return;
    }

    $phone = $patient->mobile ?: $patient->phone;
    if (!$phone) {
        return;
    }

    // Try to load branch from the _branch_id hidden field
    $branch = null;
    if (!empty($patient->_branch_id)) {
        $branch = Branch::find($patient->_branch_id);
    }

    // Fallback: try loaded branches relationship
    if (!$branch) {
        $patient->load('branches');
        $branch = $patient->branches->first();
    }

    $clinicName = $branch?->branchName ?: $this->getSetting('clinic_name', 'Our Clinic');
    $clinicPhone = $branch?->branchPhone ?: $this->getSetting('clinic_phone', '');

    event(new SmsSendingEvent(
        $this->formatPhone($phone),
        'patient_registration',
        [
            'patient_name' => $patient->name,
            'patient_id' => $patient->patientId ?? $patient->id,
            'clinic_name' => $clinicName,
            'clinic_phone' => $clinicPhone
        ],
        $patient
    ));
}
```

---

## Files to Modify

| File | Change |
|------|--------|
| `app/Http/Controllers/OpdController.php` | Add `_branch_id` to patientData |
| `app/Observers/PatientObserver.php` | Check `_branch_id` for branch |

---

## Verification

After fix, log should show:
```
PatientObserver: Branch loaded {"branch":{"name":"Gauri Physiotherapy Pvt. Ltd.","phone":"+91 8559826826"}}
Patient SMS event dispatched {"clinic_name":"Gauri Physiotherapy Pvt. Ltd.","clinic_phone":"+91 8559826826"}
```

---

## Expected SMS Output

> "Hi John, Welcome to Gauri Physiotherapy Pvt. Ltd.! Your registration is confirmed. Patient ID: 0001. Call +91 8559826826 for appointments."

---

Shall I proceed with implementing these changes?