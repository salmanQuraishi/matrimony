<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CompanyType;

class CompanyTypeSeeder extends Seeder
{
    public function run()
    {
        $types = ['Private', 'Public', 'NGO', 'Startup', 'Government'];

        foreach ($types as $type) {
            CompanyType::create(['name' => $type,'status' => 'show']);
        }
    }
}