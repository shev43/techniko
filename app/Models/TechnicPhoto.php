<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechnicPhoto extends Model {
    use HasFactory;

    public $timestamps = false;

    public function technic() {
        return $this->belongsToMany(Technic::class);
    }
}
