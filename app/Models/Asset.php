<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model 
{
    protected $fillable = ['name','serial_number','purchase_date','status','workshop_id'];

    public function workshop() {
        return $this->belongsTo(Workshop::class);
    }

    public function assignments() {
        return $this->hasMany(Assignment::class);
    }
}