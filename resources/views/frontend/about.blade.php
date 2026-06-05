@extends('layouts.frontend')

@section('title', 'About Us')

@section('content')
<!-- Intro -->
<div class="py-16 sm:py-24 bg-gradient-to-br from-rose-50/30 to-indigo-50/20 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-6">
        <span class="text-rose-500 font-bold text-sm uppercase tracking-wider">Our Journey</span>
        <h1 class="font-display font-extrabold text-4xl sm:text-5xl text-slate-900 leading-tight">
            Connecting Hearts, Building Families
        </h1>
        <p class="text-slate-600 max-w-3xl mx-auto text-base sm:text-lg leading-relaxed">
            NikahTime was founded with a single mission: to help individuals find their perfect life partner in a secure, respectful, and modern environment. We combine traditional values with modern technology.
        </p>
    </div>
</div>

<!-- Values -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="p-8 border border-slate-100 rounded-3xl space-y-4">
                <span class="w-12 h-12 rounded-2xl bg-rose-100 text-rose-500 flex items-center justify-center text-xl"><i class="fa-solid fa-shield-heart"></i></span>
                <h3 class="font-display font-bold text-xl text-slate-800">Trust & Security</h3>
                <p class="text-slate-500 text-sm leading-relaxed">Every account undergoes rigorous verification filters to eliminate spam and fake listings, ensuring safe connections.</p>
            </div>
            
            <div class="p-8 border border-slate-100 rounded-3xl space-y-4">
                <span class="w-12 h-12 rounded-2xl bg-pink-100 text-pink-500 flex items-center justify-center text-xl"><i class="fa-solid fa-circle-nodes"></i></span>
                <h3 class="font-display font-bold text-xl text-slate-800">Advanced Matchmaking</h3>
                <p class="text-slate-500 text-sm leading-relaxed">Our criteria matching systems recommend partners aligned with your lifestyle, professional plans, and values.</p>
            </div>

            <div class="p-8 border border-slate-100 rounded-3xl space-y-4">
                <span class="w-12 h-12 rounded-2xl bg-indigo-100 text-indigo-500 flex items-center justify-center text-xl"><i class="fa-solid fa-users-line"></i></span>
                <h3 class="font-display font-bold text-xl text-slate-800">Community Focused</h3>
                <p class="text-slate-500 text-sm leading-relaxed">Filter matches based on religious interests, family regions, languages, and specific educational background levels.</p>
            </div>
        </div>
    </div>
</section>

<!-- Stats banner -->
<section class="bg-slate-900 text-white py-16 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 text-center">
            <div class="space-y-2">
                <p class="font-display font-extrabold text-4xl sm:text-5xl text-rose-500">10,000+</p>
                <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Registered Members</p>
            </div>
            <div class="space-y-2">
                <p class="font-display font-extrabold text-4xl sm:text-5xl text-rose-500">2,500+</p>
                <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Happy Marriages</p>
            </div>
            <div class="space-y-2">
                <p class="font-display font-extrabold text-4xl sm:text-5xl text-rose-500">99.2%</p>
                <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Verification Rate</p>
            </div>
            <div class="space-y-2">
                <p class="font-display font-extrabold text-4xl sm:text-5xl text-rose-500">24/7</p>
                <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Customer Support</p>
            </div>
        </div>
    </div>
</section>
@endsection
