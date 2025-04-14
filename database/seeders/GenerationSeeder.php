<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Generation;
use Illuminate\Database\Seeder;

class GenerationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        Generation::insert([
            [
                'slug' => 'generation-i',
                'version_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'slug' => 'generation-ii',
                'version_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'slug' => 'generation-iii',
                'version_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'slug' => 'generation-iv',
                'version_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'slug' => 'generation-v',
                'version_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'slug' => 'generation-vi',
                'version_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'slug' => 'generation-vii',
                'version_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'slug' => 'generation-viii',
                'version_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
        ]);
    }
}
