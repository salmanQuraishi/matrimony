@extends('layouts.frontend')

@section('title', 'Contact Us')

@section('content')
<div class="py-16 sm:py-24 bg-gradient-to-b from-slate-50 to-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
            <span class="text-rose-500 font-bold text-sm uppercase tracking-wider">Get In Touch</span>
            <h1 class="font-display font-extrabold text-4xl text-slate-900">We'd Love to Hear From You</h1>
            <p class="text-slate-500 text-sm sm:text-base leading-relaxed">Our support desk is always here to assist you with registration, profile queries, and membership upgrades.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start max-w-5xl mx-auto">
            <!-- Contact Details -->
            <div class="lg:col-span-5 space-y-6">
                <!-- Phone -->
                <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm flex items-start gap-4">
                    <span class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-500 flex items-center justify-center text-xl flex-shrink-0"><i class="fa-solid fa-phone"></i></span>
                    <div>
                        <h4 class="font-display font-bold text-slate-800 text-base">Call Support</h4>
                        <p class="text-sm text-slate-500 mt-1">+91 91490 89862</p>
                        <p class="text-xs text-slate-400 mt-0.5 font-medium">Mon-Sat, 9am - 6pm IST</p>
                    </div>
                </div>

                <!-- Email -->
                <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm flex items-start gap-4">
                    <span class="w-12 h-12 rounded-2xl bg-pink-50 text-pink-500 flex items-center justify-center text-xl flex-shrink-0"><i class="fa-solid fa-envelope"></i></span>
                    <div>
                        <h4 class="font-display font-bold text-slate-800 text-base">Email Us</h4>
                        <p class="text-sm text-slate-500 mt-1">support@nikahtime.com</p>
                        <p class="text-xs text-slate-400 mt-0.5 font-medium">Response within 24 hours</p>
                    </div>
                </div>

                <!-- Office -->
                <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm flex items-start gap-4">
                    <span class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-500 flex items-center justify-center text-xl flex-shrink-0"><i class="fa-solid fa-location-dot"></i></span>
                    <div>
                        <h4 class="font-display font-bold text-slate-800 text-base">Corporate Office</h4>
                        <p class="text-sm text-slate-500 mt-1">123 Romance Valley, Suite 500,<br>New Delhi, India</p>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="lg:col-span-7 bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
                <h3 class="font-display font-bold text-2xl text-slate-800 mb-6">Send a Message</h3>
                
                <form action="#" method="POST" class="space-y-4" onsubmit="event.preventDefault(); alert('Message sent successfully! We will get back to you shortly.');">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Your Name</label>
                            <input type="text" required class="w-full rounded-2xl border-slate-200 text-slate-700 text-sm focus:ring-rose-500 focus:border-rose-500 py-3">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Email Address</label>
                            <input type="email" required class="w-full rounded-2xl border-slate-200 text-slate-700 text-sm focus:ring-rose-500 focus:border-rose-500 py-3">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Subject</label>
                        <input type="text" required class="w-full rounded-2xl border-slate-200 text-slate-700 text-sm focus:ring-rose-500 focus:border-rose-500 py-3">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Message</label>
                        <textarea rows="5" required class="w-full rounded-2xl border-slate-200 text-slate-700 text-sm focus:ring-rose-500 focus:border-rose-500 py-3"></textarea>
                    </div>

                    <button type="submit" class="w-full py-4 rounded-2xl font-bold bg-gradient-to-r from-rose-500 to-pink-500 text-white shadow-lg shadow-rose-100 hover:shadow-xl hover:shadow-rose-200 hover:-translate-y-0.5 transition-all duration-200 mt-2">
                        Send Message <i class="fa-regular fa-paper-plane ml-2 text-sm"></i>
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
