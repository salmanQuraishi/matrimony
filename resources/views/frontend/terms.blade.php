@extends('layouts.frontend')

@section('title', 'Terms & Conditions')

@section('content')
<div class="py-16 bg-white min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <h1 class="font-display font-extrabold text-4xl text-slate-900 border-b border-slate-100 pb-4">Terms & Conditions</h1>
        
        <p class="text-slate-500 font-medium text-sm">Last updated: June 5, 2026</p>

        <section class="space-y-4">
            <h2 class="font-display font-bold text-2xl text-slate-800">1. Eligibility</h2>
            <p class="text-slate-600 leading-relaxed text-sm">
                By registering, you confirm that you are of legal marriageable age according to the laws of your country (18 years for females and 21 years for males in India). The profile is intended only for users seeking a genuine marital relationship.
            </p>
        </section>

        <section class="space-y-4">
            <h2 class="font-display font-bold text-2xl text-slate-800">2. Account Responsibility</h2>
            <p class="text-slate-600 leading-relaxed text-sm">
                You are responsible for keeping your login credentials confidential. You agree to upload accurate information. Fake names, photos, or false details are strictly prohibited and will lead to profile suspension.
            </p>
        </section>

        <section class="space-y-4">
            <h2 class="font-display font-bold text-2xl text-slate-800">3. Behavior & Conduct</h2>
            <p class="text-slate-600 leading-relaxed text-sm">
                You agree to treat other members with respect. Sending abusive, threatening, or offensive messages through the chat system will result in instant deactivation and potential reporting to law enforcement authorities.
            </p>
        </section>
    </div>
</div>
@endsection
