<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mode extends Model
{
    use HasFactory;
    
     public function collections(){
        return $this->hasMany(Collection::class,'mode_id');
    }
    
  	public function expenses(){
        return $this->hasMany(Expense::class,'mode_id');
    }
}
