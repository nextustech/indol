<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\SoftDeleteWithUser;

class Call extends Model
{
    use HasFactory, SoftDeleteWithUser;

    protected $guarded = [];

    public function patient(){
        return $this->belongsTo(Patient::class)->withDefault();
    }

}
