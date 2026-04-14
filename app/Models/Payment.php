<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','patient_id','date','title','duration','active','amount','paid','service_type_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function patient(){
        return $this->belongsTo(Patient::class);
    }
    public function collections(){
        return $this->hasmany(Collection::class);
    }
	
  	public function branch(){
        return $this->belongsTo(Branch::class);
    }

    public function schedules(){
        return $this->hasmany(Schedule::class);
    }

}
