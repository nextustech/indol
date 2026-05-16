<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\SoftDeleteWithUser;

class Ecat extends Model
{
    use HasFactory, SoftDeleteWithUser;
    protected $fillable = ['name','detail','isDeleted','deletedBy','deleted_at'];

    public function expenses(){
        return $this->hasmany('App\Expense');
    }
}
