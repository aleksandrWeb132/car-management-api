<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    public function car() {
        return $this->belongsTo(Car::class);
    }

    public function prices() {
        return $this->hasMany(Price::class);
    }

    public function options() {
        return $this->belongsToMany(Option::class, 'configuration_options');
    }
}
