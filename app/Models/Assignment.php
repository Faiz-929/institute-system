<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model 
{
    protected $fillable = 
    [
        'workshop_id',
        'asset_id',
        'consumable_id',
        'assigned_to',
        'assigned_date',
        'return_date',
        'note'
    ];

    public function workshop() {
        return $this->belongsTo(Workshop::class);
    }

    public function asset() {
        return $this->belongsTo(Asset::class);
    }

    public function consumable() {
        return $this->belongsTo(Consumable::class);
    }
}
