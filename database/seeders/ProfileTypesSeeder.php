<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfileTypesSeeder extends Seeder
{
    public function run()
    {
        $types = ['myself', 'brother', 'sister', 'father'];

        foreach ($types as $type) {
            DB::table('profile_types')->insert([
                'name' => $type,
                'status' => 'show',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}