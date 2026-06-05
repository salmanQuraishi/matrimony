@extends('layouts.frontend')

@section('title', 'Sign In')

@section('content')
<div class="min-h-[75vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gradient-to-br from-[#FBF6EC] via-[#F0E8D0]/40 to-[#FBF6EC] relative">
    
    <!-- Blobs -->
    <div class="absolute top-1/4 left-1/4 w-72 h-72 bg-[#C9A84C]/10 rounded-full blur-3xl -z-10"></div>
    <div class="absolute bottom-1/4 right-1/4 w-80 h-80 bg-[#0D3B2E]/5 rounded-full blur-3xl -z-10"></div>

    <div class="max-w-md w-full space-y-8 bg-white p-8 sm:p-10 rounded-3xl shadow-xl border border-[#C9A84C]/20 relative">
        
        <!-- Header -->
        <div class="text-center">
            <span class="w-12 h-12 rounded-2xl bg-[#F0E8D0] flex items-center justify-center mx-auto text-[#0D3B2E] mb-4 shadow-inner border border-[#C9A84C]/20">
                <i class="fa-solid fa-lock-open text-xl"></i>
            </span>
            <h2 class="font-display font-extrabold text-3xl text-[#0D3B2E]">Welcome Back</h2>
            <p class="mt-2 text-sm text-[#4A3728]/70 font-medium">
                Find your companion. Connect today.
            </p>
        </div>

        @if($errors->has('form'))
            <div class="bg-red-50 border border-red-100 rounded-2xl p-4 flex gap-3 text-red-600 text-sm">
                <i class="fa-solid fa-circle-exclamation mt-0.5 text-base flex-shrink-0"></i>
                <span>{{ $errors->first('form') }}</span>
            </div>
        @endif

        <form class="mt-8 space-y-6" action="{{ route('user.login.post') }}" method="POST">
            @csrf
            
            <div class="space-y-5">
                <!-- Mobile Number -->
                <div>
                    <label for="mobile" class="block text-xs font-bold text-[#4A3728] uppercase tracking-wider mb-2">Mobile Number</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-[#4A3728]/60">
                            <i class="fa-solid fa-phone text-sm"></i>
                        </span>
                        <input id="mobile" name="mobile" type="text" value="{{ old('mobile') }}" required 
                               class="pl-11 w-full rounded-2xl border-[#C9A84C]/35 bg-[#FBF6EC]/50 text-[#1A1208] text-sm focus:ring-[#C9A84C] focus:border-[#C9A84C] py-3.5 transition-all @error('mobile') border-red-400 ring-red-100 focus:ring-red-400 focus:border-red-400 @enderror" 
                               placeholder="Enter registered mobile">
                    </div>
                    @error('mobile')
                        <p class="text-xs text-red-500 mt-1.5 font-semibold flex items-center gap-1"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-xs font-bold text-[#4A3728] uppercase tracking-wider mb-2">Password</label>
                    <div class="relative" x-data="{ show: false }">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-[#4A3728]/60">
                            <i class="fa-solid fa-key text-sm"></i>
                        </span>
                        <input id="password" name="password" :type="show ? 'text' : 'password'" required 
                               class="pl-11 pr-10 w-full rounded-2xl border-[#C9A84C]/35 bg-[#FBF6EC]/50 text-[#1A1208] text-sm focus:ring-[#C9A84C] focus:border-[#C9A84C] py-3.5 transition-all @error('password') border-red-400 ring-red-100 focus:ring-red-400 focus:border-red-400 @enderror" 
                               placeholder="••••••••">
                        <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 transition-colors">
                            <i class="fa-solid" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-xs text-red-500 mt-1.5 font-semibold flex items-center gap-1"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Remember me & Forgot Password -->
            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center gap-2 text-[#4A3728] font-medium cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded text-[#0D3B2E] focus:ring-[#C9A84C] border-[#C9A84C]/35 bg-[#FBF6EC]/50">
                    Remember me
                </label>
                <a href="#" class="font-bold text-[#8B6914] hover:text-[#C9A84C] transition-colors">Forgot Password?</a>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full py-4 rounded-2xl font-bold bg-gradient-to-r from-[#C9A84C] to-[#8B6914] text-[#0D3B2E] shadow-lg shadow-[#C9A84C]/20 hover:shadow-xl hover:shadow-[#C9A84C]/35 hover:-translate-y-0.5 transition-all duration-200">
                Sign In <i class="fa-solid fa-arrow-right-to-bracket ml-2 text-sm"></i>
            </button>
        </form>

        <!-- Register Link -->
        <div class="text-center text-sm text-[#4A3728] mt-8 font-medium">
            Don't have an account? 
            <a href="{{ route('user.register') }}" class="font-bold text-[#8B6914] hover:text-[#C9A84C] transition-colors">Register Free</a>
        </div>
    </div>
</div>
@endsection
