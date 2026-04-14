<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function patient(){
        return $this->belongsTo(Patient::class)->withDefault();
    }

    public function bills(){
        return $this->hasMany(Bill::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class)->withDefault();
    }

}
