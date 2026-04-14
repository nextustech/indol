<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','mode_id','service_type_id','branch_id','patient_id','pakage_id','payment_id','branch_id','collectionDate','amount','discount','refund','refundDate','note','paymentNote'];

    public static function rules($id = '') {
        return [
            'amount'=>'required|integer',
        ];
    }

    public static function messages($id = '') {
        return [
            'amount.required' => 'Amount Can not be blank',
            'amount.integer' => 'Amount Can Only in Numeric',
        ];
    }


    public function user(){
        return $this->belongsTo(User::class)->withDefault();
    }

    public function patient(){
        return $this->belongsTo(Patient::class)->withDefault();
    }
    public function branch(){
        return $this->belongsTo(Branch::class)->withDefault();
    }

    public function serviceType()
    {
        return $this->belongsTo(ServiceType::class)->withDefault();
    }

    public function mode()
    {
        return $this->belongsTo(Mode::class)->withDefault();
    }
    public function payment(){
        return $this->belongsTo(Payment::class)->withDefault();
    }

}
