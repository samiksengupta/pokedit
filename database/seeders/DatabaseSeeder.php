<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(SettingSeeder::class);
        $this->call(VersionSeeder::class);
        $this->call(LanguageSeeder::class);
        $this->call(GenerationSeeder::class);
        $this->call(MoveFlagSeeder::class);
        $this->call(GenderRatioSeeder::class);
    }
}
