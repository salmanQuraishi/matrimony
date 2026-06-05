@extends('layouts.frontend')

@section('title', 'My Profile')

@section('content')
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Header Profile Card -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-sm flex flex-col md:flex-row items-center md:items-start gap-8 relative overflow-hidden">
            <!-- Profile Photo -->
            <div class="relative w-36 h-36 rounded-2xl bg-rose-50 overflow-hidden flex-shrink-0 border-4 border-slate-50 shadow-inner">
                <img src="{{ !empty($authUser['profile']) ? asset($authUser['profile']) : asset('profile/default-avatar.png') }}" 
                     alt="{{ $authUser['name'] }}" 
                     class="w-full h-full object-cover"
                     onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($authUser['name']) }}&background=ffe4e6&color=f43f5e'">
            </div>
            
            <!-- Details -->
            <div class="flex-grow space-y-4 text-center md:text-left min-w-0">
                <div class="space-y-1">
                    <h1 class="font-display font-extrabold text-3xl text-slate-800">{{ $authUser['name'] }}</h1>
                    <p class="text-sm font-bold text-slate-400 uppercase tracking-wider">{{ $authUser['dummyid'] }}</p>
                </div>
                
                <div class="flex flex-wrap justify-center md:justify-start items-center gap-x-6 gap-y-2 text-sm text-slate-500 font-semibold">
                    <span><i class="fa-solid fa-venus-mars text-rose-500 w-4"></i> {{ ucfirst($authUser['gender'] ?? 'N/A') }}</span>
                    <span><i class="fa-solid fa-cake-candles text-rose-500 w-4"></i> {{ $authUser['age'] }} Years ({{ $authUser['dob'] ? date('d-M-Y', strtotime($authUser['dob'])) : 'N/A' }})</span>
                    <span><i class="fa-solid fa-location-dot text-rose-500 w-4"></i> {{ $authUser['city']['name'] ?? 'N/A' }}, {{ $authUser['state']['name'] ?? 'N/A' }}</span>
                </div>

                <div class="flex flex-wrap justify-center md:justify-start gap-3">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-600 border border-rose-100">Profile for: {{ $authUser['profileFor']['name'] ?? 'Self' }}</span>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-600 border border-indigo-100">Completion: {{ $authUser['profile_completion'] }}%</span>
                </div>
            </div>

            <a href="{{ route('user.profile.edit') }}" class="px-5 py-3 rounded-xl bg-gradient-to-r from-rose-500 to-pink-500 text-white font-bold text-sm shadow-md hover:shadow-lg transition-all flex items-center gap-2 hover:-translate-y-0.5">
                <i class="fa-regular fa-pen-to-square text-sm"></i> Edit Profile
            </a>
        </div>

        <!-- Profile Details Sections -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
            
            <!-- Left Side Details (8 cols) -->
            <div class="md:col-span-8 space-y-8">
                
                <!-- About Me -->
                <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm space-y-4">
                    <h3 class="font-display font-bold text-lg text-slate-800 border-b border-slate-50 pb-3"><i class="fa-regular fa-face-smile text-rose-500 mr-2"></i> About Myself</h3>
                    <p class="text-sm text-slate-600 leading-relaxed italic">
                        "{{ $authUser['myself'] ?? 'No description provided yet. Complete your profile to share something about yourself.' }}"
                    </p>
                </div>

                <!-- Basic Info -->
                <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm space-y-4">
                    <h3 class="font-display font-bold text-lg text-slate-800 border-b border-slate-50 pb-3"><i class="fa-regular fa-circle-question text-rose-500 mr-2"></i> Basic Details</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                        <div class="flex justify-between items-center py-2 border-b border-slate-50/50">
                            <span class="text-slate-400 font-semibold">Email</span>
                            <span class="text-slate-700 font-bold">{{ $authUser['email'] ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-slate-50/50">
                            <span class="text-slate-400 font-semibold">Mobile</span>
                            <span class="text-slate-700 font-bold">{{ $authUser['mobile'] ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-slate-50/50">
                            <span class="text-slate-400 font-semibold">Birthplace</span>
                            <span class="text-slate-700 font-bold">{{ $authUser['birthplace'] ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-slate-50/50">
                            <span class="text-slate-400 font-semibold">Address</span>
                            <span class="text-slate-700 font-bold truncate max-w-[150px]">{{ $authUser['address'] ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-slate-50/50">
                            <span class="text-slate-400 font-semibold">Complexion</span>
                            <span class="text-slate-700 font-bold">{{ $authUser['complexion']['name'] ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Religion & Caste -->
                <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm space-y-4">
                    <h3 class="font-display font-bold text-lg text-slate-800 border-b border-slate-50 pb-3"><i class="fa-solid fa-dharmachakra text-rose-500 mr-2"></i> Religious & Caste Details</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                        <div class="flex justify-between items-center py-2 border-b border-slate-50/50">
                            <span class="text-slate-400 font-semibold">Religion</span>
                            <span class="text-slate-700 font-bold">{{ $authUser['relegion']['name'] ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-slate-50/50">
                            <span class="text-slate-400 font-semibold">Caste</span>
                            <span class="text-slate-700 font-bold">{{ $authUser['caste']['name'] ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Professional & Education -->
                <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm space-y-4">
                    <h3 class="font-display font-bold text-lg text-slate-800 border-b border-slate-50 pb-3"><i class="fa-solid fa-briefcase text-rose-500 mr-2"></i> Professional & Education</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                        <div class="flex justify-between items-center py-2 border-b border-slate-50/50">
                            <span class="text-slate-400 font-semibold">Education</span>
                            <span class="text-slate-700 font-bold truncate max-w-[150px]">{{ $authUser['education']['name'] ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-slate-50/50">
                            <span class="text-slate-400 font-semibold">Job Type</span>
                            <span class="text-slate-700 font-bold">{{ $authUser['jobType']['name'] ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-slate-50/50">
                            <span class="text-slate-400 font-semibold">Company Sector</span>
                            <span class="text-slate-700 font-bold">{{ $authUser['companyType']['name'] ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-slate-50/50">
                            <span class="text-slate-400 font-semibold">Occupation</span>
                            <span class="text-slate-700 font-bold truncate max-w-[150px]">{{ $authUser['occupation']['name'] ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-slate-50/50 col-span-1 sm:col-span-2">
                            <span class="text-slate-400 font-semibold">Annual Income Range</span>
                            <span class="text-slate-700 font-bold">{{ $authUser['annualIncome']['range'] ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Family Details -->
                <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm space-y-4">
                    <h3 class="font-display font-bold text-lg text-slate-800 border-b border-slate-50 pb-3"><i class="fa-solid fa-people-roof text-rose-500 mr-2"></i> Family Details</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                        <div class="flex justify-between items-center py-2 border-b border-slate-50/50">
                            <span class="text-slate-400 font-semibold">Father's Name</span>
                            <span class="text-slate-700 font-bold">{{ $authUser['father_name'] ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-slate-50/50">
                            <span class="text-slate-400 font-semibold">Mother's Name</span>
                            <span class="text-slate-700 font-bold">{{ $authUser['mother_name'] ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-slate-50/50">
                            <span class="text-slate-400 font-semibold">Brothers</span>
                            <span class="text-slate-700 font-bold">{{ $authUser['brothers'] ?? '0' }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-slate-50/50">
                            <span class="text-slate-400 font-semibold">Sisters</span>
                            <span class="text-slate-700 font-bold">{{ $authUser['sisters'] ?? '0' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Gallery Grid -->
                <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm space-y-4">
                    <h3 class="font-display font-bold text-lg text-slate-800 border-b border-slate-50 pb-3"><i class="fa-regular fa-image text-rose-500 mr-2"></i> Gallery Photos</h3>
                    
                    @if(empty($authUser['galleries']))
                        <p class="text-sm text-slate-400 italic">No gallery photos uploaded yet.</p>
                    @else
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                            @foreach($authUser['galleries'] as $photo)
                                <div class="relative rounded-2xl overflow-hidden bg-rose-50 aspect-square group shadow-sm border border-slate-100">
                                    <img src="{{ asset($photo['image_path']) }}" alt="Gallery photo" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>

            <!-- Right Side (4 cols) -->
            <div class="md:col-span-4 space-y-8">
                <!-- Physical Attributes -->
                <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm space-y-4">
                    <h3 class="font-display font-bold text-lg text-slate-800 border-b border-slate-50 pb-3"><i class="fa-solid fa-ruler text-rose-500 mr-2"></i> Attributes</h3>
                    
                    <div class="space-y-3.5 text-sm">
                        <div class="flex justify-between items-center py-1.5 border-b border-slate-50/50">
                            <span class="text-slate-400 font-semibold">Height</span>
                            <span class="text-slate-700 font-bold">{{ $authUser['height'] ?? 'N/A' }} Feet</span>
                        </div>
                        <div class="flex justify-between items-center py-1.5 border-b border-slate-50/50">
                            <span class="text-slate-400 font-semibold">Weight</span>
                            <span class="text-slate-700 font-bold">{{ $authUser['weight'] ?? 'N/A' }} Kg</span>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>
@endsection
