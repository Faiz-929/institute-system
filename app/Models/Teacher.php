<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    //
    protected $fillable = [
    'name',
    'qualification',
    'subject',
    'phone',
    'home_phone',
    'address',
];

}
