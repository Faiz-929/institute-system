<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    // ✅ الحقول المسموح تعبئتها جماعيًا
    protected $fillable = ['name', 'serial_number', 'purchase_date', 'status', 'workshop_id'];

    // ✅ تحويلات تلقائية للحقول (casting)
    protected $casts = [
        'purchase_date' => 'date', // يرجع Carbon instance لسهولة التنسيق
    ];

    // ✅ قاموس الحالات (للاستخدام في القوائم والشارات)
    public const STATUS_LABELS = [
        'available'   => 'متاح',
        'in_use'      => 'قيد الاستخدام',
        'maintenance' => 'صيانة',
        'retired'     => 'مستبعد',
    ];

    // ✅ العلاقات
    public function workshop()
    {
        return $this->belongsTo(Workshop::class);
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
}
