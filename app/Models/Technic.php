<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Technic extends Model {
    use HasFactory;
    use SoftDeletes;

    public function business() {
        return $this->hasOne(Business::class, 'id', 'business_id')->with('seller');
    }

    public function photo() {
        return $this->hasMany(TechnicPhoto::class, 'technic_id', 'id');
    }

    public function order() {
        return $this->belongsTo(Order::class);
    }

    public function reports() {
        return $this->hasMany(Report::class, 'technic_id', 'id');
    }

}
