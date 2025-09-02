<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Workshop extends Model {
    
    protected $fillable = ['name','description','location'];

    public function consumables() {
        return $this->hasMany(Consumable::class);
    }

    public function assets() {
        return $this->hasMany(Asset::class);
    }

    public function assignments() {
        return $this->hasMany(Assignment::class);
    }
}

