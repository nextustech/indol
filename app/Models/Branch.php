<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $guarded =[];
    protected $casts = [
        'restrict_weekend_sittings' => 'boolean',
    ];

    public function patients()
    {
        return $this->belongsToMany(Patient::class)->withPivot('branch_id');
    }

    public function users(){
        return $this->belongsToMany(User::class);
    }

     public function appointmentTypes()
    {
        return $this->belongsToMany(AppointmentType::class, 'branch_appointment_type');
    }

    // One-to-Many: Availability Windows
    public function availabilityWindows()
    {
        return $this->hasMany(AvailabilityWindow::class);
    }

    // One-to-Many: Holidays
    public function holidays()
    {
        return $this->hasMany(Holiday::class);
    }

    // One-to-Many: Appointments
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
