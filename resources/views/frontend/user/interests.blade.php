@extends('layouts.frontend')

@section('title', 'Interests')

@section('content')
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8" x-data="{ currentTab: '{{ $tab }}' }">
        
        <div>
            <h1 class="font-display font-extrabold text-3xl text-slate-800">Connection Requests</h1>
            <p class="text-sm text-slate-500 mt-1">Manage matches you have contacted or who have requested to connect with you.</p>
        </div>

        <!-- Tab Links -->
        <div class="flex flex-wrap border-b border-slate-200 gap-1 bg-white p-1.5 rounded-2xl shadow-sm border border-slate-100">
            <button @click="currentTab = 'received'" :class="currentTab === 'received' ? 'bg-rose-50 text-rose-600' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-50'" class="flex-1 min-w-[120px] px-4 py-2.5 rounded-xl text-xs font-bold transition-all">Requests Received ({{ count($receivedInterests) }})</button>
            <button @click="currentTab = 'sent'" :class="currentTab === 'sent' ? 'bg-rose-50 text-rose-600' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-50'" class="flex-1 min-w-[120px] px-4 py-2.5 rounded-xl text-xs font-bold transition-all">Requests Sent ({{ count($sentInterests) }})</button>
            <button @click="currentTab = 'ignored'" :class="currentTab === 'ignored' ? 'bg-rose-50 text-rose-600' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-50'" class="flex-1 min-w-[120px] px-4 py-2.5 rounded-xl text-xs font-bold transition-all">Ignored Profiles ({{ count($ignoredUsers) }})</button>
        </div>

        <!-- Received Tab -->
        <div x-show="currentTab === 'received'" class="space-y-4">
            @if(empty($receivedInterests))
                <div class="bg-white rounded-3xl p-16 text-center border border-slate-100 shadow-sm space-y-4">
                    <span class="w-14 h-14 rounded-2xl bg-rose-50 text-rose-400 flex items-center justify-center mx-auto text-xl"><i class="fa-solid fa-arrow-down-left"></i></span>
                    <div class="space-y-1">
                        <h4 class="font-bold text-slate-700">No Received Requests</h4>
                        <p class="text-xs text-slate-400 max-w-sm mx-auto">When other members express interest in your profile, their requests will appear here.</p>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    @foreach($receivedInterests as $item)
                        @php $sender = $item['sender']; @endphp
                        <div class="bg-white rounded-3xl border border-slate-100 p-6 flex flex-col justify-between hover:shadow-md transition-all shadow-sm">
                            <div class="flex gap-4">
                                <a href="{{ route('user.profile.view', ['id' => $sender['id']]) }}" class="block relative w-16 h-16 rounded-xl overflow-hidden bg-rose-50 flex-shrink-0 border hover:opacity-90 transition-opacity">
                                    <img src="{{ !empty($sender['profile']) ? asset($sender['profile']) : asset('profile/default-avatar.png') }}" 
                                         alt="Sender" class="w-full h-full object-cover"
                                         onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($sender['name'] ?? 'User') }}&background=ffe4e6&color=f43f5e'">
                                </a>
                                <div class="min-w-0">
                                    <h4 class="font-display font-bold text-slate-800 text-base truncate">
                                        <a href="{{ route('user.profile.view', ['id' => $sender['id']]) }}" class="hover:text-rose-500 transition-colors">
                                            {{ $sender['name'] ?? 'N/A' }}
                                        </a>
                                    </h4>
                                    <p class="text-xs text-slate-400 font-bold tracking-wider">{{ $sender['dummyid'] ?? 'N/A' }}</p>
                                    <p class="text-xs text-slate-500 font-semibold truncate">{{ $sender['age'] ?? 'N/A' }} Yrs, {{ $sender['height'] ?? 'N/A' }}" | {{ $sender['occupation']['name'] ?? 'N/A' }}</p>
                                </div>
                            </div>
                            
                            <div class="flex gap-2 border-t border-slate-50 pt-4 mt-4 justify-end">
                                <form action="{{ route('user.interests.reject', ['interest' => $item['interest_id']]) }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 rounded-xl text-xs font-bold border border-slate-200 text-slate-600 hover:bg-slate-50">Decline</button>
                                </form>
                                <form action="{{ route('user.interests.accept', ['interest' => $item['interest_id']]) }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 rounded-xl text-xs font-bold bg-rose-500 text-white shadow-md">Accept Request</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Sent Tab -->
        <div x-show="currentTab === 'sent'" class="space-y-4">
            @if(empty($sentInterests))
                <div class="bg-white rounded-3xl p-16 text-center border border-slate-100 shadow-sm space-y-4">
                    <span class="w-14 h-14 rounded-2xl bg-rose-50 text-rose-400 flex items-center justify-center mx-auto text-xl"><i class="fa-regular fa-paper-plane"></i></span>
                    <div class="space-y-1">
                        <h4 class="font-bold text-slate-700">No Sent Requests</h4>
                        <p class="text-xs text-slate-400 max-w-sm mx-auto">Profiles you connect with or express interest in will be shown in this list.</p>
                    </div>
                    <a href="{{ route('user.matches') }}" class="inline-flex px-6 py-2 rounded-xl bg-rose-500 text-white text-xs font-bold shadow-md">Explore Matches</a>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    @foreach($sentInterests as $item)
                        @php $receiver = $item['receiver']; @endphp
                        <div class="bg-white rounded-3xl border border-slate-100 p-6 flex flex-col justify-between hover:shadow-md transition-all shadow-sm">
                            <div class="flex gap-4">
                                <a href="{{ route('user.profile.view', ['id' => $receiver['id']]) }}" class="block relative w-16 h-16 rounded-xl overflow-hidden bg-rose-50 flex-shrink-0 border hover:opacity-90 transition-opacity">
                                    <img src="{{ !empty($receiver['profile']) ? asset($receiver['profile']) : asset('profile/default-avatar.png') }}" 
                                         alt="Receiver" class="w-full h-full object-cover"
                                         onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($receiver['name'] ?? 'User') }}&background=ffe4e6&color=f43f5e'">
                                </a>
                                <div class="min-w-0">
                                    <h4 class="font-display font-bold text-slate-800 text-base truncate">
                                        <a href="{{ route('user.profile.view', ['id' => $receiver['id']]) }}" class="hover:text-rose-500 transition-colors">
                                            {{ $receiver['name'] ?? 'N/A' }}
                                        </a>
                                    </h4>
                                    <p class="text-xs text-slate-400 font-bold tracking-wider">{{ $receiver['dummyid'] ?? 'N/A' }}</p>
                                    <p class="text-xs text-slate-500 font-semibold truncate">{{ $receiver['age'] ?? 'N/A' }} Yrs, {{ $receiver['height'] ?? 'N/A' }}" | {{ $receiver['occupation']['name'] ?? 'N/A' }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between border-t border-slate-50 pt-4 mt-4">
                                <span class="px-2.5 py-1 rounded-full text-xxs font-bold uppercase tracking-wider bg-amber-50 text-amber-600 border border-amber-100">Pending</span>
                                <form action="{{ route('user.interests.revoke', ['interest' => $item['interest_id']]) }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 rounded-xl text-xs font-bold border border-slate-200 text-slate-400 hover:text-red-500 hover:border-red-200 transition-all">Cancel Request</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Ignored Tab -->
        <div x-show="currentTab === 'ignored'" class="space-y-4">
            @if(empty($ignoredUsers))
                <div class="bg-white rounded-3xl p-16 text-center border border-slate-100 shadow-sm space-y-4">
                    <span class="w-14 h-14 rounded-2xl bg-rose-50 text-rose-400 flex items-center justify-center mx-auto text-xl"><i class="fa-solid fa-ban"></i></span>
                    <div class="space-y-1">
                        <h4 class="font-bold text-slate-700">No Ignored Profiles</h4>
                        <p class="text-xs text-slate-400 max-w-sm mx-auto">Profiles you hide or ignore will accumulate here. You can unblock them anytime.</p>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    @foreach($ignoredUsers as $item)
                        @php $ignored = $item['not_interest_data']; @endphp
                        <div class="bg-white rounded-3xl border border-slate-100 p-6 flex flex-col justify-between hover:shadow-md transition-all shadow-sm">
                            <div class="flex gap-4">
                                <a href="{{ route('user.profile.view', ['id' => $ignored['id']]) }}" class="block relative w-16 h-16 rounded-xl overflow-hidden bg-rose-50 flex-shrink-0 border hover:opacity-90 transition-opacity">
                                    <img src="{{ !empty($ignored['profile']) ? asset($ignored['profile']) : asset('profile/default-avatar.png') }}" 
                                         alt="Ignored" class="w-full h-full object-cover"
                                         onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($ignored['name'] ?? 'User') }}&background=ffe4e6&color=f43f5e'">
                                </a>
                                <div class="min-w-0">
                                    <h4 class="font-display font-bold text-slate-800 text-base truncate">
                                        <a href="{{ route('user.profile.view', ['id' => $ignored['id']]) }}" class="hover:text-rose-500 transition-colors">
                                            {{ $ignored['name'] ?? 'N/A' }}
                                        </a>
                                    </h4>
                                    <p class="text-xs text-slate-400 font-bold tracking-wider">{{ $ignored['dummyid'] ?? 'N/A' }}</p>
                                    <p class="text-xs text-slate-500 font-semibold truncate">{{ $ignored['age'] ?? 'N/A' }} Yrs | {{ $ignored['city']['name'] ?? 'N/A' }}</p>
                                </div>
                            </div>
                            
                            <div class="flex border-t border-slate-50 pt-4 mt-4 justify-end">
                                <form action="{{ route('user.interests.ignore.revoke', ['ignored' => $item['not_interest_id']]) }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 rounded-xl text-xs font-bold border border-slate-200 text-rose-600 hover:bg-rose-50 hover:border-rose-200 transition-all">Remove Block</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
