<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        Language::insert([
            [
                'slug' => 'ja-Hrkt',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'slug' => 'roomaji',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'slug' => 'ko',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'slug' => 'zh-Hant',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'slug' => 'fr',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'slug' => 'de',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'slug' => 'es',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'slug' => 'it',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'slug' => 'en',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'slug' => 'cs',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'slug' => 'ja',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'slug' => 'zh-Hans',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'slug' => 'pt-BR',
                'created_at' => $now,
                'updated_at' => $now
            ],
        ]);
    }
}
