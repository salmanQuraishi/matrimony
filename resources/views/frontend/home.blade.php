@extends('layouts.frontend')

@section('title', 'Find Your Perfect Match')

@section('content')
<!-- Hero Section -->
<div class="relative bg-gradient-to-br from-[#FBF6EC] via-[#F0E8D0]/40 to-[#FBF6EC] overflow-hidden py-20 lg:py-32">
    <!-- Decorative Blobs -->
    <div class="absolute top-0 left-0 w-80 h-80 bg-[#C9A84C]/10 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-[#0D3B2E]/5 rounded-full blur-3xl translate-x-1/3 translate-y-1/3"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <!-- Hero Text -->
            <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-[#F0E8D0]/60 text-[#8B6914] border border-[#C9A84C]/25 tracking-wide uppercase">
                    <i class="fa-solid fa-star"></i> India's Trusted Matrimony Site
                </span>
                <h1 class="font-display font-extrabold text-4xl sm:text-5xl lg:text-6xl text-[#0D3B2E] leading-tight">
                    Every Love Story is Beautiful, Make Yours <span class="bg-gradient-to-r from-[#C9A84C] to-[#8B6914] bg-clip-text text-transparent">Special</span>
                </h1>
                <p class="text-base sm:text-lg text-[#4A3728]/80 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                    Find genuine matches with complete privacy and security. Our advanced matching connects you with partners who share your values and lifestyle.
                </p>
                
                <div class="flex flex-wrap justify-center lg:justify-start gap-4">
                    @if(session('user_token') && isset($authUser))
                        <a href="{{ route('user.dashboard') }}" class="inline-flex items-center justify-center px-8 py-4 rounded-2xl font-bold bg-gradient-to-r from-[#C9A84C] to-[#8B6914] text-[#0D3B2E] shadow-lg shadow-[#C9A84C]/35 hover:shadow-xl hover:shadow-[#C9A84C]/45 hover:-translate-y-0.5 transition-all duration-200">
                            Go to Dashboard
                        </a>
                    @else
                        <a href="{{ route('user.register') }}" class="inline-flex items-center justify-center px-8 py-4 rounded-2xl font-bold bg-gradient-to-r from-[#C9A84C] to-[#8B6914] text-[#0D3B2E] shadow-lg shadow-[#C9A84C]/35 hover:shadow-xl hover:shadow-[#C9A84C]/45 hover:-translate-y-0.5 transition-all duration-200">
                            Register Free
                        </a>
                    @endif
                    <a href="#features" class="inline-flex items-center justify-center px-8 py-4 rounded-2xl font-semibold bg-white text-[#4A3728] border border-[#C9A84C]/35 hover:bg-[#FBF6EC]/50 hover:-translate-y-0.5 transition-all duration-200">
                        Learn More
                    </a>
                </div>
            </div>

            <!-- Hero Search Card -->
            <div class="lg:col-span-5">
                <div class="bg-white rounded-3xl shadow-xl border border-[#C9A84C]/20 p-8">
                    <h3 class="font-display font-bold text-2xl text-[#0D3B2E] mb-6 text-center">Find Your Partner</h3>
                    
                    <form action="{{ session('user_token') ? route('user.matches') : route('user.login') }}" method="GET" class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-[#4A3728]/70 uppercase tracking-wider mb-2">I am looking for a</label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="border border-[#C9A84C]/25 rounded-xl p-3 flex items-center justify-center gap-2 cursor-pointer hover:bg-[#FBF6EC]/40 transition-all font-semibold text-sm text-[#4A3728]">
                                    <input type="radio" name="gender" value="female" checked class="text-[#0D3B2E] focus:ring-[#C9A84C] border-[#C9A84C]/40 bg-transparent">
                                    Bride
                                </label>
                                <label class="border border-[#C9A84C]/25 rounded-xl p-3 flex items-center justify-center gap-2 cursor-pointer hover:bg-[#FBF6EC]/40 transition-all font-semibold text-sm text-[#4A3728]">
                                    <input type="radio" name="gender" value="male" class="text-[#0D3B2E] focus:ring-[#C9A84C] border-[#C9A84C]/40 bg-transparent">
                                    Groom
                                </label>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-[#4A3728]/70 uppercase tracking-wider mb-2">Of Religion</label>
                            <select name="religion" class="w-full rounded-xl border-[#C9A84C]/35 bg-[#FBF6EC]/30 text-[#1A1208] text-sm font-medium focus:ring-[#C9A84C] focus:border-[#C9A84C] py-3">
                                <option value="" class="text-slate-500">Select Religion</option>
                                @foreach($religions as $religion)
                                    <option value="{{ $religion['rid'] }}">{{ $religion['name'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-[#4A3728]/70 uppercase tracking-wider mb-2">Age Min</label>
                                <select name="age_min" class="w-full rounded-xl border-[#C9A84C]/35 bg-[#FBF6EC]/30 text-[#1A1208] text-sm font-medium focus:ring-[#C9A84C] focus:border-[#C9A84C] py-3">
                                    @for($i = 18; $i <= 50; $i++)
                                        <option value="{{ $i }}" {{ $i == 21 ? 'selected' : '' }}>{{ $i }} Years</option>
                                    @endfor
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-[#4A3728]/70 uppercase tracking-wider mb-2">Age Max</label>
                                <select name="age_max" class="w-full rounded-xl border-[#C9A84C]/35 bg-[#FBF6EC]/30 text-[#1A1208] text-sm font-medium focus:ring-[#C9A84C] focus:border-[#C9A84C] py-3">
                                    @for($i = 18; $i <= 55; $i++)
                                        <option value="{{ $i }}" {{ $i == 30 ? 'selected' : '' }}>{{ $i }} Years</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-[#4A3728]/70 uppercase tracking-wider mb-2">Located in Country</label>
                            <select id="homeCountrySelect" name="country" onchange="loadHomeStates(this.value)" class="w-full rounded-xl border-[#C9A84C]/35 bg-[#FBF6EC]/30 text-[#1A1208] text-sm font-medium focus:ring-[#C9A84C] focus:border-[#C9A84C] py-3">
                                <option value="" class="text-slate-500">Select Country</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country['id'] }}">{{ $country['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-[#4A3728]/70 uppercase tracking-wider mb-2">Located in State</label>
                            <select id="homeStateSelect" name="state" onchange="loadHomeCities(this.value)" class="w-full rounded-xl border-[#C9A84C]/35 bg-[#FBF6EC]/30 text-[#1A1208] text-sm font-medium focus:ring-[#C9A84C] focus:border-[#C9A84C] py-3">
                                <option value="" class="text-slate-500">Select State</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-[#4A3728]/70 uppercase tracking-wider mb-2">Located in City</label>
                            <select id="homeCitySelect" name="city" class="w-full rounded-xl border-[#C9A84C]/35 bg-[#FBF6EC]/30 text-[#1A1208] text-sm font-medium focus:ring-[#C9A84C] focus:border-[#C9A84C] py-3">
                                <option value="" class="text-slate-500">Select City</option>
                            </select>
                        </div>

                        <button type="submit" class="w-full py-4 rounded-xl font-bold bg-gradient-to-r from-[#C9A84C] to-[#8B6914] text-[#0D3B2E] shadow-lg shadow-[#C9A84C]/20 hover:shadow-[#C9A84C]/35 hover:-translate-y-0.5 transition-all duration-200 mt-2">
                            Search Matches
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- How It Works Section -->
<section class="py-20 bg-white border-b border-[#C9A84C]/15">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
            <span class="text-[#C9A84C] font-bold text-sm uppercase tracking-wider">Simple Steps</span>
            <h2 class="font-display font-extrabold text-3xl sm:text-4xl text-[#0D3B2E]">How NikahTime Works</h2>
            <p class="text-[#4A3728]/70 text-sm sm:text-base leading-relaxed">Getting started is simple and quick. Complete your profile in just a few minutes and begin connecting.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Step 1 -->
            <div class="text-center space-y-4">
                <div class="w-12 h-12 rounded-full bg-[#F0E8D0]/60 text-[#0D3B2E] border border-[#C9A84C]/25 flex items-center justify-center font-bold text-lg mx-auto shadow-sm">1</div>
                <h3 class="font-display font-bold text-lg text-[#1A1208]">Create Profile</h3>
                <p class="text-[#4A3728]/70 text-sm leading-relaxed">Register for free and describe your background, interest, and what you are looking for.</p>
            </div>

            <!-- Step 2 -->
            <div class="text-center space-y-4">
                <div class="w-12 h-12 rounded-full bg-[#F0E8D0]/60 text-[#0D3B2E] border border-[#C9A84C]/25 flex items-center justify-center font-bold text-lg mx-auto shadow-sm">2</div>
                <h3 class="font-display font-bold text-lg text-[#1A1208]">Browse Matches</h3>
                <p class="text-[#4A3728]/70 text-sm leading-relaxed">Search through verified profiles based on location, education, community, and more.</p>
            </div>

            <!-- Step 3 -->
            <div class="text-center space-y-4">
                <div class="w-12 h-12 rounded-full bg-[#F0E8D0]/60 text-[#0D3B2E] border border-[#C9A84C]/25 flex items-center justify-center font-bold text-lg mx-auto shadow-sm">3</div>
                <h3 class="font-display font-bold text-lg text-[#1A1208]">Connect & Chat</h3>
                <p class="text-[#4A3728]/70 text-sm leading-relaxed">Send match requests to profiles you like and begin conversing securely once accepted.</p>
            </div>

            <!-- Step 4 -->
            <div class="text-center space-y-4">
                <div class="w-12 h-12 rounded-full bg-[#F0E8D0]/60 text-[#0D3B2E] border border-[#C9A84C]/25 flex items-center justify-center font-bold text-lg mx-auto shadow-sm">4</div>
                <h3 class="font-display font-bold text-lg text-[#1A1208]">Meet Your Partner</h3>
                <p class="text-[#4A3728]/70 text-sm leading-relaxed">Take the next step with confidence and write your own beautiful success story.</p>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section id="features" class="py-20 bg-[#FBF6EC]/40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <div class="lg:col-span-5 space-y-6">
                <span class="text-[#C9A84C] font-bold text-sm uppercase tracking-wider">Our Best Features</span>
                <h2 class="font-display font-extrabold text-3xl sm:text-4xl text-[#0D3B2E]">Why Choose NikahTime?</h2>
                <p class="text-[#4A3728]/75 leading-relaxed">Unlike basic matchmaking tools, NikahTime is specifically tailored for long-term relationships and marital compatibility with verification.</p>
                <ul class="space-y-4">
                    <li class="flex items-center gap-3">
                        <span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs"><i class="fa-solid fa-check"></i></span>
                        <span class="font-semibold text-[#1A1208]">Detailed Family & Professional Backgrounds</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs"><i class="fa-solid fa-check"></i></span>
                        <span class="font-semibold text-[#1A1208]">Strict Privacy Settings & Photo Controls</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs"><i class="fa-solid fa-check"></i></span>
                        <span class="font-semibold text-[#1A1208]">Dedicated Verification Processes</span>
                    </li>
                </ul>
            </div>

            <div class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-[#C9A84C]/15 hover:border-[#C9A84C]/45 transition-all">
                    <i class="fa-solid fa-shield-halved text-[#C9A84C] text-3xl mb-4"></i>
                    <h4 class="font-display font-bold text-lg text-[#0D3B2E] mb-2">Safe & Secure</h4>
                    <p class="text-[#4A3728]/70 text-sm leading-relaxed">Verify contacts, restrict media permissions, and prevent unwanted profile exposure easily.</p>
                </div>
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-[#C9A84C]/15 hover:border-[#C9A84C]/45 transition-all">
                    <i class="fa-regular fa-bell text-[#C9A84C] text-3xl mb-4"></i>
                    <h4 class="font-display font-bold text-lg text-[#0D3B2E] mb-2">Instant Updates</h4>
                    <p class="text-[#4A3728]/70 text-sm leading-relaxed">Get notified immediately when someone views your profile, likes you, or responds to interest requests.</p>
                </div>
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-[#C9A84C]/15 hover:border-[#C9A84C]/45 transition-all">
                    <i class="fa-solid fa-wand-magic-sparkles text-[#C9A84C] text-3xl mb-4"></i>
                    <h4 class="font-display font-bold text-lg text-[#0D3B2E] mb-2">Smart Filters</h4>
                    <p class="text-[#4A3728]/70 text-sm leading-relaxed">Refine by community, annual earnings, qualification level, work sector, and current address.</p>
                </div>
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-[#C9A84C]/15 hover:border-[#C9A84C]/45 transition-all">
                    <i class="fa-solid fa-id-card text-[#C9A84C] text-3xl mb-4"></i>
                    <h4 class="font-display font-bold text-lg text-[#0D3B2E] mb-2">Digital Nikah Cards</h4>
                    <p class="text-[#4A3728]/70 text-sm leading-relaxed">Create and customize invitations, download PDFs, and print cards with beautiful pre-made layouts.</p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
            <span class="text-[#C9A84C] font-bold text-sm uppercase tracking-wider">Success Stories</span>
            <h2 class="font-display font-extrabold text-3xl sm:text-4xl text-[#0D3B2E]">Matched by NikahTime</h2>
            <p class="text-[#4A3728]/70 text-sm sm:text-base leading-relaxed">Read inspiring stories of couples who found their life partner on our platform.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 pt-8">
            <!-- Testimonial 1 -->
            <div class="bg-[#FBF6EC]/40 rounded-3xl overflow-hidden border border-[#C9A84C]/15 flex flex-col justify-between">
                <div class="relative h-64 bg-slate-200">
                    <img src="https://images.unsplash.com/photo-1583939003579-730e3918a45a?auto=format&fit=crop&q=80" alt="Couple" class="w-full h-full object-cover">
                    <span class="absolute bottom-4 left-4 bg-white/95 backdrop-blur-sm px-3 py-1.5 rounded-full font-bold text-xs text-[#0D3B2E] border border-[#C9A84C]/25">Married In 2025</span>
                </div>
                <div class="p-8 space-y-4">
                    <h4 class="font-display font-bold text-lg text-[#1A1208]">Aisha & Imran</h4>
                    <p class="text-[#4A3728]/75 text-sm leading-relaxed">"We connected through NikahTime's religion filter and hit it off immediately. Our families met two weeks later, and everything went wonderfully."</p>
                </div>
            </div>

            <!-- Testimonial 2 -->
            <div class="bg-[#FBF6EC]/40 rounded-3xl overflow-hidden border border-[#C9A84C]/15 flex flex-col justify-between">
                <div class="relative h-64 bg-slate-200">
                    <img src="https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&q=80" alt="Couple" class="w-full h-full object-cover">
                    <span class="absolute bottom-4 left-4 bg-white/95 backdrop-blur-sm px-3 py-1.5 rounded-full font-bold text-xs text-[#0D3B2E] border border-[#C9A84C]/25">Married In 2025</span>
                </div>
                <div class="p-8 space-y-4">
                    <h4 class="font-display font-bold text-lg text-[#1A1208]">Sana & Kabir</h4>
                    <p class="text-[#4A3728]/75 text-sm leading-relaxed">"I was skeptical about online matrimony, but NikahTime's detail-oriented profile options helped me discover exactly what I was searching for."</p>
                </div>
            </div>

            <!-- Testimonial 3 -->
            <div class="bg-[#FBF6EC]/40 rounded-3xl overflow-hidden border border-[#C9A84C]/15 flex flex-col justify-between">
                <div class="relative h-64 bg-slate-200">
                    <img src="https://images.unsplash.com/photo-1511285560929-80b456fea0bc?auto=format&fit=crop&q=80" alt="Couple" class="w-full h-full object-cover">
                    <span class="absolute bottom-4 left-4 bg-white/95 backdrop-blur-sm px-3 py-1.5 rounded-full font-bold text-xs text-[#0D3B2E] border border-[#C9A84C]/25">Married In 2026</span>
                </div>
                <div class="p-8 space-y-4">
                    <h4 class="font-display font-bold text-lg text-[#1A1208]">Zoya & Zaid</h4>
                    <p class="text-[#4A3728]/75 text-sm leading-relaxed">"The platform's secure messaging permitted us to get to know each other comfortably at our own speed before involving our parents."</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call To Action -->
<section class="bg-[#091f19] relative py-20 overflow-hidden border-t-4 border-[#C9A84C]">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_bottom_left,rgba(201,168,76,0.08),transparent_40%)]"></div>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center space-y-8">
        <h2 class="font-display font-extrabold text-3xl sm:text-4xl lg:text-5xl text-white leading-tight">
            Find Your Companion for Life Today
        </h2>
        <p class="text-[#FBF6EC]/70 max-w-2xl mx-auto text-sm sm:text-base leading-relaxed">
            Join thousands of individuals currently exploring matches. Registration is completely free and takes less than 3 minutes.
        </p>
        <div class="flex justify-center">
            @if(session('user_token') && isset($authUser))
                <a href="{{ route('user.dashboard') }}" class="inline-flex items-center justify-center px-8 py-4 rounded-2xl font-bold bg-gradient-to-r from-[#C9A84C] to-[#8B6914] text-[#0D3B2E] shadow-lg shadow-[#C9A84C]/35 hover:shadow-xl hover:shadow-[#C9A84C]/45 hover:-translate-y-0.5 transition-all duration-200">
                    Go to Dashboard
                </a>
            @else
                <a href="{{ route('user.register') }}" class="inline-flex items-center justify-center px-8 py-4 rounded-2xl font-bold bg-gradient-to-r from-[#C9A84C] to-[#8B6914] text-[#0D3B2E] shadow-lg shadow-[#C9A84C]/35 hover:shadow-xl hover:shadow-[#C9A84C]/45 hover:-translate-y-0.5 transition-all duration-200">
                    Register Free Now
                </a>
            @endif
        </div>
</section>

<script>
    function loadHomeStates(countryId) {
        const stateSelect = document.getElementById('homeStateSelect');
        const citySelect = document.getElementById('homeCitySelect');
        stateSelect.innerHTML = '<option value="">Loading states...</option>';
        citySelect.innerHTML = '<option value="">Select City</option>';

        if (!countryId) {
            stateSelect.innerHTML = '<option value="">Select State</option>';
            return;
        }

        fetch(`/ajax/states/${countryId}`)
            .then(res => res.json())
            .then(data => {
                stateSelect.innerHTML = '<option value="">Select State</option>';
                if (data.status && data.data) {
                    data.data.forEach(state => {
                        stateSelect.innerHTML += `<option value="${state.sid}">${state.name}</option>`;
                    });
                } else {
                    stateSelect.innerHTML = '<option value="">No states found</option>';
                }
            })
            .catch(() => {
                stateSelect.innerHTML = '<option value="">Error loading states</option>';
            });
    }

    function loadHomeCities(stateId) {
        const citySelect = document.getElementById('homeCitySelect');
        citySelect.innerHTML = '<option value="">Loading cities...</option>';

        if (!stateId) {
            citySelect.innerHTML = '<option value="">Select City</option>';
            return;
        }

        fetch(`/ajax/cities/${stateId}`)
            .then(res => res.json())
            .then(data => {
                citySelect.innerHTML = '<option value="">Select City</option>';
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
