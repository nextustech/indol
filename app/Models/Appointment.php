<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\SoftDeleteWithUser;

class Appointment extends Model
{
    use HasFactory, SoftDeleteWithUser;

    protected $fillable = [
        'patient_name',
        'email',
        'phone',
        'consultation_topic',
        'branch_id',
        'appointment_type_id',
        'appointment_date',
        'start_time',
        'end_time',
        'status',
        'isDeleted',
        'deletedBy',
        'deleted_at',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }


    // Belongs to Branch
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    // Belongs to Appointment Type
    public function appointmentType()
    {
        return $this->belongsTo(AppointmentType::class);
    }
}
