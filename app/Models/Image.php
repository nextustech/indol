<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\SoftDeleteWithUser;

class Image extends Model
{
    use HasFactory, SoftDeleteWithUser;

    public function patient(){
        return $this->belongsTo(Patient::class);
    }

}
