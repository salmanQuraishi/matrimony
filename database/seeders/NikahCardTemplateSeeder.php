<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NikahCardTemplate;

class NikahCardTemplateSeeder extends Seeder
{
    public function run(): void
    {
        NikahCardTemplate::insert([
            [
                'name' => 'Template 1',
                'function_name' => 'Template1',
                'image_path' => 'nikah-card/template/templete1.png',
                'status' => 1,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Template 2',
                'function_name' => 'Template2',
                'image_path' => 'nikah-card/template/templete2.png',
                'status' => 1,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Template 3',
                'function_name' => 'Template3',
                'image_path' => 'nikah-card/template/templete3.png',
                'status' => 1,
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}