@extends('layouts.frontend')

@section('title', 'Privacy Policy')

@section('content')
<div class="py-16 bg-white min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <h1 class="font-display font-extrabold text-4xl text-slate-900 border-b border-slate-100 pb-4">Privacy Policy</h1>
        
        <p class="text-slate-500 font-medium text-sm">Last updated: June 5, 2026</p>

        <section class="space-y-4">
            <h2 class="font-display font-bold text-2xl text-slate-800">1. Information We Collect</h2>
            <p class="text-slate-600 leading-relaxed text-sm">
                We collect personal information such as names, email addresses, phone numbers, and profile details including caste, religion, complexion, educational status, and income range. This information helps us build an accurate matrimony profile and recommend relevant matches.
            </p>
        </section>

        <section class="space-y-4">
            <h2 class="font-display font-bold text-2xl text-slate-800">2. How We Use Your Information</h2>
            <p class="text-slate-600 leading-relaxed text-sm">
                Your profile information is shared with other registered members on the site to facilitate matchmaking. We do not sell or trade your personal information with third parties. Verification documents (if uploaded) are kept confidential and only used for profile approval.
            </p>
        </section>

        <section class="space-y-4">
            <h2 class="font-display font-bold text-2xl text-slate-800">3. Security of Your Data</h2>
            <p class="text-slate-600 leading-relaxed text-sm">
                We implement strict security measures to protect your account. While no platform can guarantee 100% absolute security, we use modern token-based auth (Sanctum) and standard encryption methods to protect data.
            </p>
        </section>
    </div>
</div>
@endsection
