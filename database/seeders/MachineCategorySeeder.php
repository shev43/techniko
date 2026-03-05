<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MachineCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('machine_categories')->insert([
            [
                'id' => 1,
                'slug' => Str::slug('Сільсько-господарська техніка'),
                'title_uk' => 'Сільсько-господарська техніка',
                'title_ru' => 'Сільсько-господарська техніка',
                'has_sections' => true,
            ],
            [
                'id' => 2,
                'slug' => Str::slug('Для дорожного будівництва'),
                'title_uk' => 'Для дорожного будівництва',
                'title_ru' => 'Для дорожного будівництва',
                'has_sections' => true,
            ],
            [
                'id' => 3,
                'slug' => Str::slug('Для земляних буд робіт'),
                'title_uk' => 'Для земляних буд робіт',
                'title_ru' => 'Для земляних буд робіт',
                'has_sections' => true,
            ],
            [
                'id' => 4,
                'slug' => Str::slug('Для будівництва інженерних споруд'),
                'title_uk' => 'Для будівництва інженерних споруд',
                'title_ru' => 'Для будівництва інженерних споруд',
                'has_sections' => true,
            ],
            [
                'id' => 5,
                'slug' => Str::slug('Різні роботи'),
                'title_uk' => 'Різні роботи',
                'title_ru' => 'Різні роботи',
                'has_sections' => false,
            ],
        ]);
    }
}
