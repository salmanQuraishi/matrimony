@extends('layouts.frontend')

@section('title', 'Search Results')

@section('content')
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <div>
            <a href="{{ route('user.dashboard') }}" class="text-sm font-bold text-slate-500 hover:text-rose-500 transition-colors flex items-center gap-1.5 w-fit">
                <i class="fa-solid fa-arrow-left text-xs"></i> Back to Dashboard
            </a>
        </div>

        <div>
            <h1 class="font-display font-extrabold text-3xl text-slate-800">Search Results</h1>
            <p class="text-sm text-slate-500 mt-1">Showing profiles matching: <span class="font-bold text-rose-600">"{{ $search }}"</span></p>
        </div>

        @if(empty($users))
            <div class="bg-white rounded-3xl p-16 text-center border border-slate-100 shadow-sm space-y-4">
                <span class="w-14 h-14 rounded-2xl bg-rose-50 text-rose-400 flex items-center justify-center mx-auto text-xl"><i class="fa-solid fa-magnifying-glass"></i></span>
                <div class="space-y-1">
                    <h4 class="font-bold text-slate-700">No Members Found</h4>
                    <p class="text-xs text-slate-400 max-w-sm mx-auto">We couldn't find any member matching "{{ $search }}". Make sure the spelling is correct or search for other members.</p>
                </div>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                @foreach($users as $user)
                    <div class="bg-white rounded-3xl border border-slate-100 p-6 flex flex-col justify-between hover:shadow-md transition-all shadow-sm">
                        <div class="flex gap-4">
                            <!-- Photo -->
                            <div class="relative w-16 h-16 rounded-xl bg-rose-50 overflow-hidden flex-shrink-0 border">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user['name']) }}&background=ffe4e6&color=f43f5e" 
                                     alt="{{ $user['name'] }}" class="w-full h-full object-cover">
                            </div>
                            <!-- Details -->
                            <div class="min-w-0 space-y-0.5">
                                <h4 class="font-display font-bold text-slate-800 text-sm truncate">{{ $user['name'] }}</h4>
                                <p class="text-xxs text-slate-400 font-bold tracking-wider">{{ $user['username'] ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <div class="flex border-t border-slate-50 pt-4 mt-4 justify-between items-center">
                            <a href="{{ route('user.profile.view', ['id' => $user['id']]) }}" class="text-xs font-bold text-slate-600 hover:text-rose-500 transition-colors">View Profile</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</div>
@endsection
