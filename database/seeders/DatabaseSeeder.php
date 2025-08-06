<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UsersTableSeeder::class);
        $this->call([ReligionSeeder::class, CasteSeeder::class,]);
        $this->call(ProfileTypesSeeder::class);
        $this->call(EducationSeeder::class);
        $this->call(OccupationSeeder::class);
        $this->call(AnnualIncomeSeeder::class);
        $this->call(JobTypeSeeder::class);
        $this->call(CompanyTypeSeeder::class);
        $this->call(TblNotificationSeeder::class);
        $this->call(SettingSeeder::class);
    }
}
