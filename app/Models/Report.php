<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    public function technic() {
        return $this->hasOne(Technic::class, 'id', 'technic_id');
    }
}
