@extends('layouts.frontend')

@section('title', 'Create Account')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gradient-to-br from-[#FBF6EC] via-[#F0E8D0]/40 to-[#FBF6EC] relative">
    
    <!-- Blobs -->
    <div class="absolute top-1/4 left-1/4 w-72 h-72 bg-[#C9A84C]/10 rounded-full blur-3xl -z-10"></div>
    <div class="absolute bottom-1/4 right-1/4 w-80 h-80 bg-[#0D3B2E]/5 rounded-full blur-3xl -z-10"></div>

    <div class="max-w-md w-full space-y-8 bg-white p-8 sm:p-10 rounded-3xl shadow-xl border border-[#C9A84C]/20 relative">
        
        <!-- Header -->
        <div class="text-center">
            <span class="w-12 h-12 rounded-2xl bg-[#F0E8D0] flex items-center justify-center mx-auto text-[#0D3B2E] mb-4 shadow-inner border border-[#C9A84C]/20">
                <i class="fa-solid fa-user-plus text-xl"></i>
            </span>
            <h2 class="font-display font-extrabold text-3xl text-[#0D3B2E]">Register Free</h2>
            <p class="mt-2 text-sm text-[#4A3728]/70 font-medium">
                Create a profile and connect with verified matches
            </p>
        </div>

        <form class="mt-8 space-y-5" action="{{ route('user.register.post') }}" method="POST">
            @csrf
            
            <!-- Profile For -->
            <div>
                <label for="profile_for" class="block text-xs font-bold text-[#4A3728] uppercase tracking-wider mb-2">Creating Profile For</label>
                <select id="profile_for" name="profile_for" required 
                        class="w-full rounded-2xl border-[#C9A84C]/35 bg-[#FBF6EC]/50 text-[#1A1208] text-sm font-medium focus:ring-[#C9A84C] focus:border-[#C9A84C] py-3.5 @error('profile_for') border-red-400 ring-red-100 focus:ring-red-400 focus:border-red-400 @enderror">
                    <option value="" class="text-slate-500">Select Option</option>
                    @foreach($profileFors as $item)
                        <option value="{{ $item['ptid'] }}" {{ old('profile_for') == $item['ptid'] ? 'selected' : '' }}>{{ $item['name'] }}</option>
                    @endforeach
                </select>
                @error('profile_for')
                    <p class="text-xs text-red-500 mt-1.5 font-semibold flex items-center gap-1"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                @enderror
            </div>

            <!-- Full Name -->
            <div>
                <label for="name" class="block text-xs font-bold text-[#4A3728] uppercase tracking-wider mb-2">Full Name</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-[#4A3728]/60">
                        <i class="fa-regular fa-user text-sm"></i>
                    </span>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required 
                           class="pl-11 w-full rounded-2xl border-[#C9A84C]/35 bg-[#FBF6EC]/50 text-[#1A1208] text-sm focus:ring-[#C9A84C] focus:border-[#C9A84C] py-3.5 transition-all @error('name') border-red-400 ring-red-100 focus:ring-red-400 focus:border-red-400 @enderror" 
                           placeholder="Enter your name">
                </div>
                @error('name')
                    <p class="text-xs text-red-500 mt-1.5 font-semibold flex items-center gap-1"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                @enderror
            </div>

            <!-- Mobile Number -->
            <div>
                <label for="mobile" class="block text-xs font-bold text-[#4A3728] uppercase tracking-wider mb-2">Mobile Number</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-[#4A3728]/60">
                        <i class="fa-solid fa-phone text-sm"></i>
                    </span>
                    <input id="mobile" name="mobile" type="text" value="{{ old('mobile') }}" required 
                           class="pl-11 w-full rounded-2xl border-[#C9A84C]/35 bg-[#FBF6EC]/50 text-[#1A1208] text-sm focus:ring-[#C9A84C] focus:border-[#C9A84C] py-3.5 transition-all @error('mobile') border-red-400 ring-red-100 focus:ring-red-400 focus:border-red-400 @enderror" 
                           placeholder="Enter active mobile number">
                </div>
                @error('mobile')
                    <p class="text-xs text-red-500 mt-1.5 font-semibold flex items-center gap-1"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-xs font-bold text-[#4A3728] uppercase tracking-wider mb-2">Password</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-[#4A3728]/60">
                        <i class="fa-solid fa-key text-sm"></i>
                    </span>
                    <input id="password" name="password" type="password" required 
                           class="pl-11 w-full rounded-2xl border-[#C9A84C]/35 bg-[#FBF6EC]/50 text-[#1A1208] text-sm focus:ring-[#C9A84C] focus:border-[#C9A84C] py-3.5 transition-all @error('password') border-red-400 ring-red-100 focus:ring-red-400 focus:border-red-400 @enderror" 
                           placeholder="Minimum 6 characters">
                </div>
                @error('password')
                    <p class="text-xs text-red-500 mt-1.5 font-semibold flex items-center gap-1"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-xs font-bold text-[#4A3728] uppercase tracking-wider mb-2">Confirm Password</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-[#4A3728]/60">
                        <i class="fa-solid fa-key text-sm"></i>
                    </span>
                    <input id="password_confirmation" name="password_confirmation" type="password" required 
                           class="pl-11 w-full rounded-2xl border-[#C9A84C]/35 bg-[#FBF6EC]/50 text-[#1A1208] text-sm focus:ring-[#C9A84C] focus:border-[#C9A84C] py-3.5 transition-all" 
                           placeholder="Confirm your password">
                </div>
            </div>

            <!-- Agree Terms -->
            <div class="flex items-start text-xs text-[#4A3728] leading-relaxed font-medium mt-1">
                <input type="checkbox" required class="rounded text-[#0D3B2E] focus:ring-[#C9A84C] border-[#C9A84C]/35 bg-[#FBF6EC]/50 mr-2 mt-0.5">
                <span>By registering, you agree to our <a href="{{ route('terms') }}" class="font-bold text-[#8B6914] hover:underline hover:text-[#C9A84C]">Terms & Conditions</a> and <a href="{{ route('privacy') }}" class="font-bold text-[#8B6914] hover:underline hover:text-[#C9A84C]">Privacy Policy</a>.</span>
            </div>

            <!-- Submit -->
            <button type="submit" class="w-full py-4 rounded-2xl font-bold bg-gradient-to-r from-[#C9A84C] to-[#8B6914] text-[#0D3B2E] shadow-lg shadow-[#C9A84C]/20 hover:shadow-xl hover:shadow-[#C9A84C]/35 hover:-translate-y-0.5 transition-all duration-200 mt-2">
                Register Now <i class="fa-solid fa-user-plus ml-2 text-sm"></i>
            </button>
        </form>

        <!-- Login Link -->
        <div class="text-center text-sm text-[#4A3728] mt-8 font-medium">
            Already have an account? 
            <a href="{{ route('user.login') }}" class="font-bold text-[#8B6914] hover:text-[#C9A84C] transition-colors">Sign In</a>
        </div>
    </div>
</div>
@endsection
