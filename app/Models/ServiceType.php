<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceType extends Model
{
    use HasFactory;

    protected $guarded =[];

    public function children()
    {
        return $this->hasMany('App\Models\ServiceType', 'parentId');
    }

  	public function collections(){
        return $this->hasMany(Collection::class,'service_type_id');
    }
}
