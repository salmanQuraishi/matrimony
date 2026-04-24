<x-app-layout>
@php
    $readonly = Route::is('user.view') ? 'readonly' : null;
    $disabled = Route::is('user.view') ? 'disabled' : null;

    $formCondition = !Route::is('user.view');
    $page = Route::is('user.view') ? 'View User' : 'Edit User';
@endphp

<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{ $page }}</div>
                    </div>

                    @if($formCondition)
                        <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                    @endif

                    <div class="card-body">

                        {{-- Profile Details --}}
                        <h6 class="fw-bold mb-3">Profile Details</h6>

                        <div class="row">
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label for="profile_image">Profile Image</label>
                                    <input type="file" name="profile_image" id="profile_image" class="form-control" {{ $disabled }}>
                                    @error('profile_image')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Current Image</label><br>

                                    @if(!empty($user->profile))
                                        <img src="{{ asset($user->profile) }}"
                                             alt="Profile Image"
                                             style="width:100px; height:100px; object-fit:cover; border-radius:50%; border:1px solid #ddd; padding:2px;">
                                    @else
                                        <div style="width:100px; height:100px; border-radius:50%; border:1px solid #ddd; display:flex; align-items:center; justify-content:center; color:#999;">
                                            No Image
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-3">
                                <x-form-input
                                    type="text"
                                    id="dummyid"
                                    label="Dummy Id"
                                    name="dummyid"
                                    :value="old('dummyid', $user->dummyid)"
                                    placeholder="Enter Dummy Id"
                                    readonly
                                    disabled
                                />
                            </div>

                            <div class="col-md-3">
                                <x-user-select
                                    label="Profile For"
                                    id="profile_for"
                                    name="profile_for"
                                    :options="$ProfileTypes"
                                    :selected="old('profile_for', $user->profile_for)"
                                    :disabled="$disabled"
                                />
                            </div>

                            <div class="col-md-3">
                                <x-form-input
                                    type="text"
                                    id="name"
                                    label="User Name"
                                    name="name"
                                    :value="old('name', $user->name)"
                                    placeholder="Enter User Name"
                                    :readonly="$readonly"
                                    :disabled="$disabled"
                                />
                            </div>

                            <div class="col-md-3">
                                <x-form-input
                                    type="number"
                                    id="mobile"
                                    label="User Mobile"
                                    name="mobile"
                                    :value="old('mobile', $user->mobile)"
                                    placeholder="Enter User Mobile"
                                    :readonly="$readonly"
                                    :disabled="$disabled"
                                />
                            </div>
                        </div>

                        <hr>

                        {{-- Basic Details --}}
                        <h6 class="fw-bold mb-3">Basic Details</h6>

                        <div class="row">
                            <div class="col-md-3">
                                <x-form-input
                                    type="number"
                                    id="age"
                                    label="User Age"
                                    name="age"
                                    :value="old('age', $user->age)"
                                    placeholder="Enter User Age"
                                    min="0"
                                    :readonly="$readonly"
                                    :disabled="$disabled"
                                />
                            </div>

                            <div class="col-md-3">
                                <x-form-input
                                    type="date"
                                    id="dob"
                                    label="User DOB"
                                    name="dob"
                                    :value="old('dob', $user->dob)"
                                    placeholder="Enter User DOB"
                                    :readonly="$readonly"
                                    :disabled="$disabled"
                                />
                            </div>

                            <div class="col-md-3">
                                <x-form-input
                                    type="email"
                                    id="email"
                                    label="User Email"
                                    name="email"
                                    :value="old('email', $user->email)"
                                    placeholder="Enter User Email"
                                    :readonly="$readonly"
                                    :disabled="$disabled"
                                />
                            </div>

                            <div class="col-md-3">
                                <x-form-radio-group
                                    label="Gender"
                                    name="gender"
                                    :options="['male' => 'Male', 'female' => 'Female', 'other' => 'Other']"
                                    :selected="old('gender', $user->gender)"
                                    :disabled="$disabled"
                                />
                            </div>

                            <div class="col-md-3">
                                <x-form-input
                                    type="text"
                                    id="birthplace"
                                    label="Place of Birth"
                                    name="birthplace"
                                    :value="old('birthplace', $user->birthplace)"
                                    placeholder="Enter Place of Birth"
                                    :readonly="$readonly"
                                    :disabled="$disabled"
                                />
                            </div>

                            <div class="col-md-3">
                                <x-user-select
                                    label="Complexion / Skin Tone"
                                    id="complexion_id"
                                    name="complexion_id"
                                    :options="$Complexions"
                                    :selected="old('complexion_id', $user->complexion_id)"
                                    :disabled="$disabled"
                                />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <x-form-textarea
                                    id="myself"
                                    name="myself"
                                    label="About Myself"
                                    rows="3"
                                    placeholder="Enter About Myself"
                                    :value="old('myself', $user->myself)"
                                    :readonly="$readonly"
                                    :disabled="$disabled"
                                />
                            </div>

                            <div class="col-md-6">
                                <x-form-textarea
                                    id="address"
                                    name="address"
                                    label="Address"
                                    rows="3"
                                    placeholder="Enter Address"
                                    :value="old('address', $user->address)"
                                    :readonly="$readonly"
                                    :disabled="$disabled"
                                />
                            </div>
                        </div>

                        <hr>

                        {{-- Family Details --}}
                        <h6 class="fw-bold mb-3">Family Details</h6>

                        <div class="row">
                            <div class="col-md-3">
                                <x-form-input
                                    type="text"
                                    id="father_name"
                                    label="Father Name"
                                    name="father_name"
                                    :value="old('father_name', $user->father_name)"
                                    placeholder="Enter Father Name"
                                    :readonly="$readonly"
                                    :disabled="$disabled"
                                />
                            </div>

                            <div class="col-md-3">
                                <x-form-input
                                    type="text"
                                    id="mother_name"
                                    label="Mother Name"
                                    name="mother_name"
                                    :value="old('mother_name', $user->mother_name)"
                                    placeholder="Enter Mother Name"
                                    :readonly="$readonly"
                                    :disabled="$disabled"
                                />
                            </div>

                            <div class="col-md-3">
                                <x-form-input
                                    type="number"
                                    id="brothers"
                                    label="Brothers"
                                    name="brothers"
                                    :value="old('brothers', $user->brothers)"
                                    placeholder="Enter Brothers"
                                    min="0"
                                    :readonly="$readonly"
                                    :disabled="$disabled"
                                />
                            </div>

                            <div class="col-md-3">
                                <x-form-input
                                    type="number"
                                    id="sisters"
                                    label="Sisters"
                                    name="sisters"
                                    :value="old('sisters', $user->sisters)"
                                    placeholder="Enter Sisters"
                                    min="0"
                                    :readonly="$readonly"
                                    :disabled="$disabled"
                                />
                            </div>
                        </div>

                        <hr>

                        {{-- Religion Details --}}
                        <h6 class="fw-bold mb-3">Religion Details</h6>

                        <div class="row">
                            <div class="col-md-3">
                                @php
                                    $muslimId = collect($religions)->firstWhere('name', 'Muslim')->id ?? null;
                                @endphp

                                <x-user-select
                                    label="Religion"
                                    id="religionSelect"
                                    name="religion_id"
                                    :options="$religions"
                                    :selected="old('religion_id', $user->religion_id ?? $muslimId)"
                                    :disabled="$disabled"
                                />
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="casteSelect">Caste</label>
                                    <select id="casteSelect" name="caste_id" class="form-select form-control" {{ $disabled }}></select>
                                </div>
                            </div>
                        </div>

                        <hr>

                        {{-- Personal Details --}}
                        <h6 class="fw-bold mb-3">Personal Details</h6>

                        <div class="row">
                            <div class="col-md-3">
                                <x-form-input
                                    type="text"
                                    id="height"
                                    label="User Height"
                                    name="height"
                                    :value="old('height', $user->height)"
                                    placeholder="Enter User Height"
                                    :readonly="$readonly"
                                    :disabled="$disabled"
                                />
                            </div>

                            <div class="col-md-3">
                                <x-form-input
                                    type="text"
                                    id="weight"
                                    label="User Weight"
                                    name="weight"
                                    :value="old('weight', $user->weight)"
                                    placeholder="Enter User Weight"
                                    :readonly="$readonly"
                                    :disabled="$disabled"
                                />
                            </div>

                            <div class="col-md-3">
                                @php
                                    $stateId = collect($States)->firstWhere('name', 'Uttar Pradesh')->id ?? null;
                                @endphp

                                <x-user-select
                                    label="State"
                                    id="StateSelect"
                                    name="state_id"
                                    :options="$States"
                                    :selected="old('state_id', $user->state_id ?? $stateId)"
                                    :disabled="$disabled"
                                />
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="citySelect">City</label>
                                    <select id="citySelect" name="city_id" class="form-select form-control" {{ $disabled }}></select>
                                </div>
                            </div>
                        </div>

                        <hr>

                        {{-- Professional Details --}}
                        <h6 class="fw-bold mb-3">Professional Details</h6>

                        <div class="row">
                            <div class="col-md-3">
                                <x-user-select
                                    label="Education"
                                    id="education_id"
                                    name="education_id"
                                    :options="$Education"
                                    :selected="old('education_id', $user->education_id)"
                                    :disabled="$disabled"
                                />
                            </div>

                            <div class="col-md-3">
                                <x-user-select
                                    label="Job Type"
                                    id="job_type_id"
                                    name="job_type_id"
                                    :options="$JobType"
                                    :selected="old('job_type_id', $user->job_type_id)"
                                    :disabled="$disabled"
                                />
                            </div>

                            <div class="col-md-3">
                                <x-user-select
                                    label="Company Type"
                                    id="company_type_id"
                                    name="company_type_id"
                                    :options="$CompanyType"
                                    :selected="old('company_type_id', $user->company_type_id)"
                                    :disabled="$disabled"
                                />
                            </div>

                            <div class="col-md-3">
                                <x-user-select
                                    label="Occupation"
                                    id="occupation_id"
                                    name="occupation_id"
                                    :options="$Occupation"
                                    :selected="old('occupation_id', $user->occupation_id)"
                                    :disabled="$disabled"
                                />
                            </div>

                            <div class="col-md-3">
                                <x-user-select
                                    label="Annual Income"
                                    id="annual_income_id"
                                    name="annual_income_id"
                                    :options="$AnnualIncome"
                                    :selected="old('annual_income_id', $user->annual_income_id)"
                                    :disabled="$disabled"
                                />
                            </div>
                        </div>

                    </div>

                    @if($formCondition)
                        <div class="card-action">
                            <button class="btn btn-success" type="submit">
                                Update
                            </button>
                        </div>
                    @endif

                    @if($formCondition)
                        </form>
                    @endif

                </div>

            </div>
        </div>
    </div>
</div>
</x-app-layout>

<script>
$(document).ready(function () {

    function loadCities(selectedCity = null) {
        let state = $("#StateSelect").val();

        if (!state) {
            $("#citySelect").html('<option value="">Select City</option>');
            return;
        }

        let url = "{{ route('user.city', ':state') }}".replace(':state', state);

        $.ajax({
            url: url,
            type: 'GET',
            success: function (response) {
                let citySelect = $("#citySelect");
                citySelect.empty();
                citySelect.append('<option value="">Select City</option>');

                $.each(response.cities, function (key, value) {
                    let selected = (value.id == selectedCity) ? 'selected' : '';
                    citySelect.append('<option value="' + value.id + '" ' + selected + '>' + value.name + '</option>');
                });
            },
            error: function (xhr) {
                console.error('Error fetching cities:', xhr);
            }
        });
    }

    function loadCastes(selectedCaste = null) {
        let religion = $("#religionSelect").val();

        if (!religion) {
            $("#casteSelect").html('<option value="">Select Caste</option>');
            return;
        }

        let url = "{{ route('user.caste', ':religion') }}".replace(':religion', religion);

        $.ajax({
            url: url,
            type: 'GET',
            success: function (response) {
                let casteSelect = $("#casteSelect");
                casteSelect.empty();
                casteSelect.append('<option value="">Select Caste</option>');

                $.each(response.castes, function (key, value) {
                    let selected = '';

                    if (selectedCaste) {
                        selected = (value.id == selectedCaste) ? 'selected' : '';
                    } else if (value.name.toLowerCase() === 'sunni') {
                        selected = 'selected';
                    }

                    casteSelect.append('<option value="' + value.id + '" ' + selected + '>' + value.name + '</option>');
                });
            },
            error: function (xhr) {
                console.error('Error fetching castes:', xhr);
            }
        });
    }

    $("#StateSelect").change(function () {
        loadCities(null);
    });

    $("#religionSelect").change(function () {
        loadCastes(null);
    });

    loadCities({{ $user->city_id ?? 'null' }});
    loadCastes({{ $user->caste_id ?? 'null' }});

});
</script>