<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\SoftDeleteWithUser;

class TreatmentPlan extends Model
{
    use HasFactory, SoftDeleteWithUser;

    protected $fillable = [
        'assessment_id', 'patient_id',
        'short_term_goals', 'long_term_goals',
        'precautions', 'advice', 'follow_up_instructions',
        'status', 'created_by',
        'isDeleted', 'deletedBy', 'deleted_at',
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class)->withDefault();
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by')->withDefault();
    }

    public function exercises()
    {
        return $this->hasMany(ExercisePrescription::class, 'treatment_plan_id');
    }
}
