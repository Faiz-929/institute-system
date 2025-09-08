<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

    class Consumable extends Model 
    {
    protected $fillable = ['name','quantity','unit','workshop_id'];

    public function workshop() {
        return $this->belongsTo(Workshop::class);
    }

    public function assignments() {
        return $this->hasMany(Assignment::class);
    }

    public function stockMovements()
    {
        return $this->morphMany(StockMovement::class, 'material');
    }

}
