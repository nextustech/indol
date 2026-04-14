<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'duration', 'price', 'is_active'
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
