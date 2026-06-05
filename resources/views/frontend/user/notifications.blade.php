@extends('layouts.frontend')

@section('title', 'Notifications')

@section('content')
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <div class="flex justify-between items-center border-b border-slate-200 pb-5">
            <div>
                <h1 class="font-display font-extrabold text-3xl text-slate-800">Alerts & Notifications</h1>
                <p class="text-sm text-slate-500 mt-1">Stay updated on profile actions, likes, and message requests.</p>
            </div>
            
            @if(!empty($notifications))
                <form action="{{ route('user.notifications.read') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-bold text-xs bg-white hover:bg-slate-550 hover:bg-slate-50 transition-all flex items-center gap-1.5 shadow-sm">
                        <i class="fa-solid fa-check-double text-rose-500"></i> Mark All as Read
                    </button>
                </form>
            @endif
        </div>

        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden divide-y divide-slate-50">
            @if(empty($notifications))
                <div class="p-16 text-center space-y-4">
                    <span class="w-14 h-14 rounded-2xl bg-rose-50 text-rose-400 flex items-center justify-center mx-auto text-xl"><i class="fa-regular fa-bell"></i></span>
                    <div class="space-y-1">
                        <h4 class="font-bold text-slate-700">No Notifications Yet</h4>
                        <p class="text-xs text-slate-400 max-w-sm mx-auto">We'll alert you here when someone likes your profile or sends connection requests.</p>
                    </div>
                </div>
            @else
                @foreach($notifications as $item)
                    @php $sender = $item['sender']; @endphp
                    <div class="p-5 flex items-start justify-between gap-4 hover:bg-slate-50/50 transition-colors {{ $item['is_read'] ? '' : 'bg-rose-50/10' }}">
                        <div class="flex items-start gap-4 min-w-0">
                            <!-- Avatar -->
                            <img src="{{ !empty($sender['profile']) ? asset($sender['profile']) : asset('profile/default-avatar.png') }}" 
                                 alt="Sender" class="w-12 h-12 rounded-xl object-cover flex-shrink-0 border"
                                 onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($sender['name'] ?? 'User') }}&background=ffe4e6&color=f43f5e'">
                            
                            <!-- Texts -->
                            <div class="min-w-0 space-y-1">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <h4 class="font-bold text-sm text-slate-800">{{ $item['title'] }}</h4>
                                    @if(!$item['is_read'])
                                        <span class="px-2 py-0.5 rounded-full text-xxs font-bold uppercase bg-rose-500 text-white leading-none scale-90">New</span>
                                    @endif
                                </div>
                                <p class="text-xs text-slate-500 leading-relaxed">{{ $item['body'] }}</p>
                                <p class="text-[10px] text-slate-400 font-semibold">{{ date('d-M-Y h:i A', strtotime($item['created_at'])) }}</p>
                            </div>
                        </div>

                        <!-- Action Link -->
                        @if(!empty($sender['id']))
                            <a href="{{ route('user.profile.view', ['id' => $sender['id']]) }}" class="text-xs font-bold text-rose-600 hover:text-rose-500 transition-colors flex-shrink-0 whitespace-nowrap">View Profile</a>
                        @endif
                    </div>
                @endforeach
            @endif
        </div>

    </div>
</div>
@endsection
