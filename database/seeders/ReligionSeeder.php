<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Religion;

class ReligionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $religions = ['Hindu', 'Muslim', 'Christian', 'Sikh', 'Buddhist'];

        foreach ($religions as $name) {
            Religion::create(['name' => $name,'status' => 'show']);
        }
    }
}
