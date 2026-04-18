<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

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
        'status'
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
