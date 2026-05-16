<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\SoftDeleteWithUser;

class BranchAppointmentType extends Model
{
    use HasFactory, SoftDeleteWithUser;

    public $timestamps = false;

    protected $table = 'branch_appointment_type';

    protected $fillable = [
        'branch_id', 'appointment_type_id',
        'isDeleted', 'deletedBy', 'deleted_at',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function appointmentType()
    {
        return $this->belongsTo(AppointmentType::class, 'appointment_type_id');
    }
}
