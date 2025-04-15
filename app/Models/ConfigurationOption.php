<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfigurationOption extends Model
{
    public function configuration() {
        return $this->belongsTo(Configuration::class);
    }

    public function option() {
        return $this->belongsTo(Option::class);
    }
}
