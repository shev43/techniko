<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class MachineCategoryMachine extends Pivot {
    protected $table = 'machine_category_machines';
    public $timestamps = false;
    public $incrementing = true;
}
