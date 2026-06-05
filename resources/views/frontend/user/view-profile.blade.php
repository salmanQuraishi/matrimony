@extends('layouts.frontend')

@section('title', 'Member Profile')

@section('content')
<div class="py-12 bg-[#FBF6EC] min-h-screen">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Navigation back -->
        <div>
            <a href="{{ route('user.matches') }}" class="text-sm font-bold text-[#4A3728]/70 hover:text-[#C9A84C] transition-colors flex items-center gap-1.5 w-fit">
                <i class="fa-solid fa-arrow-left text-xs"></i> Back to Matches
            </a>
        </div>

        <!-- Header Profile Card -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#C9A84C]/20 shadow-sm flex flex-col md:flex-row items-center md:items-start gap-8 relative overflow-hidden">
            <!-- Profile Photo -->
            <div class="relative w-36 h-36 rounded-2xl bg-[#F0E8D0]/40 overflow-hidden flex-shrink-0 border-4 border-[#FBF6EC] shadow-inner">
                <img src="{{ !empty($profile['profile']) ? asset($profile['profile']) : asset('profile/default-avatar.png') }}" 
                     alt="{{ $profile['name'] }}" 
                     class="w-full h-full object-cover"
                     onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($profile['name']) }}&background=F0E8D0&color=0D3B2E'">
            </div>
            
            <!-- Details -->
            <div class="flex-grow space-y-4 text-center md:text-left min-w-0">
                <div class="space-y-1">
                    <h1 class="font-cormorant font-extrabold text-3xl text-[#0D3B2E]">{{ $profile['name'] }}</h1>
                    <p class="text-sm font-bold text-[#4A3728]/60 uppercase tracking-wider">{{ $profile['dummyid'] }}</p>
                </div>
                
                <div class="flex flex-wrap justify-center md:justify-start items-center gap-x-6 gap-y-2 text-sm text-[#4A3728] font-semibold">
                    <span><i class="fa-solid fa-venus-mars text-[#C9A84C] w-4"></i> {{ ucfirst($profile['gender'] ?? 'N/A') }}</span>
                    <span><i class="fa-solid fa-cake-candles text-[#C9A84C] w-4"></i> {{ $profile['age'] }} Years ({{ $profile['dob'] ? date('d-M-Y', strtotime($profile['dob'])) : 'N/A' }})</span>
                    <span><i class="fa-solid fa-location-dot text-[#C9A84C] w-4"></i> {{ $profile['city']['name'] ?? 'N/A' }}, {{ $profile['state']['name'] ?? 'N/A' }}</span>
                </div>

                <div class="flex flex-wrap justify-center md:justify-start gap-3">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-[#F0E8D0]/60 text-[#0D3B2E] border border-[#C9A84C]/20">Profile for: {{ $profile['profileFor']['name'] ?? 'Self' }}</span>
                </div>
            </div>

            <!-- Actions block -->
            <div class="flex flex-col gap-2.5 w-full md:w-auto min-w-[200px]">
                <!-- Like / Shortlist -->
                <form action="{{ route('user.shortlist.toggle', ['likedId' => $profile['id']]) }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit" class="w-full px-5 py-3 rounded-xl border {{ $profile['is_liked'] ?? false ? 'bg-[#F0E8D0]/60 border-[#C9A84C]/35 text-[#8B6914] font-bold' : 'bg-white border-[#C9A84C]/25 text-[#4A3728] hover:text-[#0D3B2E] hover:bg-[#F0E8D0]/30' }} text-sm font-semibold transition-all flex items-center justify-center gap-2 shadow-sm">
                        <i class="{{ $profile['is_liked'] ?? false ? 'fa-solid' : 'fa-regular' }} fa-heart text-base"></i>
                        {{ $profile['is_liked'] ?? false ? 'Shortlisted' : 'Shortlist' }}
                    </button>
                </form>

                <!-- Express Interest Logic -->
                @if(isset($profile['interest_status']) && $profile['interest_status'] === 'accepted')
                    <!-- Already Connected -->
                    <div class="w-full px-5 py-3 rounded-xl bg-[#0D3B2E] text-[#E8D08A] font-bold text-sm flex items-center justify-center gap-2 border border-[#C9A84C]/30">
                        <i class="fa-solid fa-circle-check text-sm text-[#E8D08A]"></i> Connected
                    </div>
                    <a href="{{ route('user.messages') }}" class="w-full px-5 py-3 rounded-xl bg-gradient-to-r from-[#C9A84C] to-[#8B6914] text-[#0D3B2E] font-bold text-sm shadow-md flex items-center justify-center gap-2 hover:-translate-y-0.5 transition-all text-center">
                        <i class="fa-regular fa-comment text-sm"></i> Chat Now
                    </a>
                @elseif(isset($profile['interest_status']) && $profile['interest_status'] === 'pending')
                    @if($profile['interest_sender_id'] == ($authUser['id'] ?? null))
                        <!-- Request Sent (Pending) -->
                        <button type="button" disabled class="w-full px-5 py-3 rounded-xl bg-[#F0E8D0]/80 text-[#8B6914] border border-[#C9A84C]/35 font-bold text-sm flex items-center justify-center gap-2 cursor-not-allowed">
                            <i class="fa-solid fa-hourglass-half text-sm"></i> Request Sent
                        </button>
                    @else
                        <!-- Received request (needs action) -->
                        <div class="flex flex-col gap-2 w-full">
                            <form action="{{ route('user.interests.accept', ['interest' => $profile['interest_id']]) }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit" class="w-full px-5 py-3 rounded-xl bg-gradient-to-r from-[#C9A84C] to-[#8B6914] text-[#0D3B2E] font-bold text-sm shadow-md flex items-center justify-center gap-2 hover:-translate-y-0.5 transition-all">
                                    <i class="fa-solid fa-check text-sm"></i> Accept Request
                                </button>
                            </form>
                            <form action="{{ route('user.interests.reject', ['interest' => $profile['interest_id']]) }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit" class="w-full px-5 py-2 rounded-xl border border-red-200 text-red-500 font-semibold text-xs flex items-center justify-center gap-1.5 shadow-sm hover:bg-red-50">
                                    <i class="fa-solid fa-xmark text-xs"></i> Reject Request
                                </button>
                            </form>
                        </div>
                    @endif
                @else
                    <!-- Send request -->
                    <form action="{{ route('user.interests.send', ['receiver' => $profile['id']]) }}" method="POST" class="w-full">
                        @csrf
                        <button type="submit" class="w-full px-5 py-3 rounded-xl bg-gradient-to-r from-[#C9A84C] to-[#8B6914] text-[#0D3B2E] font-bold text-sm shadow-md shadow-[#C9A84C]/25 hover:shadow-lg transition-all flex items-center justify-center gap-2 hover:-translate-y-0.5">
                            <i class="fa-regular fa-paper-plane text-sm"></i> Send Match Request
                        </button>
                    </form>
                @endif

                @if(!isset($profile['interest_status']) || $profile['interest_status'] !== 'accepted')
                    <!-- Ignore / Block -->
                    <form action="{{ route('user.interests.ignore', ['receiver' => $profile['id']]) }}" method="POST" class="w-full">
                        @csrf
                        <button type="submit" class="w-full px-5 py-2.5 rounded-xl border border-[#C9A84C]/25 hover:border-red-200 text-[#4A3728]/70 hover:text-red-500 text-xs font-semibold transition-all flex items-center justify-center gap-1.5 shadow-sm">
                            <i class="fa-solid fa-ban text-xs"></i> Ignore Profile
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Details grid -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
            
            <!-- Details fields (8 cols) -->
            <div class="md:col-span-8 space-y-8">
                
                <!-- About -->
                <div class="bg-white rounded-3xl p-8 border border-[#C9A84C]/15 shadow-sm space-y-4">
                    <h3 class="font-cormorant font-bold text-xl text-[#0D3B2E] border-b border-[#C9A84C]/10 pb-3"><i class="fa-regular fa-face-smile text-[#C9A84C] mr-2"></i> About Member</h3>
                    <p class="text-sm text-[#4A3728]/85 leading-relaxed italic">
                        "{{ $profile['myself'] ?? 'No description provided yet.' }}"
                    </p>
                </div>

                <!-- Basic -->
                <div class="bg-white rounded-3xl p-8 border border-[#C9A84C]/15 shadow-sm space-y-4">
                    <h3 class="font-cormorant font-bold text-xl text-[#0D3B2E] border-b border-[#C9A84C]/10 pb-3"><i class="fa-regular fa-circle-question text-[#C9A84C] mr-2"></i> Basic Details</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                        <div class="flex justify-between items-center py-2 border-b border-[#C9A84C]/10">
                            <span class="text-[#4A3728]/60 font-semibold">Birthplace</span>
                            <span class="text-[#1A1208] font-bold">{{ $profile['birthplace'] ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-[#C9A84C]/10">
                            <span class="text-[#4A3728]/60 font-semibold">Address</span>
                            <span class="text-[#1A1208] font-bold truncate max-w-[150px]">{{ $profile['address'] ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-[#C9A84C]/10">
                            <span class="text-[#4A3728]/60 font-semibold">Complexion</span>
                            <span class="text-[#1A1208] font-bold">{{ $profile['complexion']['name'] ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Religion -->
                <div class="bg-white rounded-3xl p-8 border border-[#C9A84C]/15 shadow-sm space-y-4">
                    <h3 class="font-cormorant font-bold text-xl text-[#0D3B2E] border-b border-[#C9A84C]/10 pb-3"><i class="fa-solid fa-dharmachakra text-[#C9A84C] mr-2"></i> Religious & Caste Details</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                        <div class="flex justify-between items-center py-2 border-b border-[#C9A84C]/10">
                            <span class="text-[#4A3728]/60 font-semibold">Religion</span>
                            <span class="text-[#1A1208] font-bold">{{ $profile['relegion']['name'] ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-[#C9A84C]/10">
                            <span class="text-[#4A3728]/60 font-semibold">Caste</span>
                            <span class="text-[#1A1208] font-bold">{{ $profile['caste']['name'] ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Professional -->
                <div class="bg-white rounded-3xl p-8 border border-[#C9A84C]/15 shadow-sm space-y-4">
                    <h3 class="font-cormorant font-bold text-xl text-[#0D3B2E] border-b border-[#C9A84C]/10 pb-3"><i class="fa-solid fa-briefcase text-[#C9A84C] mr-2"></i> Professional & Education</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                        <div class="flex justify-between items-center py-2 border-b border-[#C9A84C]/10">
                            <span class="text-[#4A3728]/60 font-semibold">Education</span>
                            <span class="text-[#1A1208] font-bold truncate max-w-[150px]">{{ $profile['education']['name'] ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-[#C9A84C]/10">
                            <span class="text-[#4A3728]/60 font-semibold">Job Type</span>
                            <span class="text-[#1A1208] font-bold">{{ $profile['jobType']['name'] ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-[#C9A84C]/10">
                            <span class="text-[#4A3728]/60 font-semibold">Company Sector</span>
                            <span class="text-[#1A1208] font-bold">{{ $profile['companyType']['name'] ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-[#C9A84C]/10">
                            <span class="text-[#4A3728]/60 font-semibold">Occupation</span>
                            <span class="text-[#1A1208] font-bold truncate max-w-[150px]">{{ $profile['occupation']['name'] ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-[#C9A84C]/10 col-span-1 sm:col-span-2">
                            <span class="text-[#4A3728]/60 font-semibold">Annual Income Range</span>
                            <span class="text-[#1A1208] font-bold">{{ $profile['annualIncome']['range'] ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Family details -->
                <div class="bg-white rounded-3xl p-8 border border-[#C9A84C]/15 shadow-sm space-y-4">
                    <h3 class="font-cormorant font-bold text-xl text-[#0D3B2E] border-b border-[#C9A84C]/10 pb-3"><i class="fa-solid fa-people-roof text-[#C9A84C] mr-2"></i> Family Details</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                        <div class="flex justify-between items-center py-2 border-b border-[#C9A84C]/10">
                            <span class="text-[#4A3728]/60 font-semibold">Brothers</span>
                            <span class="text-[#1A1208] font-bold">{{ $profile['brothers'] ?? '0' }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-[#C9A84C]/10">
                            <span class="text-[#4A3728]/60 font-semibold">Sisters</span>
                            <span class="text-[#1A1208] font-bold">{{ $profile['sisters'] ?? '0' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Gallery -->
                <div class="bg-white rounded-3xl p-8 border border-[#C9A84C]/15 shadow-sm space-y-4">
                    <h3 class="font-cormorant font-bold text-xl text-[#0D3B2E] border-b border-[#C9A84C]/10 pb-3"><i class="fa-regular fa-image text-[#C9A84C] mr-2"></i> Gallery Photos</h3>
                    
                    @if(empty($profile['galleries']))
                        <p class="text-sm text-[#4A3728]/50 italic">No gallery photos uploaded by this member.</p>
                    @else
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                            @foreach($profile['galleries'] as $photo)
                                <div class="relative rounded-2xl overflow-hidden bg-[#F0E8D0]/40 aspect-square group shadow-sm border border-[#C9A84C]/10">
                                    <img src="{{ asset($photo['image_path']) }}" alt="Gallery" class="w-full h-full object-cover">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>

            <!-- Right Sidebar (4 cols) -->
            <div class="md:col-span-4 space-y-8">
                <!-- Physical attributes -->
                <div class="bg-white rounded-3xl p-6 border border-[#C9A84C]/15 shadow-sm space-y-4">
                    <h3 class="font-cormorant font-bold text-xl text-[#0D3B2E] border-b border-[#C9A84C]/10 pb-3"><i class="fa-solid fa-ruler text-[#C9A84C] mr-2"></i> Attributes</h3>
                    
                    <div class="space-y-3.5 text-sm">
                        <div class="flex justify-between items-center py-1.5 border-b border-[#C9A84C]/10">
                            <span class="text-[#4A3728]/60 font-semibold">Height</span>
                            <span class="text-[#1A1208] font-bold">{{ $profile['height'] ?? 'N/A' }} Feet</span>
                        </div>
                        <div class="flex justify-between items-center py-1.5 border-b border-[#C9A84C]/10">
                            <span class="text-[#4A3728]/60 font-semibold">Weight</span>
                            <span class="text-[#1A1208] font-bold">{{ $profile['weight'] ?? 'N/A' }} Kg</span>
                        </div>
                    </div>
                </div>

                <!-- Contact Unlock -->
                <div class="bg-white rounded-3xl p-6 border border-[#C9A84C]/15 shadow-sm space-y-4">
                    <h3 class="font-cormorant font-bold text-xl text-[#0D3B2E] border-b border-[#C9A84C]/10 pb-3"><i class="fa-solid fa-phone text-[#C9A84C] mr-2"></i> Contact Details</h3>
                    
                    @if(isset($profile['interest_status']) && $profile['interest_status'] === 'accepted')
                        <!-- Unlocked contact details -->
                        <div class="space-y-3.5 text-sm">
                            <div class="flex justify-between items-center py-1.5 border-b border-[#C9A84C]/10">
                                <span class="text-[#4A3728]/60 font-semibold">Mobile</span>
                                <span class="text-[#1A1208] font-bold">{{ $profile['mobile'] ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between items-center py-1.5 border-b border-[#C9A84C]/10">
                                <span class="text-[#4A3728]/60 font-semibold">Email</span>
                                <span class="text-[#1A1208] font-bold">{{ $profile['email'] ?? 'N/A' }}</span>
                            </div>
                        </div>
                    @else
                        <!-- Locked contact details -->
                        <div class="bg-[#FBF6EC] border border-[#C9A84C]/15 rounded-2xl p-4 space-y-2 text-center text-xs">
                            <p class="text-[#8B6914] font-bold flex items-center justify-center gap-1"><i class="fa-solid fa-lock"></i> Number Locked</p>
                            <p class="text-xxs text-[#4A3728]/70 leading-relaxed font-semibold">Express interest and connect first. Once accepted, you can unlock and view contact details.</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
