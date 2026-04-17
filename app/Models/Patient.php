<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
   // protected $guarded = [];
    protected $fillable =['name','ref_by','patientId','age','gender','phone','mobile','diagnosis','address','image','date','otherNotes','status'];

    public function branches()
    {
        return $this->belongsToMany(Branch::class);
    }

    public function branchPatients()
    {
        return $this->belongsToMany(Branch::class)->withPivot('branch_id');
    }

    public function schedules(){
        return $this->hasmany(Schedule::class);
    }

    public function payments(){
        return $this->hasmany(Payment::class);
    }

    public function collections(){
        return $this->hasmany(Collection::class);
    }
    public function invoices(){
        return $this->hasmany(Invoice::class);
    }
    public function serviceType()
    {
        return $this->belongsTo(ServiceType::class)->withDefault();
    }
    public function calls(){
        return $this->hasmany(Call::class);
    }

    public function images(){
        return $this->hasmany(Image::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }


}
