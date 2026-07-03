<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LevelsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('levels')->insert([
            [
                'stationId' => '07DA006',
                'levels' => json_encode([1.2, 1.5, 1.8]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'stationId' => '07EA004',
                'levels' => json_encode([2.1, 2.3, 2.7]),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}