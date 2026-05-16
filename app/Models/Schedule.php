<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\SoftDeleteWithUser;

class Schedule extends Model
{
    use HasFactory, SoftDeleteWithUser;

    protected $fillable =['user_id','branch_id','patient_id','pakage_id','title','payment_id','no','sittingDate','visit_order','status','attendedAt','extraSitting','treatment','isDeleted','deletedBy','deleted_at'];

    protected $casts = [
        'visit_order' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class)->withDefault();
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id')->withDefault();
    }
}
