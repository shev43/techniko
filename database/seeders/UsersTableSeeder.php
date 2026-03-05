<?php

    namespace Database\Seeders;

    use App\Models\User;
    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\DB;

    class UsersTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $latestEntry = User::get();

        DB::table('users')->insert([
            'account_type' => 0,
            'profile_number' => str_pad(($latestEntry) ? count($latestEntry) + 1 : 1, 8, "0", STR_PAD_LEFT),
            'first_name' => 'Rustam',
            'last_name' => 'Rustamov',
            'email' => 'info@art-delight.com',
            'phone' => null,
            'address' => null,
            'enabled' => 0,
            'password' => bcrypt('megaP@ssw0rd!'),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        $latestEntry = User::get();

        DB::table('users')->insert([
            'account_type' => 0,
            'profile_number' => str_pad(($latestEntry) ? count($latestEntry) + 1 : 1, 8, "0", STR_PAD_LEFT),
            'first_name' => 'Богдан',
            'last_name' => 'Заровецкий',
            'email' => 'pipetkagroup@gmail.com',
            'phone' => null,
            'address' => null,
            'enabled' => 0,
            'password' => bcrypt('Pipetochka2022!'),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);



    }
}
