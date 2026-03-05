<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TestAccountsSeeder extends Seeder
{
    /**
     * Create test customer and business accounts.
     *
     * @return void
     */
    public function run()
    {
        // --- Test Customer 1 ---
        $latestEntry = User::get();
        $profileNumber1 = str_pad(count($latestEntry) + 1, 8, '0', STR_PAD_LEFT);

        DB::table('users')->insert([
            'account_type'   => 2, // client / customer
            'profile_number' => $profileNumber1,
            'first_name'     => 'Тест',
            'last_name'      => 'Клієнт',
            'phone'          => '+380501234567',
            'email'          => null,
            'address'        => null,
            'enabled'        => 1,
            'password'       => Hash::make('password'),
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);

        $this->command->info("Test customer 1 created: +380501234567 (profile #{$profileNumber1})");

        // --- Test Customer 2 ---
        $latestEntry = User::get();
        $profileNumber2 = str_pad(count($latestEntry) + 1, 8, '0', STR_PAD_LEFT);

        DB::table('users')->insert([
            'account_type'   => 2, // client / customer
            'profile_number' => $profileNumber2,
            'first_name'     => 'Тест2',
            'last_name'      => 'Клієнт2',
            'phone'          => '+380501234568',
            'email'          => null,
            'address'        => null,
            'enabled'        => 1,
            'password'       => Hash::make('password'),
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);

        $this->command->info("Test customer 2 created: +380501234568 (profile #{$profileNumber2})");

        // --- Test Business User ---
        $latestEntry = User::get();
        $profileNumber3 = str_pad(count($latestEntry) + 1, 8, '0', STR_PAD_LEFT);

        $businessUserId = DB::table('users')->insertGetId([
            'account_type'   => 3, // partner / business
            'profile_number' => $profileNumber3,
            'first_name'     => 'Тест',
            'last_name'      => 'Бізнес',
            'phone'          => '+380501234569',
            'email'          => 'test@techniko.com',
            'address'        => 'м. Київ, вул. Тестова 1',
            'enabled'        => 1,
            'password'       => Hash::make('password'),
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);

        // Create the linked business record
        $businessId = DB::table('businesses')->insertGetId([
            'user_id'         => $businessUserId,
            'business_number' => str_pad($businessUserId, 8, '0', STR_PAD_LEFT),
            'name'            => 'Тестова Компанія',
            'slug'            => 'testova-kompaniya',
            'phone'           => '+380501234569',
            'email'           => 'test@techniko.com',
            'description'     => 'Тестовий бізнес-акаунт для розробки.',
            'address'         => 'м. Київ, вул. Тестова 1',
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);

        // Create a business contact
        DB::table('business_contacts')->insert([
            'business_id' => $businessId,
            'name'        => 'Тест Бізнес',
            'position'    => 'Директор',
            'phone'       => '+380501234569',
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        $this->command->info("Test business created: test@techniko.com / password (profile #{$profileNumber3})");
        $this->command->info('All test accounts seeded successfully.');
    }
}
