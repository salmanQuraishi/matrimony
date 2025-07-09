<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AnnualIncome;

class AnnualIncomeSeeder extends Seeder
{
    public function run()
    {
        $ranges = [
            'Less than ₹10,000',
            '₹10,000 - ₹20,000',
            '₹20,001 - ₹35,000',
            '₹35,001 - ₹50,000',
            '₹50,001 - ₹75,000',
            '₹75,001 - ₹100,000',
            'Over ₹100,000'
        ];

        foreach ($ranges as $range) {
            AnnualIncome::create(['range' => $range,'status'=>'show']);
        }
    }
}