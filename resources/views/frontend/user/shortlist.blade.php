@extends('layouts.frontend')

@section('title', 'Shortlisted Profiles')

@section('content')
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <div>
            <h1 class="font-display font-extrabold text-3xl text-slate-800">Shortlisted Profiles</h1>
            <p class="text-sm text-slate-500 mt-1">Manage profiles you have bookmarked or marked as favorites.</p>
        </div>

        @if(empty($shortlisted))
            <div class="bg-white rounded-3xl p-16 text-center border border-slate-100 shadow-sm space-y-4">
                <span class="w-14 h-14 rounded-2xl bg-rose-50 text-rose-400 flex items-center justify-center mx-auto text-xl"><i class="fa-regular fa-heart"></i></span>
                <div class="space-y-1">
                    <h4 class="font-bold text-slate-700">No Shortlisted Profiles</h4>
                    <p class="text-xs text-slate-400 max-w-sm mx-auto">Shortlist profiles you like while browsing matches to save them here for quick access.</p>
                </div>
                <a href="{{ route('user.matches') }}" class="inline-flex px-6 py-2 rounded-xl bg-rose-500 text-white text-xs font-bold shadow-md">Browse Matches</a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                @foreach($shortlisted as $match)
                    <div class="bg-white rounded-3xl border border-slate-100 p-6 flex flex-col justify-between hover:shadow-md transition-all shadow-sm">
                        <div class="flex gap-4">
                            <!-- Photo -->
                            <a href="{{ route('user.profile.view', ['id' => $match['id']]) }}" class="block relative w-16 h-16 rounded-xl overflow-hidden bg-rose-50 flex-shrink-0 border hover:opacity-90 transition-opacity">
                                <img src="{{ !empty($match['profile']) ? asset($match['profile']) : asset('profile/default-avatar.png') }}" 
                                     alt="{{ $match['name'] }}" 
                                     class="w-full h-full object-cover"
                                     onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($match['name']) }}&background=ffe4e6&color=f43f5e'">
                            </a>
                            <!-- Details -->
                            <div class="min-w-0">
                                <h4 class="font-display font-bold text-slate-800 text-base truncate">
                                    <a href="{{ route('user.profile.view', ['id' => $match['id']]) }}" class="hover:text-rose-500 transition-colors">
                                        {{ $match['name'] }}
                                    </a>
                                </h4>
                                <p class="text-xs text-slate-400 font-bold tracking-wider">{{ $match['dummyid'] }}</p>
                                <p class="text-xs text-slate-500 font-semibold truncate">{{ $match['age'] }} Yrs, {{ $match['height'] }}" | {{ $match['occupation']['name'] ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <div class="flex gap-2 border-t border-slate-50 pt-4 mt-4 justify-between items-center">
                            <a href="{{ route('user.profile.view', ['id' => $match['id']]) }}" class="text-xs font-bold text-slate-600 hover:text-rose-500 transition-colors">View Profile</a>
                            
                            <form action="{{ route('user.shortlist.toggle', ['likedId' => $match['id']]) }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit" class="px-3 py-1.5 rounded-lg border border-rose-200 bg-rose-50 text-rose-600 text-xs font-bold flex items-center gap-1.5 hover:bg-rose-100 hover:text-rose-700 transition-all">
                                    <i class="fa-solid fa-heart"></i> Remove
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</div>
@endsection
