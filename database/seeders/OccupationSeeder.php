<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Occupation;

class OccupationSeeder extends Seeder
{
    public function run()
    {
        $occupations = [
            ['name' => 'Doctor', 'description' => 'Medical professional'],
            ['name' => 'Engineer', 'description' => 'Technical specialist'],
            ['name' => 'Teacher', 'description' => 'Education professional'],
        ];

        foreach ($occupations as $occupation) {
            Occupation::create(array_merge($occupation, ['status' => 'show']));
        }
    }
}