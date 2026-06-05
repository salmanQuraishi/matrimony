@extends('layouts.frontend')

@section('title', 'Success Stories')

@section('content')
<div class="py-16 sm:py-24 bg-gradient-to-b from-slate-50 to-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center max-w-3xl mx-auto mb-20 space-y-3">
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-rose-100 text-rose-600 uppercase tracking-wider">
                <i class="fa-solid fa-heart-pulse"></i> Perfect Matches
            </span>
            <h1 class="font-display font-extrabold text-4xl text-slate-900 leading-tight">Matched by NikahTime</h1>
            <p class="text-slate-500 text-sm sm:text-base leading-relaxed">Read inspiring stories of couples who found their life partner on our platform. From matching preferences to holding hands for life.</p>
        </div>

        <!-- Stories Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
            <!-- Story 1 -->
            <div class="bg-white rounded-3xl border border-slate-100 overflow-hidden shadow-sm hover:shadow-md transition-all duration-300">
                <div class="h-64 bg-slate-200 relative">
                    <img src="https://images.unsplash.com/photo-1621605815971-fbc98d665033?w=600&auto=format&fit=crop&q=80" alt="Couple" class="w-full h-full object-cover">
                    <span class="absolute bottom-4 left-4 bg-white/95 backdrop-blur-sm px-3 py-1.5 rounded-full font-bold text-xs text-rose-600">Married In 2025</span>
                </div>
                <div class="p-8 space-y-4">
                    <h3 class="font-display font-bold text-xl text-slate-800">Aisha & Imran</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">"We connected through NikahTime's religion filter and hit it off immediately. Our families met two weeks later, and everything went wonderfully."</p>
                </div>
            </div>

            <!-- Story 2 -->
            <div class="bg-white rounded-3xl border border-slate-100 overflow-hidden shadow-sm hover:shadow-md transition-all duration-300">
                <div class="h-64 bg-slate-200 relative">
                    <img src="https://images.unsplash.com/photo-1607190074257-dd4b7af0309f?w=600&auto=format&fit=crop&q=80" alt="Couple" class="w-full h-full object-cover">
                    <span class="absolute bottom-4 left-4 bg-white/95 backdrop-blur-sm px-3 py-1.5 rounded-full font-bold text-xs text-rose-600">Married In 2026</span>
                </div>
                <div class="p-8 space-y-4">
                    <h3 class="font-display font-bold text-xl text-slate-800">Sana & Kabir</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">"I was skeptical about online matrimony, but NikahTime's detail-oriented profile options helped me discover exactly what I was searching for."</p>
                </div>
            </div>

            <!-- Story 3 -->
            <div class="bg-white rounded-3xl border border-slate-100 overflow-hidden shadow-sm hover:shadow-md transition-all duration-300">
                <div class="h-64 bg-slate-200 relative">
                    <img src="https://images.unsplash.com/photo-1583939003579-730e3918a45a?w=600&auto=format&fit=crop&q=80" alt="Couple" class="w-full h-full object-cover">
                    <span class="absolute bottom-4 left-4 bg-white/95 backdrop-blur-sm px-3 py-1.5 rounded-full font-bold text-xs text-rose-600">Married In 2026</span>
                </div>
                <div class="p-8 space-y-4">
                    <h3 class="font-display font-bold text-xl text-slate-800">Zoya & Zaid</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">"The platform's secure messaging permitted us to get to know each other comfortably at our own speed before involving our parents."</p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
