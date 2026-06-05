<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', $settings['title'] ?? 'NikahTime') | Premium Matrimonial Services</title>
    
    <!-- Favicon -->
    @if(!empty($settings['favicon']))
        <link rel="icon" type="image/png" href="{{ asset($settings['favicon']) }}">
    @else
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @endif
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400&family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body, h1, h2, h3, h4, h5, h6, .font-display {
            font-family: 'Outfit', 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-[#FBF6EC] text-[#1A1208] min-h-screen flex flex-col antialiased">

    <!-- Header Section -->
    <header x-data="{ mobileMenuOpen: false }" class="sticky top-0 z-50 bg-[#FBF6EC]/95 backdrop-blur-md border-b border-[#C9A84C]/25 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                        @if(!empty($settings['logo_dark']) || !empty($settings['logo']))
                            <img src="{{ asset($settings['logo_dark'] ?? $settings['logo']) }}" alt="{{ $settings['title'] ?? 'NikahTime' }}" class="h-10 w-auto object-contain">
                        @else
                            <span class="w-10 h-10 rounded-xl bg-gradient-to-tr from-[#C9A84C] to-[#8B6914] flex items-center justify-center shadow-md shadow-[#C9A84C]/20">
                                <i class="fa-solid fa-heart text-[#0D3B2E] text-lg animate-pulse"></i>
                            </span>
                            <span class="font-display font-extrabold text-2xl bg-gradient-to-r from-[#C9A84C] via-[#8B6914] to-[#C9A84C] bg-clip-text text-transparent">{{ $settings['title'] ?? 'NikahTime' }}</span>
                        @endif
                    </a>
                </div>

                <!-- Navigation Links (Desktop) -->
                <nav class="hidden lg:flex space-x-1 items-center">
                    <a href="{{ route('home') }}" class="px-4 py-2 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('home') ? 'bg-[#F0E8D0]/80 text-[#0D3B2E] border border-[#C9A84C]/25' : 'text-[#4A3728] hover:text-[#C9A84C] hover:bg-[#F0E8D0]/30' }}">Home</a>
                    <a href="{{ route('about') }}" class="px-4 py-2 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('about') ? 'bg-[#F0E8D0]/80 text-[#0D3B2E] border border-[#C9A84C]/25' : 'text-[#4A3728] hover:text-[#C9A84C] hover:bg-[#F0E8D0]/30' }}">About Us</a>
                    <a href="{{ route('success-stories') }}" class="px-4 py-2 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('success-stories') ? 'bg-[#F0E8D0]/80 text-[#0D3B2E] border border-[#C9A84C]/25' : 'text-[#4A3728] hover:text-[#C9A84C] hover:bg-[#F0E8D0]/30' }}">Stories</a>
                    <a href="{{ route('contact') }}" class="px-4 py-2 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('contact') ? 'bg-[#F0E8D0]/80 text-[#0D3B2E] border border-[#C9A84C]/25' : 'text-[#4A3728] hover:text-[#C9A84C] hover:bg-[#F0E8D0]/30' }}">Contact</a>

                    @if(session('user_token') && isset($authUser))
                        <div class="h-6 w-px bg-[#C9A84C]/20 mx-2"></div>
                        <a href="{{ route('user.dashboard') }}" class="px-4 py-2 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('user.dashboard') ? 'bg-[#F0E8D0]/80 text-[#0D3B2E] border border-[#C9A84C]/25' : 'text-[#4A3728] hover:text-[#C9A84C] hover:bg-[#F0E8D0]/30' }}">Dashboard</a>
                        <a href="{{ route('user.matches') }}" class="px-4 py-2 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('user.matches') ? 'bg-[#F0E8D0]/80 text-[#0D3B2E] border border-[#C9A84C]/25' : 'text-[#4A3728] hover:text-[#C9A84C] hover:bg-[#F0E8D0]/30' }}">Find Matches</a>
                        <a href="{{ route('user.messages') }}" class="px-4 py-2 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('user.messages') ? 'bg-[#F0E8D0]/80 text-[#0D3B2E] border border-[#C9A84C]/25' : 'text-[#4A3728] hover:text-[#C9A84C] hover:bg-[#F0E8D0]/30' }}">
                            Messages
                            <span class="ml-1 px-1.5 py-0.5 text-xxs font-bold bg-[#C9A84C] text-[#0D3B2E] rounded-full leading-none">New</span>
                        </a>
                    @endif
                </nav>

                <!-- Action / User Dropdown (Desktop) -->
                <div class="hidden lg:flex items-center gap-4">
                    @if(session('user_token') && isset($authUser))
                        <!-- Notification bell -->
                        <a href="{{ route('user.notifications') }}" class="relative p-2 rounded-xl text-[#4A3728] hover:bg-[#F0E8D0]/60 hover:text-[#0D3B2E] transition-all">
                            <i class="fa-regular fa-bell text-xl"></i>
                            @if(isset($authUser['unread_notifications']) && $authUser['unread_notifications'] > 0)
                                <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-[#C9A84C] rounded-full animate-ping"></span>
                                <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-[#C9A84C] rounded-full"></span>
                            @endif
                        </a>

                        <!-- Dropdown -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" @click.away="open = false" class="flex items-center gap-2 p-1.5 rounded-xl border border-[#C9A84C]/25 hover:border-[#C9A84C]/50 hover:bg-[#F0E8D0]/30 transition-all duration-200">
                                <img src="{{ !empty($authUser['profile']) ? asset($authUser['profile']) : asset('profile/default-avatar.png') }}" 
                                     alt="Profile" 
                                     class="w-8 h-8 rounded-lg object-cover bg-[#F0E8D0]/55 border border-[#C9A84C]/20"
                                     onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($authUser['name']) }}&background=F0E8D0&color=0D3B2E'">
                                <span class="font-medium text-sm text-[#1A1208] pr-1 max-w-[120px] truncate">{{ $authUser['name'] }}</span>
                                <i class="fa-solid fa-angle-down text-slate-400 text-xs transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                            </button>
                            
                            <div x-show="open" 
                                 x-transition:enter="transition ease-out duration-100" 
                                 x-transition:enter-start="transform opacity-0 scale-95" 
                                 x-transition:enter-end="transform opacity-100 scale-100" 
                                 x-transition:leave="transition ease-in duration-75" 
                                 x-transition:leave-start="transform opacity-100 scale-100" 
                                 x-transition:leave-end="transform opacity-0 scale-95" 
                                 class="absolute right-0 mt-2 w-56 bg-[#FBF6EC] rounded-2xl shadow-xl border border-[#C9A84C]/25 py-2 origin-top-right z-50">
                                <div class="px-4 py-2.5 border-b border-[#C9A84C]/15">
                                    <p class="text-xs text-[#4A3728] font-medium">Signed in as</p>
                                    <p class="text-sm font-semibold text-[#1A1208] truncate">{{ $authUser['name'] }}</p>
                                    <span class="inline-flex mt-1 items-center px-2 py-0.5 rounded-full text-xxs font-medium bg-[#F0E8D0]/60 text-[#0D3B2E] border border-[#C9A84C]/20">
                                        ID: {{ $authUser['dummyid'] }}
                                    </span>
                                </div>
                                <a href="{{ route('user.profile') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-[#4A3728] hover:bg-[#F0E8D0]/50 hover:text-[#0D3B2E] transition-all"><i class="fa-regular fa-user text-[#C9A84C] w-4"></i> My Profile</a>
                                <a href="{{ route('user.profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-[#4A3728] hover:bg-[#F0E8D0]/50 hover:text-[#0D3B2E] transition-all"><i class="fa-regular fa-pen-to-square text-[#C9A84C] w-4"></i> Edit Profile</a>
                                <a href="{{ route('user.shortlist') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-[#4A3728] hover:bg-[#F0E8D0]/50 hover:text-[#0D3B2E] transition-all"><i class="fa-regular fa-heart text-[#C9A84C] w-4"></i> Shortlist</a>
                                <a href="{{ route('user.interests') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-[#4A3728] hover:bg-[#F0E8D0]/50 hover:text-[#0D3B2E] transition-all"><i class="fa-regular fa-paper-plane text-[#C9A84C] w-4"></i> Interests</a>
                                <a href="{{ route('user.settings') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-[#4A3728] hover:bg-[#F0E8D0]/50 hover:text-[#0D3B2E] transition-all"><i class="fa-regular fa-circle-question text-[#C9A84C] w-4"></i> Settings</a>
                                <div class="border-t border-[#C9A84C]/15 my-1"></div>
                                <form action="{{ route('user.logout') }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="flex w-full items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50/50 transition-all"><i class="fa-solid fa-arrow-right-from-bracket w-4"></i> Sign Out</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('user.login') }}" class="text-[#4A3728] hover:text-[#C9A84C] font-semibold transition-all">Sign In</a>
                        <a href="{{ route('user.register') }}" class="inline-flex items-center justify-center px-6 py-2.5 rounded-xl font-bold bg-gradient-to-r from-[#C9A84C] to-[#8B6914] text-[#0D3B2E] shadow-lg shadow-[#C9A84C]/35 hover:shadow-xl hover:shadow-[#C9A84C]/45 hover:-translate-y-0.5 transition-all duration-200">Register Free</a>
                    @endif
                </div>

                <!-- Hamburger Button (Mobile) -->
                <div class="lg:hidden flex items-center gap-3">
                    @if(session('user_token') && isset($authUser))
                        <a href="{{ route('user.notifications') }}" class="relative p-2 rounded-xl text-[#4A3728] hover:bg-[#F0E8D0]/50 hover:text-[#0D3B2E] transition-all">
                            <i class="fa-regular fa-bell text-xl"></i>
                        </a>
                    @endif
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-2 rounded-xl text-[#4A3728] hover:bg-[#F0E8D0]/40 hover:text-[#0D3B2E] transition-all focus:outline-none">
                        <i class="fa-solid text-xl" :class="mobileMenuOpen ? 'fa-xmark' : 'fa-bars'"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-150"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-4"
             class="lg:hidden bg-[#FBF6EC] border-t border-[#C9A84C]/25 py-4 shadow-inner">
            <div class="px-4 space-y-1">
                <a href="{{ route('home') }}" class="block px-4 py-2.5 rounded-xl text-base font-semibold text-[#4A3728] hover:bg-[#F0E8D0]/50 hover:text-[#0D3B2E] transition-all">Home</a>
                <a href="{{ route('about') }}" class="block px-4 py-2.5 rounded-xl text-base font-semibold text-[#4A3728] hover:bg-[#F0E8D0]/50 hover:text-[#0D3B2E] transition-all">About Us</a>
                <a href="{{ route('success-stories') }}" class="block px-4 py-2.5 rounded-xl text-base font-semibold text-[#4A3728] hover:bg-[#F0E8D0]/50 hover:text-[#0D3B2E] transition-all">Success Stories</a>
                <a href="{{ route('contact') }}" class="block px-4 py-2.5 rounded-xl text-base font-semibold text-[#4A3728] hover:bg-[#F0E8D0]/50 hover:text-[#0D3B2E] transition-all">Contact Us</a>

                @if(session('user_token') && isset($authUser))
                    <div class="border-t border-[#C9A84C]/15 my-3"></div>
                    <a href="{{ route('user.dashboard') }}" class="block px-4 py-2.5 rounded-xl text-base font-semibold text-[#4A3728] hover:bg-[#F0E8D0]/50 hover:text-[#0D3B2E] transition-all">Dashboard</a>
                    <a href="{{ route('user.matches') }}" class="block px-4 py-2.5 rounded-xl text-base font-semibold text-[#4A3728] hover:bg-[#F0E8D0]/50 hover:text-[#0D3B2E] transition-all">Find Matches</a>
                    <a href="{{ route('user.messages') }}" class="block px-4 py-2.5 rounded-xl text-base font-semibold text-[#4A3728] hover:bg-[#F0E8D0]/50 hover:text-[#0D3B2E] transition-all">Messages</a>
                    <a href="{{ route('user.profile') }}" class="block px-4 py-2.5 rounded-xl text-base font-semibold text-[#4A3728] hover:bg-[#F0E8D0]/50 hover:text-[#0D3B2E] transition-all">My Profile</a>
                    <a href="{{ route('user.profile.edit') }}" class="block px-4 py-2.5 rounded-xl text-base font-semibold text-[#4A3728] hover:bg-[#F0E8D0]/50 hover:text-[#0D3B2E] transition-all">Edit Profile</a>
                    <a href="{{ route('user.shortlist') }}" class="block px-4 py-2.5 rounded-xl text-base font-semibold text-[#4A3728] hover:bg-[#F0E8D0]/50 hover:text-[#0D3B2E] transition-all">Shortlist</a>
                    <a href="{{ route('user.interests') }}" class="block px-4 py-2.5 rounded-xl text-base font-semibold text-[#4A3728] hover:bg-[#F0E8D0]/50 hover:text-[#0D3B2E] transition-all">Interests</a>
                    <a href="{{ route('user.settings') }}" class="block px-4 py-2.5 rounded-xl text-base font-semibold text-[#4A3728] hover:bg-[#F0E8D0]/50 hover:text-[#0D3B2E] transition-all">Settings</a>
                    
                    <div class="border-t border-[#C9A84C]/15 my-3"></div>
                    <form action="{{ route('user.logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2.5 rounded-xl text-base font-bold text-red-600 hover:bg-red-50/50 transition-all">Sign Out</button>
                    </form>
                @else
                    <div class="border-t border-[#C9A84C]/15 my-3"></div>
                    <a href="{{ route('user.login') }}" class="block text-center px-4 py-2.5 rounded-xl text-base font-bold text-[#4A3728] hover:bg-[#F0E8D0]/40 transition-all">Sign In</a>
                    <a href="{{ route('user.register') }}" class="block text-center px-4 py-2.5 rounded-xl text-base font-bold bg-gradient-to-r from-[#C9A84C] to-[#8B6914] text-[#0D3B2E] shadow-md transition-all">Register Free</a>
                @endif
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Toast Notification System -->
    <div x-data="{ 
            show: false, 
            message: '', 
            type: 'success',
            init() {
                @if(session('success'))
                    this.trigger('{{ session('success') }}', 'success');
                @elseif(session('error'))
                    this.trigger('{{ session('error') }}', 'error');
                @endif
            },
            trigger(msg, type) {
                this.message = msg;
                this.type = type;
                this.show = true;
                setTimeout(() => this.show = false, 4000);
            }
         }"
         x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:translate-x-4"
         x-transition:enter-end="opacity-100 translate-y-0 sm:translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 sm:translate-x-0"
         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:translate-x-4"
         class="fixed bottom-5 right-5 z-50 max-w-sm w-full bg-white rounded-2xl shadow-2xl border border-slate-100 p-4 flex items-start gap-3"
         style="display: none;">
        
        <span :class="type === 'success' ? 'bg-emerald-100 text-emerald-600' : 'bg-rose-100 text-rose-600'" 
              class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0">
            <i :class="type === 'success' ? 'fa-solid fa-circle-check' : 'fa-solid fa-circle-xmark'" class="text-lg"></i>
        </span>
        <div class="flex-grow">
            <h4 class="font-bold text-sm text-slate-800" x-text="type === 'success' ? 'Success' : 'Error'">Notification</h4>
            <p class="text-xs text-slate-500 mt-0.5" x-text="message"></p>
        </div>
        <button @click="show = false" class="text-slate-400 hover:text-slate-600 transition-all">
            <i class="fa-solid fa-xmark text-sm"></i>
        </button>
    </div>

    <!-- Footer -->
    <footer class="bg-[#091f19] text-[#FBF6EC]/70 pt-16 pb-8 border-t-4 border-[#C9A84C]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
                <!-- Info Column -->
                <div class="space-y-4">
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                        @if(!empty($settings['logo']) || !empty($settings['logo_dark']))
                            <img src="{{ asset($settings['logo'] ?? $settings['logo_dark']) }}" alt="{{ $settings['title'] ?? 'NikahTime' }}" class="h-10 w-auto object-contain">
                        @else
                            <span class="w-8 h-8 rounded-lg bg-[#C9A84C] flex items-center justify-center">
                                <i class="fa-solid fa-heart text-[#0D3B2E] text-sm"></i>
                            </span>
                            <span class="font-display font-extrabold text-xl text-white">{{ $settings['title'] ?? 'NikahTime' }}</span>
                        @endif
                    </a>
                    <p class="text-sm leading-relaxed text-[#FBF6EC]/60">Find your perfect life partner with our advanced, verified matching algorithms. We bring hearts together with trust and care.</p>
                    <div class="flex gap-3 pt-2">
                        <a href="#" class="w-9 h-9 rounded-xl bg-[#0D3B2E] hover:bg-[#C9A84C] text-[#FBF6EC]/70 hover:text-[#0D3B2E] flex items-center justify-center transition-all duration-200"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" class="w-9 h-9 rounded-xl bg-[#0D3B2E] hover:bg-[#C9A84C] text-[#FBF6EC]/70 hover:text-[#0D3B2E] flex items-center justify-center transition-all duration-200"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="w-9 h-9 rounded-xl bg-[#0D3B2E] hover:bg-[#C9A84C] text-[#FBF6EC]/70 hover:text-[#0D3B2E] flex items-center justify-center transition-all duration-200"><i class="fa-brands fa-twitter"></i></a>
                    </div>
                </div>

                <!-- Navigation Column -->
                <div>
                    <h4 class="font-bold text-[#E8D08A] text-sm tracking-wider uppercase mb-6">Explore</h4>
                    <ul class="space-y-3.5 text-sm">
                        <li><a href="{{ route('home') }}" class="hover:text-[#E8D08A] transition-colors">Home</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-[#E8D08A] transition-colors">About Us</a></li>
                        <li><a href="{{ route('success-stories') }}" class="hover:text-[#E8D08A] transition-colors">Success Stories</a></li>
                    </ul>
                </div>

                <!-- Terms Column -->
                <div>
                    <h4 class="font-bold text-[#E8D08A] text-sm tracking-wider uppercase mb-6">Legal</h4>
                    <ul class="space-y-3.5 text-sm">
                        <li><a href="{{ route('privacy') }}" class="hover:text-[#E8D08A] transition-colors">Privacy Policy</a></li>
                        <li><a href="{{ route('terms') }}" class="hover:text-[#E8D08A] transition-colors">Terms of Service</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-[#E8D08A] transition-colors">Help & Support</a></li>
                    </ul>
                </div>

                <!-- Contact Column -->
                <div>
                    <h4 class="font-bold text-[#E8D08A] text-sm tracking-wider uppercase mb-6">Contact</h4>
                    <ul class="space-y-4 text-sm">
                        <li class="flex items-start gap-3">
                            <i class="fa-solid fa-location-dot text-[#C9A84C] mt-1"></i>
                            <span>{{ $settings['address'] ?? '123 Romance Valley, Suite 500, New Delhi, India' }}</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fa-solid fa-phone text-[#C9A84C]"></i>
                            <span>{{ $settings['mobile'] ?? '+91 91490 89862' }}</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fa-solid fa-envelope text-[#C9A84C]"></i>
                            <span>{{ $settings['email'] ?? 'support@nikahtime.com' }}</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-[#C9A84C]/25 mt-16 pt-8 text-center text-xs text-[#FBF6EC]/45">
                <p>&copy; {{ date('Y') }} {{ $settings['title'] ?? 'NikahTime' }}. All rights reserved. Designed with love.</p>
            </div>
        </div>
    </footer>
</body>
</html>
