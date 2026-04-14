<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ecat extends Model
{
    use HasFactory;
    protected $fillable = ['name','detail'];

    public function expenses(){
        return $this->hasmany('App\Expense');
    }
}
