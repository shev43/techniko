<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MachineCategory extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function getTitleAttribute() {
        return (app()->isLocale('ru')) ? $this->title_ru : $this->title_uk;

    }

    public function machines() {
        return $this->belongsToMany(
            Machine::class,
            'machine_category_machines',
            'category_id',
            'machine_id'
        )->withPivot('is_main', 'order')->where('visible', 1);

    }

}
