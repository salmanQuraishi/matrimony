@extends('layouts.frontend')

@section('title', 'Account Settings')

@section('content')
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <div>
            <h1 class="font-display font-extrabold text-3xl text-slate-800">Account Settings</h1>
            <p class="text-sm text-slate-500 mt-1">Manage your account security credentials and preferences.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start">
            
            <!-- Left Pane: Menu list (4 cols) -->
            <div class="md:col-span-4 bg-white rounded-3xl p-3 border border-slate-100 shadow-sm space-y-1">
                <button class="w-full text-left p-3.5 rounded-2xl text-xs font-bold bg-rose-50 text-rose-600 transition-all flex items-center gap-2.5">
                    <i class="fa-solid fa-shield-halved text-sm"></i> Security & Password
                </button>
            </div>

            <!-- Right Pane: Settings detail (8 cols) -->
            <div class="md:col-span-8 bg-white rounded-3xl p-8 border border-slate-100 shadow-sm space-y-6">
                <h3 class="font-display font-bold text-lg text-slate-800 border-b border-slate-50 pb-3">Update Password</h3>
                
                <form action="{{ route('user.change-password') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <!-- Current Password -->
                    <div>
                        <label for="current_password" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Current Password</label>
                        <input type="password" id="current_password" name="current_password" required
                               class="w-full rounded-2xl border-slate-200 text-slate-700 text-sm focus:ring-rose-500 focus:border-rose-500 py-3.5 @error('current_password') border-rose-400 ring-rose-100 @enderror">
                        @error('current_password')
                            <p class="text-xs text-rose-500 mt-1.5 font-semibold flex items-center gap-1"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <!-- New Password -->
                    <div>
                        <label for="new_password" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">New Password</label>
                        <input type="password" id="new_password" name="new_password" required
                               class="w-full rounded-2xl border-slate-200 text-slate-700 text-sm focus:ring-rose-500 focus:border-rose-500 py-3.5 @error('new_password') border-rose-400 ring-rose-100 @enderror">
                        @error('new_password')
                            <p class="text-xs text-rose-500 mt-1.5 font-semibold flex items-center gap-1"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="new_password_confirmation" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Confirm New Password</label>
                        <input type="password" id="new_password_confirmation" name="new_password_confirmation" required
                               class="w-full rounded-2xl border-slate-200 text-slate-700 text-sm focus:ring-rose-500 focus:border-rose-500 py-3.5">
                    </div>

                    <div class="pt-4 flex justify-end">
                        <button type="submit" class="px-6 py-3.5 rounded-xl font-bold bg-rose-500 text-white text-xs shadow-md shadow-rose-100 hover:shadow-lg transition-all">Update Password</button>
                    </div>
                </form>
            </div>

        </div>

    </div>
</div>
@endsection
