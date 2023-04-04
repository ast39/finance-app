<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder{

    use WithoutModelEvents;


    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(CurrencySeeder::class);
        $this->call(WalletSeeder::class);
        $this->call(SpendCategorySeeder::class);
        $this->call(SpendSeeder::class);
    }
}
