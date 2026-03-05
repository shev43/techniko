<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MachineCategoryMachinesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('machine_category_machines')->insert([
            [
                'category_id' => 1,
                'machine_id' => 1,
                'is_main' => true,
            ],
            [
                'category_id' => 1,
                'machine_id' => 2,
                'is_main' => true,
            ],
            [
                'category_id' => 1,
                'machine_id' => 3,
                'is_main' => true,
            ],
            [
                'category_id' => 1,
                'machine_id' => 4,
                'is_main' => false,
            ],
            [
                'category_id' => 1,
                'machine_id' => 5,
                'is_main' => false,
            ],
            [
                'category_id' => 1,
                'machine_id' => 6,
                'is_main' => false,
            ],
            [
                'category_id' => 1,
                'machine_id' => 7,
                'is_main' => false,
            ],

            //
            [
                'category_id' => 2,
                'machine_id' => 8,
                'is_main' => true,
            ],
            [
                'category_id' => 2,
                'machine_id' => 9,
                'is_main' => true,
            ],
            [
                'category_id' => 2,
                'machine_id' => 10,
                'is_main' => true,
            ],
            [
                'category_id' => 2,
                'machine_id' => 11,
                'is_main' => true,
            ],
            [
                'category_id' => 2,
                'machine_id' => 4,
                'is_main' => false,
            ],
            [
                'category_id' => 2,
                'machine_id' => 12,
                'is_main' => false,
            ],
            [
                'category_id' => 2,
                'machine_id' => 6,
                'is_main' => false,
            ],
            [
                'category_id' => 2,
                'machine_id' => 5,
                'is_main' => false,
            ],
            [
                'category_id' => 2,
                'machine_id' => 7,
                'is_main' => false,
            ],
            [
                'category_id' => 2,
                'machine_id' => 13,
                'is_main' => false,
            ],
            [
                'category_id' => 2,
                'machine_id' => 14,
                'is_main' => false,
            ],

            //
            [
                'category_id' => 3,
                'machine_id' => 13,
                'is_main' => true,
            ],
            [
                'category_id' => 3,
                'machine_id' => 14,
                'is_main' => true,
            ],
            [
                'category_id' => 3,
                'machine_id' => 4,
                'is_main' => false,
            ],
            [
                'category_id' => 3,
                'machine_id' => 15,
                'is_main' => false,
            ],
            [
                'category_id' => 3,
                'machine_id' => 6,
                'is_main' => false,
            ],

            //
            [
                'category_id' => 4,
                'machine_id' => 16,
                'is_main' => true,
            ],
            [
                'category_id' => 4,
                'machine_id' => 17,
                'is_main' => true,
            ],
            [
                'category_id' => 4,
                'machine_id' => 18,
                'is_main' => true,
            ],
            [
                'category_id' => 4,
                'machine_id' => 19,
                'is_main' => true,
            ],
            [
                'category_id' => 4,
                'machine_id' => 5,
                'is_main' => false,
            ],
            [
                'category_id' => 4,
                'machine_id' => 6,
                'is_main' => false,
            ],
            [
                'category_id' => 4,
                'machine_id' => 7,
                'is_main' => false,
            ],
            [
                'category_id' => 4,
                'machine_id' => 20,
                'is_main' => false,
            ],
            [
                'category_id' => 4,
                'machine_id' => 4,
                'is_main' => false,
            ],
            [
                'category_id' => 4,
                'machine_id' => 13,
                'is_main' => false,
            ],
            [
                'category_id' => 4,
                'machine_id' => 14,
                'is_main' => false,
            ],

            //
            [
                'category_id' => 5,
                'machine_id' => 4,
                'is_main' => null,
            ],
            [
                'category_id' => 5,
                'machine_id' => 5,
                'is_main' => null,
            ],
            [
                'category_id' => 5,
                'machine_id' => 7,
                'is_main' => null,
            ],
            [
                'category_id' => 5,
                'machine_id' => 6,
                'is_main' => null,
            ],
            [
                'category_id' => 5,
                'machine_id' => 21,
                'is_main' => null,
            ],
            [
                'category_id' => 5,
                'machine_id' => 12,
                'is_main' => null,
            ],
            [
                'category_id' => 5,
                'machine_id' => 22,
                'is_main' => null,
            ],
            [
                'category_id' => 5,
                'machine_id' => 23,
                'is_main' => null,
            ],
            [
                'category_id' => 5,
                'machine_id' => 24,
                'is_main' => null,
            ],
            [
                'category_id' => 5,
                'machine_id' => 25,
                'is_main' => null,
            ],
        ]);
    }
}
