<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class StudentFee extends Model
{
    protected $fillable = [
        'student_id','title','amount_due','due_date','status','notes'
    ];

    // علاقات
    public function student() {
        return $this->belongsTo(Student::class);
    }

    public function payments() {
        return $this->hasMany(FeePayment::class);
    }

    // مجاميع محسوبة
    public function getPaidTotalAttribute(): float {
        return (float) $this->payments()->sum('amount');
    }

    public function getRemainingAttribute(): float {
        return (float) max(0, $this->amount_due - $this->paid_total);
    }

    // تحديث الحالة تلقائيًا عند الجلب
    protected static function booted()
    {
        static::retrieved(function (StudentFee $fee) {
            $paid = $fee->paid_total;
            $newStatus = $paid <= 0 ? 'pending' : ($paid < $fee->amount_due ? 'partial' : 'paid');
            if ($fee->status !== $newStatus) {
                $fee->status = $newStatus;
                // لا نعمل save هنا لتجنب كثرة الاستدعاءات، يحدَّث عند التعديل أو عبر أمر مجدول لاحقًا.
            }
        });
    }
}
