<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\SoftDeleteWithUser;

class Assessment extends Model
{
    use HasFactory, SoftDeleteWithUser;

    protected $fillable = [
        'patient_id', 'branch_id', 'assessed_by', 'assessment_date', 'type',
        'chief_complaints', 'history_of_present_illness',
        'observation', 'palpation', 'range_of_motion', 'muscle_strength',
        'special_tests', 'neurological', 'postural_assessment',
        'clinical_impression', 'status',
        'isDeleted', 'deletedBy', 'deleted_at',
    ];

    protected $casts = [
        'assessment_date' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class)->withDefault();
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id')->withDefault();
    }

    public function assessedBy()
    {
        return $this->belongsTo(User::class, 'assessed_by')->withDefault();
    }

    public function investigations()
    {
        return $this->hasMany(Investigation::class);
    }

    public function treatmentPlan()
    {
        return $this->hasOne(TreatmentPlan::class);
    }
}
