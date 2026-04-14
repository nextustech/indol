<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable =['user_id','branch_id','patient_id','pakage_id','title','payment_id','no','sittingDate','visit_order','status','attendedAt','extraSitting','treatment'];

    protected $casts = [
        'visit_order' => 'integer',
    ];

    public function user(){
        return $this->belongsTo(User::class)->withDefault();
    }

    public function patient(){
        return $this->belongsTo(Patient::class)->withDefault();
    }
    public function payment(){
        return $this->belongsTo(Payment::class);
    }

}
