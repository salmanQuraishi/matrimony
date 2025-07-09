<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobType;

class JobTypeSeeder extends Seeder
{
    public function run()
    {
        $types = ['Full-time', 'Part-time', 'Freelance', 'Internship', 'Contract'];

        foreach ($types as $type) {
            JobType::create(['name' => $type,'status' => 'show']);
        }
    }
}