<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\GenderRatio;
use Illuminate\Database\Seeder;

class GenderRatioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        GenderRatio::insert([
            [
                'slug' => 'genderless',
                'value' => 255,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'slug' => 'only-female',
                'value' => 254,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'slug' => 'mostly-female',
                'value' => 225,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'slug' => 'usually-female',
                'value' => 191,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'slug' => 'equal',
                'value' => 127,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'slug' => 'usually-male',
                'value' => 63,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'slug' => 'mostly-male',
                'value' => 31,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'slug' => 'only-male',
                'value' => 0,
                'created_at' => $now,
                'updated_at' => $now
            ],
        ]);
    }
}
