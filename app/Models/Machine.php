<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Machine extends Model
{
    use HasFactory;
    use SoftDeletes;


    public function getTitleAttribute() {
        return (app()->isLocale('ru')) ? $this->title_ru : $this->title_uk;

    }

    public function machineCategories() {
        return $this->belongsToMany(
            MachineCategory::class,
            'machine_category_machines',
            'machine_id',
            'category_id'
        )->withPivot('is_main', 'order');
    }

    public function reportOrdersByNew() {
        return $this->hasMany(Order::class, 'machine_id', 'id');
    }

    public function technics() {
        return $this->hasMany(Technic::class, 'machine_id', 'id');
    }


}
