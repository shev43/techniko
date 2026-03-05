<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            MachineSeeder::class,
            MachineCategorySeeder::class,
            MachineCategoryMachinesSeeder::class,
            NotificationMessagesTableSeeder::class,
            TestAccountsSeeder::class,

        ]);
    }
}
