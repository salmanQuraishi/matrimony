<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Complexion;

class ComplexionSeeder extends Seeder
{
    public function run(): void
    {
        Complexion::insert([

            [
                'name' => 'Very Fair',
                'hindi_name' => 'बहुत गोरा',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Fair',
                'hindi_name' => 'गोरा',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Wheatish',
                'hindi_name' => 'गेहुँआ',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Medium',
                'hindi_name' => 'मध्यम',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Dusky',
                'hindi_name' => 'सांवला',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Dark',
                'hindi_name' => 'गहरा रंग',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}