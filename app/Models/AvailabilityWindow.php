<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\SoftDeleteWithUser;

class AvailabilityWindow extends Model
{
    use HasFactory, SoftDeleteWithUser;

     protected $fillable = [
        'branch_id',
        'appointment_type_id',
        'day_of_week',
        'start_time',
        'end_time',
        'slot_duration',
        'capacity',
        'is_active',
        'isDeleted',
        'deletedBy',
        'deleted_at',
    ];

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
