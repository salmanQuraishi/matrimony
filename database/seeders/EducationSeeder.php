<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Education;

class EducationSeeder extends Seeder
{

    public function run()
    {
        $educations = ['B.Tech', 'BBA', 'B.Com', 'MBA', 'M.Tech', 'PhD'];

        foreach ($educations as $edu) {
            Education::firstOrCreate(['name' => $edu,'status'=>'show']);
        }
    }

}
