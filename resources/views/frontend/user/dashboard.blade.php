@extends('layouts.frontend')

@section('title', 'Dashboard')

@section('content')
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Welcome banner -->
        <div class="bg-gradient-to-r from-rose-500 to-pink-500 rounded-3xl p-6 sm:p-8 text-white shadow-xl shadow-rose-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 relative overflow-hidden">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.15),transparent_40%)]"></div>
            <div class="space-y-2 relative z-10">
                <h1 class="font-display font-extrabold text-2xl sm:text-3xl">Hello, {{ $authUser['name'] }}!</h1>
                <p class="text-sm text-rose-550 text-white/95">Welcome back to your dashboard. We hope you discover your partner today.</p>
                <div class="inline-flex mt-1 items-center px-3 py-1 rounded-full text-xs font-semibold bg-white/20 backdrop-blur-md text-white border border-white/10">
                    ID: {{ $authUser['dummyid'] }}
                </div>
            </div>
            
            <a href="{{ route('user.profile.edit') }}" class="px-5 py-3 rounded-xl bg-white text-rose-600 font-bold text-sm shadow-md hover:bg-slate-50 transition-all flex items-center gap-2 relative z-10 hover:-translate-y-0.5">
                <i class="fa-regular fa-pen-to-square text-sm"></i> Edit My Profile
            </a>
        </div>

        <!-- Dashboard Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- Left 8 columns -->
            <div class="lg:col-span-8 space-y-8">
                
                <!-- Metrics cards -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <!-- Likes -->
                    <a href="{{ route('user.shortlist') }}" class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex flex-col justify-between hover:border-rose-200 transition-all group">
                        <span class="w-10 h-10 rounded-xl bg-rose-50 text-rose-500 flex items-center justify-center text-lg group-hover:scale-110 transition-transform"><i class="fa-regular fa-heart"></i></span>
                        <div class="mt-4">
                            <p class="font-display font-extrabold text-2xl text-slate-800">{{ $stats['total_likes'] ?? 0 }}</p>
                            <p class="text-xxs font-bold text-slate-400 uppercase mt-0.5">Shortlisted</p>
                        </div>
                    </a>

                    <!-- Received Request -->
                    <a href="{{ route('user.interests', ['tab' => 'received']) }}" class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex flex-col justify-between hover:border-rose-200 transition-all group">
                        <span class="w-10 h-10 rounded-xl bg-pink-50 text-pink-500 flex items-center justify-center text-lg group-hover:scale-110 transition-transform"><i class="fa-solid fa-arrow-down-left"></i></span>
                        <div class="mt-4">
                            <p class="font-display font-extrabold text-2xl text-slate-800">{{ $stats['received_requests'] ?? 0 }}</p>
                            <p class="text-xxs font-bold text-slate-400 uppercase mt-0.5">Requests Received</p>
                        </div>
                    </a>

                    <!-- Sent Request -->
                    <a href="{{ route('user.interests', ['tab' => 'sent']) }}" class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex flex-col justify-between hover:border-rose-200 transition-all group">
                        <span class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-500 flex items-center justify-center text-lg group-hover:scale-110 transition-transform"><i class="fa-regular fa-paper-plane"></i></span>
                        <div class="mt-4">
                            <p class="font-display font-extrabold text-2xl text-slate-800">{{ $stats['sent_requests'] ?? 0 }}</p>
                            <p class="text-xxs font-bold text-slate-400 uppercase mt-0.5">Requests Sent</p>
                        </div>
                    </a>

                    <!-- Ignored -->
                    <a href="{{ route('user.interests', ['tab' => 'ignored']) }}" class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex flex-col justify-between hover:border-rose-200 transition-all group">
                        <span class="w-10 h-10 rounded-xl bg-slate-100 text-slate-500 flex items-center justify-center text-lg group-hover:scale-110 transition-transform"><i class="fa-solid fa-ban"></i></span>
                        <div class="mt-4">
                            <p class="font-display font-extrabold text-2xl text-slate-800">{{ $stats['not_interested'] ?? 0 }}</p>
                            <p class="text-xxs font-bold text-slate-400 uppercase mt-0.5">Ignored Profiles</p>
                        </div>
                    </a>
                </div>

                <!-- Matches grid preview -->
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <h3 class="font-display font-bold text-xl text-slate-800">Recommended Matches</h3>
                        <a href="{{ route('user.matches') }}" class="text-sm font-bold text-rose-600 hover:text-rose-500 transition-colors flex items-center gap-1">View All <i class="fa-solid fa-arrow-right text-xs"></i></a>
                    </div>
                    
                    @if(empty($matches))
                        <div class="bg-white rounded-3xl p-8 text-center border border-slate-100 shadow-sm space-y-4">
                            <span class="w-14 h-14 rounded-2xl bg-rose-50 text-rose-400 flex items-center justify-center mx-auto text-xl"><i class="fa-regular fa-heart"></i></span>
                            <div class="space-y-1">
                                <h4 class="font-bold text-slate-700">No Recommended Matches Yet</h4>
                                <p class="text-xs text-slate-400 max-w-sm mx-auto">Complete your profile to let our matchmaking filters fetch partners for you.</p>
                            </div>
                            <a href="{{ route('user.profile.edit') }}" class="inline-flex px-6 py-2.5 rounded-xl font-bold bg-rose-500 text-white text-sm">Edit Profile</a>
                        </div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            @foreach($matches as $match)
                                <div class="bg-white rounded-3xl border border-slate-100 overflow-hidden shadow-sm flex flex-col justify-between hover:shadow-md transition-all duration-300 group">
                                    <div class="p-6 flex gap-4">
                                        <!-- Profile Picture -->
                                        <div class="relative w-20 h-20 rounded-2xl bg-rose-50 overflow-hidden flex-shrink-0">
                                            <img src="{{ !empty($match['profile']) ? asset($match['profile']) : asset('profile/default-avatar.png') }}" 
                                                 alt="{{ $match['name'] }}" 
                                                 class="w-full h-full object-cover"
                                                 onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($match['name']) }}&background=ffe4e6&color=f43f5e'">
                                        </div>
                                        
                                        <!-- Details -->
                                        <div class="space-y-1 min-w-0">
                                            <h4 class="font-display font-bold text-slate-800 text-base truncate">{{ $match['name'] }}</h4>
                                            <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">{{ $match['dummyid'] }}</p>
                                            <p class="text-xs text-slate-500 font-semibold truncate">
                                                {{ $match['age'] }} Yrs, {{ $match['height'] }}" | {{ $match['occupation']['name'] ?? 'N/A' }}
                                            </p>
                                            <p class="text-xs text-slate-400 font-medium truncate">
                                                <i class="fa-solid fa-location-dot text-slate-300"></i> {{ $match['city']['name'] ?? 'N/A' }}, {{ $match['state']['name'] ?? 'N/A' }}
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <!-- Actions footer -->
                                    <div class="border-t border-slate-50 bg-slate-50/50 p-4 px-6 flex justify-between items-center gap-4">
                                        <a href="{{ route('user.profile.view', ['id' => $match['id']]) }}" class="text-xs font-bold text-slate-600 hover:text-rose-500 transition-colors">View Profile</a>
                                        
                                        <div class="flex gap-2">
                                            <!-- Shortlist / Like -->
                                            <form action="{{ route('user.shortlist.toggle', ['likedId' => $match['id']]) }}" method="POST" class="m-0">
                                                @csrf
                                                <button type="submit" class="w-8 h-8 rounded-lg flex items-center justify-center border {{ $match['is_liked'] ? 'bg-rose-50 border-rose-200 text-rose-500' : 'bg-white border-slate-200 text-slate-400 hover:text-rose-500 hover:bg-rose-50/50 hover:border-rose-200' }} transition-all text-sm">
                                                    <i class="{{ $match['is_liked'] ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                                                </button>
                                            </form>
                                            
                                            <!-- Express Interest -->
                                            <form action="{{ route('user.interests.send', ['receiver' => $match['id']]) }}" method="POST" class="m-0">
                                                @csrf
                                                <button type="submit" class="px-3 py-1.5 rounded-lg bg-gradient-to-r from-rose-500 to-pink-500 text-white text-xs font-bold shadow-md shadow-rose-100 flex items-center gap-1.5 hover:shadow-lg transition-all">
                                                    <i class="fa-regular fa-paper-plane text-xxs"></i> Connect
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>

            <!-- Right 4 columns -->
            <div class="lg:col-span-4 space-y-8">
                
                <!-- Profile Completion Widget -->
                <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm space-y-6">
                    <h3 class="font-display font-bold text-lg text-slate-800">Profile Completion</h3>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-semibold text-slate-600">Completion Status</span>
                            <span class="text-sm font-extrabold text-rose-600">{{ $authUser['profile_completion'] }}%</span>
                        </div>
                        
                        <!-- Progress bar -->
                        <div class="h-2.5 w-full bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-rose-500 to-pink-500 rounded-full transition-all duration-500" 
                                 style="width: {{ $authUser['profile_completion'] }}%"></div>
                        </div>

                        <!-- Completion tip -->
                        @if($authUser['profile_completion'] < 100)
                            <div class="bg-rose-50/50 border border-rose-100 rounded-2xl p-4 flex gap-3 text-rose-700 text-xs">
                                <i class="fa-solid fa-lightbulb text-base flex-shrink-0 mt-0.5"></i>
                                <span>Completing your profile fields boosts matching visibility by up to 300%. Add religious details and upload photos.</span>
                            </div>
                        @else
                            <div class="bg-emerald-50 border border-emerald-100 rounded-2xl p-4 flex gap-3 text-emerald-700 text-xs">
                                <i class="fa-solid fa-circle-check text-base flex-shrink-0 mt-0.5"></i>
                                <span>Your profile is fully completed! Enjoy maximum search visibility on NikahTime Matrimony.</span>
                            </div>
                        @endif
                        
                        <a href="{{ route('user.profile.edit') }}" class="w-full py-3.5 rounded-xl font-bold bg-slate-900 text-white hover:bg-slate-800 transition-colors text-center text-xs flex items-center justify-center gap-2">
                            Update Details <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                </div>

                <!-- Safe Matrimony Widget -->
                <div class="bg-slate-900 text-white rounded-3xl p-6 relative overflow-hidden">
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_bottom_left,rgba(244,63,94,0.1),transparent_40%)]"></div>
                    <div class="space-y-4 relative z-10">
                        <span class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-rose-500 text-lg"><i class="fa-solid fa-shield-halved"></i></span>
                        <h4 class="font-display font-bold text-base">Safe Matrimony Guidelines</h4>
                        <p class="text-xs leading-relaxed text-slate-400">Protect yourself from verification scams. Never share financial/bank details with someone you met online, and report suspicious activities immediately.</p>
                        <a href="{{ route('terms') }}" class="inline-flex text-xs font-bold text-rose-400 hover:text-rose-300 transition-colors">Read Guidelines</a>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>
@endsection
