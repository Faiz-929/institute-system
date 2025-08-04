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
    ];
}
