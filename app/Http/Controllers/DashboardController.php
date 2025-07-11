<?php

namespace App\Http\Controllers;

use App\Models\Religion;
use App\Models\Caste;
use App\Models\Education;
use App\Models\Occupation;
use App\Models\ProfileType;
use App\Models\AnnualIncome;
use App\Models\CompanyType;
use App\Models\JobType;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUser = User::count();

        $totalReligion = Religion::count();

        $totalCaste = Caste::count();

        $totalProfileType = ProfileType::count();

        $totalEducation = Education::count();

        $totalOccupation = Occupation::count();

        $TotalAnnualIncome = AnnualIncome::count();

        $TotalJobType = JobType::count();

        $TotalCompanyType = CompanyType::count();

        $data = compact('totalUser','totalReligion', 'totalCaste','totalProfileType','totalEducation','totalOccupation','TotalAnnualIncome','TotalJobType','TotalCompanyType');
        
        return view('dashboard', $data);
    }
    
}
