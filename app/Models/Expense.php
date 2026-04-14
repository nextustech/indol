<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    protected $fillable = ['ecat_id','branch_id','user_id','mode_id','date','title','detail','amount'];
    public function ecat(){
        return $this->belongsTo(Ecat::class)->withDefault();
    }
    public function branch(){
        return $this->belongsTo(Branch::class)->withDefault();
    }

    public function mode()
    {
        return $this->belongsTo(Mode::class)->withDefault();
    }
}
