<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\SoftDeleteWithUser;

class AppointmentType extends Model
{
    use HasFactory, SoftDeleteWithUser;

    protected $fillable = [
        'name', 'duration', 'price', 'is_active',
        'isDeleted', 'deletedBy', 'deleted_at',
    ];

    // Many-to-Many with Branches
    public function branches()
    {
        return $this->belongsToMany(Branch::class, 'branch_appointment_type');
    }

    // One-to-Many: Availability Windows
    public function availabilityWindows()
    {
        return $this->hasMany(AvailabilityWindow::class);
    }

    // One-to-Many: Appointments
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
