<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\MoveFlag;
use Illuminate\Database\Seeder;

class MoveFlagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        MoveFlag::insert([
            [
                'slug' => 'contact',
                'code' => 'a',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'slug' => 'can-protect',
                'code' => 'b',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'slug' => 'can-magic-coat',
                'code' => 'c',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'slug' => 'can-snatch',
                'code' => 'd',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'slug' => 'can-mirror-move',
                'code' => 'e',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'slug' => 'can-kings-rock',
                'code' => 'f',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'slug' => 'thaws-user',
                'code' => 'g',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'slug' => 'high-critical-hit-rate',
                'code' => 'h',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'slug' => 'biting',
                'code' => 'i',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'slug' => 'punching',
                'code' => 'j',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'slug' => 'sound',
                'code' => 'k',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'slug' => 'powder',
                'code' => 'l',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'slug' => 'pulse',
                'code' => 'm',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'slug' => 'bomb',
                'code' => 'n',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'slug' => 'dance',
                'code' => 'o',
                'created_at' => $now,
                'updated_at' => $now
            ],
        ]);
    }
}
