@extends('layouts.frontend')

@section('title', 'Find Matches')

@section('content')
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <div>
            <h1 class="font-display font-extrabold text-3xl text-slate-800">Matching Profiles</h1>
            <p class="text-sm text-slate-500 mt-1">Discover members matching your compatibility criteria.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Sidebar Filters (4 cols) -->
            <div class="lg:col-span-4 bg-white rounded-3xl p-6 border border-slate-100 shadow-sm sticky top-24">
                <div class="flex justify-between items-center border-b border-slate-50 pb-4 mb-5">
                    <h3 class="font-display font-bold text-lg text-slate-800">Advanced Filters</h3>
                    <a href="{{ route('user.matches') }}" class="text-xs font-bold text-rose-600 hover:text-rose-500 transition-colors">Clear All</a>
                </div>

                <form action="{{ route('user.matches') }}" method="GET" class="space-y-4">
                    <!-- State -->
                    <div>
                        <label for="filter_state" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">State</label>
                        <select id="filter_state" name="state" onchange="loadFilterCities(this.value)"
                                class="w-full rounded-2xl border-slate-200 text-slate-700 text-sm focus:ring-rose-500 focus:border-rose-500 py-3">
                            <option value="">All States</option>
                            @foreach($states as $item)
                                <option value="{{ $item['sid'] }}" {{ ($filters['state'] ?? '') == $item['sid'] ? 'selected' : '' }}>{{ $item['name'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- City -->
                    <div>
                        <label for="filter_city" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">City</label>
                        <select id="filter_city" name="city"
                                class="w-full rounded-2xl border-slate-200 text-slate-700 text-sm focus:ring-rose-500 focus:border-rose-500 py-3">
                            <option value="">All Cities</option>
                            @foreach($cities as $item)
                                <option value="{{ $item['cityid'] }}" {{ ($filters['city'] ?? '') == $item['cityid'] ? 'selected' : '' }}>{{ $item['name'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Age Range -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="filter_age_min" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Age Min</label>
                            <select id="filter_age_min" name="age_min"
                                    class="w-full rounded-2xl border-slate-200 text-slate-700 text-sm focus:ring-rose-500 focus:border-rose-500 py-3">
                                <option value="">Min</option>
                                @for($i = 18; $i <= 50; $i++)
                                    <option value="{{ $i }}" {{ ($filters['age_min'] ?? '') == $i ? 'selected' : '' }}>{{ $i }} Yrs</option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label for="filter_age_max" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Age Max</label>
                            <select id="filter_age_max" name="age_max"
                                    class="w-full rounded-2xl border-slate-200 text-slate-700 text-sm focus:ring-rose-500 focus:border-rose-500 py-3">
                                <option value="">Max</option>
                                @for($i = 18; $i <= 60; $i++)
                                    <option value="{{ $i }}" {{ ($filters['age_max'] ?? '') == $i ? 'selected' : '' }}>{{ $i }} Yrs</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-3.5 rounded-xl font-bold bg-slate-900 hover:bg-slate-800 text-white shadow-md text-xs transition-all mt-2">
                        Apply Filters
                    </button>
                </form>
            </div>

            <!-- Matches List (8 cols) -->
            <div class="lg:col-span-8">
                @if(empty($matches))
                    <div class="bg-white rounded-3xl p-16 text-center border border-slate-100 shadow-sm space-y-4">
                        <span class="w-16 h-16 rounded-2xl bg-rose-50 text-rose-400 flex items-center justify-center mx-auto text-2xl"><i class="fa-regular fa-face-frown"></i></span>
                        <div class="space-y-1">
                            <h3 class="font-display font-bold text-xl text-slate-700">No Match Profiles Found</h3>
                            <p class="text-sm text-slate-400 max-w-sm mx-auto">Try clearing/broadening your filter criteria or update your profile religious settings.</p>
                        </div>
                        <a href="{{ route('user.matches') }}" class="inline-flex px-6 py-2.5 rounded-xl font-bold bg-rose-500 text-white text-xs shadow-md">Reset Search</a>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        @foreach($matches as $match)
                            <div class="bg-white rounded-3xl border border-slate-100 overflow-hidden shadow-sm flex flex-col justify-between hover:shadow-md transition-all duration-300 group">
                                <div class="p-6 space-y-4">
                                    <div class="flex gap-4">
                                        <!-- Photo -->
                                        <a href="{{ route('user.profile.view', ['id' => $match['id']]) }}" class="block relative w-20 h-20 rounded-2xl bg-rose-50 overflow-hidden flex-shrink-0 border border-slate-100 hover:opacity-90 transition-opacity">
                                            <img src="{{ !empty($match['profile']) ? asset($match['profile']) : asset('profile/default-avatar.png') }}" 
                                                 alt="{{ $match['name'] }}" 
                                                 class="w-full h-full object-cover"
                                                 onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($match['name']) }}&background=ffe4e6&color=f43f5e'">
                                        </a>
                                        
                                        <!-- Header Details -->
                                        <div class="space-y-1 min-w-0">
                                            <h4 class="font-display font-bold text-slate-800 text-base truncate">
                                                <a href="{{ route('user.profile.view', ['id' => $match['id']]) }}" class="hover:text-rose-500 transition-colors">
                                                    {{ $match['name'] }}
                                                </a>
                                            </h4>
                                            <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">{{ $match['dummyid'] }}</p>
                                            <p class="text-xs text-slate-500 font-semibold truncate">
                                                {{ $match['age'] }} Yrs, {{ $match['height'] }}" | {{ $match['occupation']['name'] ?? 'N/A' }}
                                            </p>
                                            <p class="text-xs text-slate-400 font-medium truncate">
                                                <i class="fa-solid fa-location-dot text-slate-300"></i> {{ $match['city']['name'] ?? 'N/A' }}, {{ $match['state']['name'] ?? 'N/A' }}
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Quick Bio -->
                                    <p class="text-xs text-slate-500 leading-relaxed line-clamp-2 italic">
                                        "{{ $match['myself'] ?? 'No description provided by member yet.' }}"
                                    </p>
                                </div>
                                
                                <!-- Card Footer Actions -->
                                <div class="border-t border-slate-50 bg-slate-50/50 p-4 px-6 flex justify-between items-center gap-4">
                                    <a href="{{ route('user.profile.view', ['id' => $match['id']]) }}" class="text-xs font-bold text-slate-600 hover:text-rose-500 transition-colors">View Full Profile</a>
                                    
                                    <div class="flex gap-2">
                                        <!-- Shortlist toggle -->
                                        <form action="{{ route('user.shortlist.toggle', ['likedId' => $match['id']]) }}" method="POST" class="m-0">
                                            @csrf
                                            <button type="submit" class="w-8 h-8 rounded-lg flex items-center justify-center border {{ $match['is_liked'] ? 'bg-rose-50 border-rose-200 text-rose-500' : 'bg-white border-slate-200 text-slate-400 hover:text-rose-500 hover:bg-rose-50/50 hover:border-rose-200' }} transition-all text-sm">
                                                <i class="{{ $match['is_liked'] ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                                            </button>
                                        </form>
                                        
                                        <!-- Express Interest -->
                                        <form action="{{ route('user.interests.send', ['receiver' => $match['id']]) }}" method="POST" class="m-0">
                                            @csrf
                                            <button type="submit" class="px-3.5 py-1.5 rounded-lg bg-gradient-to-r from-rose-500 to-pink-500 text-white text-xs font-bold shadow-md shadow-rose-100 flex items-center gap-1.5 hover:shadow-lg transition-all">
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

    </div>
</div>

<script>
    // AJAX for filter city loading
    function loadFilterCities(stateId) {
        const citySelect = document.getElementById('filter_city');
        citySelect.innerHTML = '<option value="">Loading cities...</option>';

        if (!stateId) {
            citySelect.innerHTML = '<option value="">All Cities</option>';
            return;
        }

        fetch(`/ajax/cities/${stateId}`)
            .then(res => res.json())
            .then(data => {
                citySelect.innerHTML = '<option value="">All Cities</option>';
                if (data.status && data.data) {
                    data.data.forEach(city => {
                        citySelect.innerHTML += `<option value="${city.cityid}">${city.name}</option>`;
                    });
                } else {
                    citySelect.innerHTML = '<option value="">No cities found</option>';
                }
            })
            .catch(() => {
                citySelect.innerHTML = '<option value="">Error loading cities</option>';
            });
    }
</script>
@endsection
