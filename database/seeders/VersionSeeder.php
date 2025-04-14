<?php

namespace Database\Seeders;

use App\Models\Version;
use Illuminate\Database\Seeder;

class VersionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Version::create([
            'slug' => 'bdsp-classic',
            'pokeapi_version_group' => 'omega-ruby-alpha-sapphire',
        ]);
    }
}
