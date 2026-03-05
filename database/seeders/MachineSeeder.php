<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MachineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('machines')->insert([
            [
                'id' => 1,
                'slug' => Str::slug('Комбайни'), // Комбайни
                'file' => 'Kombajny.svg',
                'title_uk' => 'Комбайни',
                'title_ru' => 'Комбайни',
            ],
            [
                'id' => 2,
                'slug' => Str::slug('Трактори'), // Трактори
                'file' => 'Traktor.svg',
                'title_uk' => 'Трактори',
                'title_ru' => 'Трактори',
            ],
            [
                'id' => 3,
                'slug' => Str::slug('Оприскувачі'), // Оприскувачі
                'file' => 'Opryskuvach.svg',
                'title_uk' => 'Оприскувачі',
                'title_ru' => 'Оприскувачі',
            ],
            [
                'id' => 4,
                'slug' => Str::slug('Машини заправки'), // Машини заправки
                'file' => 'Mashyny-zapravky.svg',
                'title_uk' => 'Машини заправки',
                'title_ru' => 'Машини заправки',
            ],
            [
                'id' => 5,
                'slug' => Str::slug('Фури'), // Фури
                'file' => 'Fura.svg',
                'title_uk' => 'Фури',
                'title_ru' => 'Фури',
            ],
            [
                'id' => 6,
                'slug' => Str::slug('Самосвали'), // Самосвали
                'file' => 'Samosval.svg',
                'title_uk' => 'Самосвали',
                'title_ru' => 'Самосвали',
            ],
            [
                'id' => 7,
                'slug' => Str::slug('Навантажувачі'), // Навантажувачі
                'file' => 'Navantazhuvach.svg',
                'title_uk' => 'Навантажувачі',
                'title_ru' => 'Навантажувачі',
            ],
            [
                'id' => 8,
                'slug' => Str::slug('Асфальтоукладчик'), // Асфальтоукладчик
                'file' => 'Asfaltoukladchyk.svg',
                'title_uk' => 'Асфальтоукладчик',
                'title_ru' => 'Асфальтоукладчик',
            ],
            [
                'id' => 9,
                'slug' => Str::slug('Грейдер'), // Грейдер
                'file' => 'Grejder.svg',
                'title_uk' => 'Грейдер',
                'title_ru' => 'Грейдер',
            ],
            [
                'id' => 10,
                'slug' => Str::slug('Каток'), // Каток
                'file' => 'Katok.svg',
                'title_uk' => 'Каток',
                'title_ru' => 'Каток',
            ],
            [
                'id' => 11,
                'slug' => Str::slug('Техніка для стабілізації грунтів'), // Техніка для стабілізації грунтів
                'file' => 'Tekhnika-dla-stabilizatsii-gruntiv.svg',
                'title_uk' => 'Техніка для стабілізації грунтів',
                'title_ru' => 'Техніка для стабілізації грунтів',
            ],
            [
                'id' => 12,
                'slug' => Str::slug('Машини з водою'), // Машини з водою
                'file' => 'Mashyna-z-wodoju.svg',
                'title_uk' => 'Машини з водою',
                'title_ru' => 'Машини з водою',
            ],
            [
                'id' => 13,
                'slug' => Str::slug('Екскаватори'), // Екскаватори
                'file' => 'Ekskawator.svg',
                'title_uk' => 'Екскаватори',
                'title_ru' => 'Екскаватори',
            ],
            [
                'id' => 14,
                'slug' => Str::slug('Бульдозери'), // Бульдозери
                'file' => 'Buldozer.svg',
                'title_uk' => 'Бульдозери',
                'title_ru' => 'Бульдозери',
            ],
            [
                'id' => 15,
                'slug' => Str::slug('Трали'), // Трали
                'file' => 'Traly.svg',
                'title_uk' => 'Трали',
                'title_ru' => 'Трали',
            ],
            [
                'id' => 16,
                'slug' => Str::slug('Бетоновози'), // Бетоновози
                'file' => 'Betonovozy.svg',
                'title_uk' => 'Бетоновози',
                'title_ru' => 'Бетоновози',
            ],
            [
                'id' => 17,
                'slug' => Str::slug('Бетононасоси'), // Бетононасоси
                'file' => 'Betononasos.svg',
                'title_uk' => 'Бетононасоси',
                'title_ru' => 'Бетононасоси',
            ],
            [
                'id' => 18,
                'slug' => Str::slug('Крани'), // Крани
                'file' => 'Krany.svg',
                'title_uk' => 'Крани',
                'title_ru' => 'Крани',
            ],
            [
                'id' => 19,
                'slug' => Str::slug('Ямобури'), // Ямобури
                'file' => 'Yamobury.svg',
                'title_uk' => 'Ямобури',
                'title_ru' => 'Ямобури',
            ],
            [
                'id' => 20,
                'slug' => Str::slug('Маніпулятори'), // Маніпулятори
                'file' => 'Manipuliator.svg',
                'title_uk' => 'Маніпулятори',
                'title_ru' => 'Маніпулятори',
            ],
            [
                'id' => 21,
                'slug' => Str::slug('Асенізатори'), // Асенізатори
                'file' => 'Asenizator.svg',
                'title_uk' => 'Асенізатори',
                'title_ru' => 'Асенізатори',
            ],
            [
                'id' => 22,
                'slug' => Str::slug('Сміттєвоз'), // Сміттєвоз
                'file' => 'Smittievoz.svg',
                'title_uk' => 'Сміттєвоз',
                'title_ru' => 'Сміттєвоз',
            ],
            [
                'id' => 23,
                'slug' => Str::slug('Судна'), // Судна
                'file' => 'Sudna.svg',
                'title_uk' => 'Судна',
                'title_ru' => 'Судна',
            ],
            [
                'id' => 24,
                'slug' => Str::slug('Електрокари'), // Електрокари
                'file' => 'Elektrokary.svg',
                'title_uk' => 'Електрокари',
                'title_ru' => 'Електрокари',
            ],
            [
                'id' => 25,
                'slug' => Str::slug('Автобуси'), // Автобуси
                'file' => 'Avtobus.svg',
                'title_uk' => 'Автобуси',
                'title_ru' => 'Автобуси',
            ],
            [
                'id' => 26,
                'slug' => Str::slug('Інше'), // Інше
                'file' => 'Inshe.svg',
                'title_uk' => 'Інше',
                'title_ru' => 'Інше',
            ],
        ]);
    }
}
