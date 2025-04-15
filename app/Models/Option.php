<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    public function configurations()
    {
        return $this->belongsToMany(Configuration::class, 'configuration_options');
    }
}
