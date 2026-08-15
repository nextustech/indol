<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\SoftDeleteWithUser;

class ExercisePrescription extends Model
{
    use HasFactory, SoftDeleteWithUser;

    protected $fillable = [
        'treatment_plan_id', 'exercise_name', 'description', 'category',
        'sets', 'repetitions', 'frequency', 'duration',
        'precautions', 'notes',
        'isDeleted', 'deletedBy', 'deleted_at',
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public function treatmentPlan()
    {
        return $this->belongsTo(TreatmentPlan::class);
    }
}
