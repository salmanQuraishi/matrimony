@extends('layouts.frontend')

@section('title', 'Messages')

@section('content')
<div class="py-12 bg-slate-50 min-h-[85vh]">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Chat container -->
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden grid grid-cols-1 md:grid-cols-12 min-h-[600px] h-[75vh]">
            
            <!-- Left Pane: Chat List (4 cols) -->
            <div class="md:col-span-4 border-r border-slate-100 flex flex-col h-full bg-slate-50/10">
                <div class="p-5 border-b border-slate-100 bg-white">
                    <h3 class="font-display font-extrabold text-xl text-slate-800">Inbox Messages</h3>
                </div>
                
                <!-- Active Chats List -->
                <div class="flex-grow overflow-y-auto p-3 space-y-2">
                    @if(empty($chats))
                        <div class="text-center py-12 px-4 space-y-3">
                            <span class="w-12 h-12 rounded-xl bg-slate-150 text-slate-400 flex items-center justify-center mx-auto text-lg"><i class="fa-regular fa-comment-dots"></i></span>
                            <p class="text-xs text-slate-400 font-semibold">No active conversations yet.</p>
                            <p class="text-[10px] text-slate-400 leading-relaxed max-w-[180px] mx-auto">Connect and accept interests with other members to start messaging.</p>
                        </div>
                    @else
                        @foreach($chats as $chat)
                            @php $isActive = isset($activeUser) && $activeUser['id'] == $chat['user']['id']; @endphp
                            <a href="{{ route('user.messages', ['user_id' => $chat['user']['id']]) }}" 
                               class="flex items-center gap-3 p-3.5 rounded-2xl transition-all border {{ $isActive ? 'bg-rose-50/50 border-rose-100 text-rose-700' : 'bg-white border-transparent hover:bg-slate-50 text-slate-700' }}">
                                <img src="{{ !empty($chat['user']['profile']) ? asset($chat['user']['profile']) : asset('profile/default-avatar.png') }}" 
                                     alt="Contact" class="w-11 h-11 rounded-xl object-cover border"
                                     onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($chat['user']['name']) }}&background=ffe4e6&color=f43f5e'">
                                <div class="flex-grow min-w-0">
                                    <div class="flex justify-between items-center">
                                        <h4 class="font-bold text-sm truncate {{ $isActive ? 'text-rose-700' : 'text-slate-800' }}">{{ $chat['user']['name'] }}</h4>
                                        @if(!empty($chat['last_message_at']))
                                            <span class="text-xxs text-slate-400 font-semibold">{{ date('h:i A', strtotime($chat['last_message_at'])) }}</span>
                                        @endif
                                    </div>
                                    <p class="text-xs text-slate-400 truncate mt-0.5">{{ $chat['last_message'] ?: 'Click to start chatting.' }}</p>
                                </div>
                                @if($chat['unread_count'] > 0)
                                    <span class="px-1.5 py-0.5 bg-rose-500 text-white font-bold text-xxs rounded-full leading-none">{{ $chat['unread_count'] }}</span>
                                @endif
                            </a>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Right Pane: Active Chat Conversation (8 cols) -->
            <div class="md:col-span-8 flex flex-col h-full bg-white relative">
                @if(!$activeUser)
                    <!-- Empty State -->
                    <div class="absolute inset-0 flex flex-col items-center justify-center p-8 text-center space-y-4">
                        <span class="w-16 h-16 rounded-3xl bg-rose-50 text-rose-500 flex items-center justify-center text-2xl shadow-inner"><i class="fa-regular fa-comments"></i></span>
                        <div class="space-y-1">
                            <h3 class="font-display font-bold text-lg text-slate-700">Select a Conversation</h3>
                            <p class="text-xs text-slate-400 max-w-xs mx-auto">Choose a member from the left pane to view message history and send new messages.</p>
                        </div>
                    </div>
                @else
                    <!-- Chat Header -->
                    <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-white z-10 shadow-sm">
                        <div class="flex items-center gap-3 min-w-0">
                            <img src="{{ !empty($activeUser['profile']) ? asset($activeUser['profile']) : asset('profile/default-avatar.png') }}" 
                                 alt="Active user" class="w-11 h-11 rounded-xl object-cover border"
                                 onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($activeUser['name']) }}&background=ffe4e6&color=f43f5e'">
                            <div class="min-w-0">
                                <h4 class="font-display font-bold text-slate-800 text-base truncate">{{ $activeUser['name'] }}</h4>
                                <p class="text-xxs text-slate-400 font-bold uppercase tracking-wider">Member Chat</p>
                            </div>
                        </div>
                        
                        <a href="{{ route('user.profile.view', ['id' => $activeUser['id']]) }}" class="px-3 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:text-rose-500 hover:bg-slate-50 transition-all">View Profile</a>
                    </div>

                    <!-- Message Feed -->
                    <div id="message_feed" class="flex-grow overflow-y-auto p-6 space-y-4 bg-slate-50/20">
                        @if(empty($messages))
                            <div class="text-center py-12 text-slate-400 text-xs italic">
                                No messages exchanged yet. Send a greeting to start your story!
                            </div>
                        @else
                            @foreach($messages as $msg)
                                @php $isMe = $msg['sender_id'] == session('user_data')['id']; @endphp
                                <div class="flex {{ $isMe ? 'justify-end' : 'justify-start' }}">
                                    <div class="max-w-[70%] space-y-1">
                                        <div class="px-4 py-3 rounded-2xl text-sm leading-relaxed shadow-sm {{ $isMe ? 'bg-gradient-to-r from-rose-500 to-pink-500 text-white rounded-br-none' : 'bg-white text-slate-700 rounded-bl-none border border-slate-100' }}">
                                            {{ $msg['message'] }}
                                        </div>
                                        <p class="text-[9px] text-slate-400 font-semibold px-1 text-right">
                                            {{ date('h:i A', strtotime($msg['created_at'])) }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <!-- Message Input Form -->
                    <div class="p-4 border-t border-slate-100 bg-white">
                        <form action="{{ route('user.messages.store') }}" method="POST" class="flex gap-3 m-0">
                            @csrf
                            <input type="hidden" name="receiver_id" value="{{ $activeUser['id'] }}">
                            
                            <input type="text" name="message" required autocomplete="off"
                                   class="flex-grow rounded-2xl border-slate-200 text-slate-700 text-sm focus:ring-rose-500 focus:border-rose-500 py-3.5 px-4" 
                                   placeholder="Type a message...">
                            
                            <button type="submit" class="w-12 h-12 rounded-2xl flex items-center justify-center bg-gradient-to-r from-rose-500 to-pink-500 text-white shadow-md shadow-rose-100 hover:shadow-lg transition-all flex-shrink-0">
                                <i class="fa-regular fa-paper-plane"></i>
                            </button>
                        </form>
                    </div>
                @endif
            </div>

        </div>

    </div>
</div>

<script>
    // Auto scroll chat list to bottom on load
    document.addEventListener("DOMContentLoaded", function() {
        const feed = document.getElementById("message_feed");
        if (feed) {
            feed.scrollTop = feed.scrollHeight;
        }
    });
</script>
@endsection
