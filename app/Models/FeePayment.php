<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeePayment extends Model
{
    protected $fillable = [
        'student_fee_id','amount','paid_at','method','reference','received_by','note'
    ];

    public function fee() {
        return $this->belongsTo(StudentFee::class, 'student_fee_id');
    }

    public function receiver() {
        return $this->belongsTo(User::class, 'received_by');
    }
}
