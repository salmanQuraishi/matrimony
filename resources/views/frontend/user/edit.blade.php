@extends('layouts.frontend')

@section('title', 'Edit Profile')

@section('content')
<div class="py-12 bg-slate-50 min-h-screen" x-data="{ activeTab: 'basic' }">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-slate-200 pb-5">
            <div>
                <h1 class="font-display font-extrabold text-3xl text-slate-800">Edit Profile</h1>
                <p class="text-sm text-slate-500 mt-1">Keep your profile updated to receive better and more accurate matches.</p>
            </div>
            
            <a href="{{ route('user.profile') }}" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-bold text-xs bg-white hover:bg-slate-50 transition-all flex items-center gap-1.5 shadow-sm">
                <i class="fa-solid fa-arrow-left"></i> View Profile
            </a>
        </div>

        @if($errors->any())
            <div class="bg-rose-50 border border-rose-100 rounded-2xl p-4 space-y-2 text-rose-600 text-sm">
                <div class="flex gap-2 font-bold"><i class="fa-solid fa-circle-exclamation mt-0.5"></i> Correct validation issues:</div>
                <ul class="list-disc list-inside pl-4 text-xs space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Tab Links -->
        <div class="flex flex-wrap border-b border-slate-200 gap-1 bg-white p-1.5 rounded-2xl shadow-sm border border-slate-100">
            <button @click="activeTab = 'basic'" :class="activeTab === 'basic' ? 'bg-rose-50 text-rose-600' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-550 hover:bg-slate-50'" class="flex-1 min-w-[120px] px-4 py-2.5 rounded-xl text-xs font-bold transition-all">Basic</button>
            <button @click="activeTab = 'religion'" :class="activeTab === 'religion' ? 'bg-rose-50 text-rose-600' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-550 hover:bg-slate-50'" class="flex-1 min-w-[120px] px-4 py-2.5 rounded-xl text-xs font-bold transition-all">Religion</button>
            <button @click="activeTab = 'personal'" :class="activeTab === 'personal' ? 'bg-rose-50 text-rose-600' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-550 hover:bg-slate-50'" class="flex-1 min-w-[120px] px-4 py-2.5 rounded-xl text-xs font-bold transition-all">Personal</button>
            <button @click="activeTab = 'professional'" :class="activeTab === 'professional' ? 'bg-rose-50 text-rose-600' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-550 hover:bg-slate-50'" class="flex-1 min-w-[120px] px-4 py-2.5 rounded-xl text-xs font-bold transition-all">Career</button>
            <button @click="activeTab = 'about'" :class="activeTab === 'about' ? 'bg-rose-50 text-rose-600' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-550 hover:bg-slate-50'" class="flex-1 min-w-[120px] px-4 py-2.5 rounded-xl text-xs font-bold transition-all">Photo & Bio</button>
            <button @click="activeTab = 'gallery'" :class="activeTab === 'gallery' ? 'bg-rose-50 text-rose-600' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-550 hover:bg-slate-50'" class="flex-1 min-w-[120px] px-4 py-2.5 rounded-xl text-xs font-bold transition-all">Gallery</button>
        </div>

        <!-- Tab Contents -->
        <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
            
            <!-- Basic Tab -->
            <div x-show="activeTab === 'basic'" class="space-y-6">
                <h3 class="font-display font-bold text-lg text-slate-800 border-b border-slate-50 pb-3">Basic Details</h3>
                
                <form action="{{ route('user.profile.update-basic') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    @csrf
                    <!-- DOB -->
                    <div>
                        <label for="dob" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Date of Birth</label>
                        <input type="date" id="dob" name="dob" value="{{ old('dob', $authUser['dob']) }}" required
                               class="w-full rounded-2xl border-slate-200 text-slate-700 text-sm focus:ring-rose-500 focus:border-rose-500 py-3.5">
                    </div>
                    <!-- Age -->
                    <div>
                        <label for="age" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Age (Years)</label>
                        <input type="number" id="age" name="age" value="{{ old('age', $authUser['age']) }}" min="18" required
                               class="w-full rounded-2xl border-slate-200 text-slate-700 text-sm focus:ring-rose-500 focus:border-rose-500 py-3.5">
                    </div>
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Email Address</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $authUser['email']) }}" required
                               class="w-full rounded-2xl border-slate-200 text-slate-700 text-sm focus:ring-rose-500 focus:border-rose-500 py-3.5">
                    </div>
                    <!-- Gender -->
                    <div>
                        <label for="gender" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Gender</label>
                        <select id="gender" name="gender" required
                                class="w-full rounded-2xl border-slate-200 text-slate-700 text-sm focus:ring-rose-500 focus:border-rose-500 py-3.5">
                            <option value="male" {{ old('gender', $authUser['gender']) == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender', $authUser['gender']) == 'female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>
                    <!-- Birthplace -->
                    <div>
                        <label for="birthplace" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Birthplace (City/Town)</label>
                        <input type="text" id="birthplace" name="birthplace" value="{{ old('birthplace', $authUser['birthplace']) }}" required
                               class="w-full rounded-2xl border-slate-200 text-slate-700 text-sm focus:ring-rose-500 focus:border-rose-500 py-3.5">
                    </div>
                    <!-- Complexion -->
                    <div>
                        <label for="complexion" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Complexion</label>
                        <select id="complexion" name="complexion" required
                                class="w-full rounded-2xl border-slate-200 text-slate-700 text-sm focus:ring-rose-500 focus:border-rose-500 py-3.5">
                            <option value="">Select Complexion</option>
                            @foreach($complexions as $item)
                                <option value="{{ $item['id'] }}" {{ old('complexion', $authUser['complexion']['id'] ?? '') == $item['id'] ? 'selected' : '' }}>{{ $item['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Address -->
                    <div class="col-span-1 sm:col-span-2">
                        <label for="address" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Residential Address</label>
                        <textarea id="address" name="address" rows="2" class="w-full rounded-2xl border-slate-200 text-slate-700 text-sm focus:ring-rose-500 focus:border-rose-500 py-3">{{ old('address', $authUser['address']) }}</textarea>
                    </div>

                    <div class="col-span-1 sm:col-span-2 border-t border-slate-50 pt-4">
                        <h4 class="font-display font-semibold text-sm text-slate-600 mb-4">Family Details</h4>
                    </div>

                    <!-- Father Name -->
                    <div>
                        <label for="father_name" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Father's Name</label>
                        <input type="text" id="father_name" name="father_name" value="{{ old('father_name', $authUser['father_name']) }}" required
                               class="w-full rounded-2xl border-slate-200 text-slate-700 text-sm focus:ring-rose-500 focus:border-rose-500 py-3.5">
                    </div>
                    <!-- Mother Name -->
                    <div>
                        <label for="mother_name" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Mother's Name</label>
                        <input type="text" id="mother_name" name="mother_name" value="{{ old('mother_name', $authUser['mother_name']) }}" required
                               class="w-full rounded-2xl border-slate-200 text-slate-700 text-sm focus:ring-rose-500 focus:border-rose-500 py-3.5">
                    </div>
                    <!-- Brothers -->
                    <div>
                        <label for="brothers" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Brothers</label>
                        <input type="number" id="brothers" name="brothers" value="{{ old('brothers', $authUser['brothers']) }}" min="0"
                               class="w-full rounded-2xl border-slate-200 text-slate-700 text-sm focus:ring-rose-500 focus:border-rose-500 py-3.5">
                    </div>
                    <!-- Sisters -->
                    <div>
                        <label for="sisters" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Sisters</label>
                        <input type="number" id="sisters" name="sisters" value="{{ old('sisters', $authUser['sisters']) }}" min="0"
                               class="w-full rounded-2xl border-slate-200 text-slate-700 text-sm focus:ring-rose-500 focus:border-rose-500 py-3.5">
                    </div>

                    <div class="col-span-1 sm:col-span-2 pt-4 flex justify-end">
                        <button type="submit" class="px-6 py-3.5 rounded-xl font-bold bg-rose-500 text-white text-xs shadow-md shadow-rose-100 hover:shadow-lg transition-all">Save Basic Details</button>
                    </div>
                </form>
            </div>

            <!-- Religion Tab -->
            <div x-show="activeTab === 'religion'" class="space-y-6">
                <h3 class="font-display font-bold text-lg text-slate-800 border-b border-slate-50 pb-3">Religion & Caste</h3>
                
                <form action="{{ route('user.profile.update-religion') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- Religion -->
                        <div>
                            <label for="religion" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Religion</label>
                            <select id="religion" name="religion" required onchange="loadCastes(this.value)"
                                    class="w-full rounded-2xl border-slate-200 text-slate-700 text-sm focus:ring-rose-500 focus:border-rose-500 py-3.5">
                                <option value="">Select Religion</option>
                                @foreach($religions as $item)
                                    <option value="{{ $item['rid'] }}" {{ old('religion', $authUser['relegion']['rid'] ?? '') == $item['rid'] ? 'selected' : '' }}>{{ $item['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Caste -->
                        <div>
                            <label for="caste" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Caste</label>
                            <select id="caste" name="caste" required
                                    class="w-full rounded-2xl border-slate-200 text-slate-700 text-sm focus:ring-rose-500 focus:border-rose-500 py-3.5">
                                <option value="">Select Caste</option>
                                @foreach($castes as $item)
                                    <option value="{{ $item['cid'] }}" {{ old('caste', $authUser['caste']['cid'] ?? '') == $item['cid'] ? 'selected' : '' }}>{{ $item['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4">
                        <button type="submit" class="px-6 py-3.5 rounded-xl font-bold bg-rose-500 text-white text-xs shadow-md shadow-rose-100 hover:shadow-lg transition-all">Save Religion Details</button>
                    </div>
                </form>
            </div>

            <!-- Personal Tab -->
            <div x-show="activeTab === 'personal'" class="space-y-6">
                <h3 class="font-display font-bold text-lg text-slate-800 border-b border-slate-50 pb-3">Physical & Location details</h3>
                
                <form action="{{ route('user.profile.update-personal') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- Height -->
                        <div>
                            <label for="height" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Height (Feet)</label>
                            <input type="number" step="0.01" id="height" name="height" value="{{ old('height', $authUser['height']) }}" required
                                   class="w-full rounded-2xl border-slate-200 text-slate-700 text-sm focus:ring-rose-500 focus:border-rose-500 py-3.5" placeholder="e.g. 5.6">
                        </div>
                        <!-- Weight -->
                        <div>
                            <label for="weight" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Weight (Kg)</label>
                            <input type="number" id="weight" name="weight" value="{{ old('weight', $authUser['weight']) }}" required
                                   class="w-full rounded-2xl border-slate-200 text-slate-700 text-sm focus:ring-rose-500 focus:border-rose-500 py-3.5" placeholder="e.g. 65">
                        </div>

                        <!-- State -->
                        <div>
                            <label for="state" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">State</label>
                            <select id="state" name="state" required onchange="loadCities(this.value)"
                                    class="w-full rounded-2xl border-slate-200 text-slate-700 text-sm focus:ring-rose-500 focus:border-rose-500 py-3.5">
                                <option value="">Select State</option>
                                @foreach($states as $item)
                                    <option value="{{ $item['sid'] }}" {{ old('state', $authUser['state']['sid'] ?? '') == $item['sid'] ? 'selected' : '' }}>{{ $item['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- City -->
                        <div>
                            <label for="city" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">City</label>
                            <select id="city" name="city" required
                                    class="w-full rounded-2xl border-slate-200 text-slate-700 text-sm focus:ring-rose-500 focus:border-rose-500 py-3.5">
                                <option value="">Select City</option>
                                @foreach($cities as $item)
                                    <option value="{{ $item['cityid'] }}" {{ old('city', $authUser['city']['cityid'] ?? '') == $item['cityid'] ? 'selected' : '' }}>{{ $item['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4">
                        <button type="submit" class="px-6 py-3.5 rounded-xl font-bold bg-rose-500 text-white text-xs shadow-md shadow-rose-100 hover:shadow-lg transition-all">Save Personal Details</button>
                    </div>
                </form>
            </div>

            <!-- Professional Tab -->
            <div x-show="activeTab === 'professional'" class="space-y-6">
                <h3 class="font-display font-bold text-lg text-slate-800 border-b border-slate-50 pb-3">Professional & Career</h3>
                
                <form action="{{ route('user.profile.update-professional') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    @csrf
                    <!-- Education -->
                    <div>
                        <label for="education" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Highest Education Level</label>
                        <select id="education" name="education" required
                                class="w-full rounded-2xl border-slate-200 text-slate-700 text-sm focus:ring-rose-500 focus:border-rose-500 py-3.5">
                            <option value="">Select Education</option>
                            @foreach($educations as $item)
                                <option value="{{ $item['eid'] }}" {{ old('education', $authUser['education']['eid'] ?? '') == $item['eid'] ? 'selected' : '' }}>{{ $item['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Job Type -->
                    <div>
                        <label for="jobtype" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Employment Type</label>
                        <select id="jobtype" name="jobtype" required
                                class="w-full rounded-2xl border-slate-200 text-slate-700 text-sm focus:ring-rose-500 focus:border-rose-500 py-3.5">
                            <option value="">Select Option</option>
                            @foreach($jobTypes as $item)
                                <option value="{{ $item['jtid'] }}" {{ old('jobtype', $authUser['jobType']['jtid'] ?? '') == $item['jtid'] ? 'selected' : '' }}>{{ $item['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Company Type -->
                    <div>
                        <label for="companytype" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Company Sector</label>
                        <select id="companytype" name="companytype" required
                                class="w-full rounded-2xl border-slate-200 text-slate-700 text-sm focus:ring-rose-500 focus:border-rose-500 py-3.5">
                            <option value="">Select Option</option>
                            @foreach($companyTypes as $item)
                                <option value="{{ $item['ctid'] }}" {{ old('companytype', $authUser['companyType']['ctid'] ?? '') == $item['ctid'] ? 'selected' : '' }}>{{ $item['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Occupation -->
                    <div>
                        <label for="occupation" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Occupation / Job Role</label>
                        <select id="occupation" name="occupation" required
                                class="w-full rounded-2xl border-slate-200 text-slate-700 text-sm focus:ring-rose-500 focus:border-rose-500 py-3.5">
                            <option value="">Select Occupation</option>
                            @foreach($occupations as $item)
                                <option value="{{ $item['oid'] }}" {{ old('occupation', $authUser['occupation']['oid'] ?? '') == $item['oid'] ? 'selected' : '' }}>{{ $item['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Income -->
                    <div class="col-span-1 sm:col-span-2">
                        <label for="annualincome" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Annual Income Range</label>
                        <select id="annualincome" name="annualincome" required
                                class="w-full rounded-2xl border-slate-200 text-slate-700 text-sm focus:ring-rose-500 focus:border-rose-500 py-3.5">
                            <option value="">Select Range</option>
                            @foreach($annualIncomes as $item)
                                <option value="{{ $item['aid'] }}" {{ old('annualincome', $authUser['annualIncome']['aid'] ?? '') == $item['aid'] ? 'selected' : '' }}>{{ $item['range'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-span-1 sm:col-span-2 pt-4 flex justify-end">
                        <button type="submit" class="px-6 py-3.5 rounded-xl font-bold bg-rose-500 text-white text-xs shadow-md shadow-rose-100 hover:shadow-lg transition-all">Save Professional Details</button>
                    </div>
                </form>
            </div>

            <!-- Bio & Photo Tab -->
            <div x-show="activeTab === 'about'" class="space-y-6">
                <h3 class="font-display font-bold text-lg text-slate-800 border-b border-slate-50 pb-3">About Myself & Profile Photo</h3>
                
                <form action="{{ route('user.profile.update-about') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <!-- Myself bio -->
                    <div>
                        <label for="myself" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">About Myself (Bio)</label>
                        <textarea id="myself" name="myself" rows="4" required minlength="20" maxlength="100"
                                  class="w-full rounded-2xl border-slate-200 text-slate-700 text-sm focus:ring-rose-500 focus:border-rose-500 py-3" 
                                  placeholder="Write a brief profile description (20 to 100 characters)...">{{ old('myself', $authUser['myself']) }}</textarea>
                        <p class="text-xxs text-slate-400 mt-1 font-medium">Character limit: min 20, max 100.</p>
                    </div>

                    <!-- Profile Photo file -->
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Profile Photo</label>
                        <div class="flex items-center gap-6 p-4 border border-dashed border-slate-200 rounded-2xl bg-slate-50/50">
                            <!-- Image Preview -->
                            <div class="w-20 h-20 rounded-xl bg-slate-100 overflow-hidden shadow-inner flex-shrink-0 relative border border-slate-200">
                                <img id="profile_preview" src="{{ !empty($authUser['profile']) ? asset($authUser['profile']) : asset('profile/default-avatar.png') }}" 
                                     alt="Preview" class="w-full h-full object-cover">
                            </div>
                            
                            <!-- File input -->
                            <div class="flex-grow">
                                <input type="file" name="images" id="profile_photo_input" accept="image/*" onchange="previewProfilePhoto(this)"
                                       class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-rose-50 file:text-rose-600 hover:file:bg-rose-100 cursor-pointer">
                                <p class="text-xxs text-slate-400 mt-1.5 font-medium">Supports JPG, PNG, WEBP (Max 2MB)</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4">
                        <button type="submit" class="px-6 py-3.5 rounded-xl font-bold bg-rose-500 text-white text-xs shadow-md shadow-rose-100 hover:shadow-lg transition-all">Save Bio & Profile Photo</button>
                    </div>
                </form>
            </div>

            <!-- Gallery Tab -->
            <div x-show="activeTab === 'gallery'" class="space-y-6">
                <h3 class="font-display font-bold text-lg text-slate-800 border-b border-slate-50 pb-3">Upload Gallery Photos</h3>
                
                <form action="{{ route('user.profile.update-gallery') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Select Images</label>
                        <div class="p-8 border-2 border-dashed border-slate-200 hover:border-rose-300 rounded-3xl bg-slate-50/50 hover:bg-rose-50/10 transition-all text-center space-y-4">
                            <span class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-500 flex items-center justify-center mx-auto text-lg"><i class="fa-solid fa-cloud-arrow-up"></i></span>
                            <div class="space-y-1">
                                <p class="text-sm font-bold text-slate-700">Choose images to upload</p>
                                <p class="text-xs text-slate-400">Select multiple files (JPG, PNG, WEBP)</p>
                            </div>
                            <input type="file" name="images[]" multiple accept="image/*"
                                   class="block w-full text-xs text-slate-500 file:mx-auto file:mb-2 file:py-2.5 file:px-5 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-rose-50 file:text-rose-600 hover:file:bg-rose-100 cursor-pointer">
                        </div>
                    </div>

                    <div class="flex justify-end pt-4">
                        <button type="submit" class="px-6 py-3.5 rounded-xl font-bold bg-rose-500 text-white text-xs shadow-md shadow-rose-100 hover:shadow-lg transition-all">Upload Gallery Images</button>
                    </div>
                </form>

                <!-- Current Gallery -->
                <div class="border-t border-slate-100 pt-6 space-y-4">
                    <h4 class="font-display font-bold text-slate-700 text-sm">Uploaded Photos</h4>
                    @if(empty($authUser['galleries']))
                        <p class="text-xs text-slate-400 italic">No images in your gallery.</p>
                    @else
                        <div class="grid grid-cols-3 sm:grid-cols-4 gap-4">
                            @foreach($authUser['galleries'] as $photo)
                                <div class="relative rounded-2xl overflow-hidden bg-rose-50 aspect-square group shadow-sm border border-slate-100">
                                    <img src="{{ asset($photo['image_path']) }}" alt="Gallery" class="w-full h-full object-cover">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

        </div>

    </div>
</div>

<script>
    // AJAX to load castes
    function loadCastes(religionId) {
        const casteSelect = document.getElementById('caste');
        casteSelect.innerHTML = '<option value="">Loading castes...</option>';

        if (!religionId) {
            casteSelect.innerHTML = '<option value="">Select Caste</option>';
            return;
        }

        fetch(`/ajax/castes/${religionId}`)
            .then(res => res.json())
            .then(data => {
                casteSelect.innerHTML = '<option value="">Select Caste</option>';
                if (data.status && data.data) {
                    data.data.forEach(caste => {
                        casteSelect.innerHTML += `<option value="${caste.cid}">${caste.name}</option>`;
                    });
                } else {
                    casteSelect.innerHTML = '<option value="">No castes found</option>';
                }
            })
            .catch(() => {
                casteSelect.innerHTML = '<option value="">Error loading castes</option>';
            });
    }

    // AJAX to load cities
    function loadCities(stateId) {
        const citySelect = document.getElementById('city');
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

    // Preview photo
    function previewProfilePhoto(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profile_preview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
