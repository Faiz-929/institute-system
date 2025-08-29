<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
        'gender',
        'photo',
        'address',
        'home_phone',
        'mobile_phone',
        'level',
        'major',
        'notes',
         // ✅ الحقول الجديدة
        'parent_name',
        'parent_mobile',
        'parent_whatsapp',
        'parent_home_phone',
        'parent_job',
    ];
}
