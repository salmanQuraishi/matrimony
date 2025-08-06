<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WebSetting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        WebSetting::create([
            'title' => 'My Website',
            'email' => 'dummy@gmail.com',
            'mobile' => '9876543210',
            'address' => '123, Web Street, Internet City',
            'logo' => null,
            'logo_dark' => null,
            'favicon' => null,
        ]);
    }
}