<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    public function configurations() {
        return $this->hasMany(Configuration::class);
    }
}
