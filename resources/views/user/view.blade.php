<x-app-layout>
  
@php
  $readonly = Route::is('user.view') ? 'readonly' : null;
  $disabled = Route::is('user.view') ? 'disabled' : null;

  $formCondition = Route::is('user.view') ? false : true;
  $page = Route::is('user.view') ? "View User" : "Edit User";
@endphp

  <div class="container">
    <div class="page-inner">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <div class="card-title">{{$page}}</div>
            </div>

            @if($formCondition === true)
            
            <form action="{{ route('user.update', $user->id) }}" method="post">
              @csrf
              @method('PUT')
            
              @endif

              <div class="card-body">
                <h6><b>Profile Details</b></h6>
                <div class="row">
                  <div class="col-md-3">
                    <x-form-input
                      type="text"
                      id="nameInput"
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
                      id="profileforSelect" 
                      name="profile_for" 
                      :options="$ProfileTypes"
                      :selected="old('profile_for',$user->profile_for)"
                      :disabled="$disabled"
                    />
                  </div>
                  <div class="col-md-3">
                    <x-form-input
                      type="text"
                      id="nameInput"
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
                      id="nameInput"
                      label="User Mobile"
                      name="mobile"
                      :value="old('mobile', $user->mobile)"
                      placeholder="Enter User Mobile"
                      :readonly="$readonly"
                      :disabled="$disabled"
                    />
                  </div>
                  <div class="col-md-12">
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
                </div>
                <h6><b>Basic Details</b></h6>
                <div class="row">
                  <div class="col-md-3">
                    <x-form-input
                      type="text"
                      id="nameInput"
                      label="User Age"
                      name="age"
                      :value="old('age', $user->age)"
                      placeholder="Enter User Age"
                      :readonly="$readonly"
                      :disabled="$disabled"
                    />
                  </div>
                  <div class="col-md-3">
                    <x-form-input
                    type="date"
                    id="nameInput"
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
                      type="text"
                      id="nameInput"
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
                </div>
                <h6><b>Religion Details</b></h6>
                <div class="row">
                  <div class="col-md-3">
                    <x-user-select 
                      label="Religion" 
                      id="religionSelect" 
                      name="religion_id" 
                      :options="$religions"
                      :selected="old('religion_id',$user->religion_id)" 
                      :disabled="$disabled"
                    />
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="casteSelect">Caste</label>
                      <select id="casteSelect" name="caste_id" class="form-select form-control" {{$disabled}}>
                      </select>
                    </div>
                  </div>
                </div>
                <h6><b>Personal Details</b></h6>
                <div class="row">
                  <div class="col-md-3">
                    <x-form-input
                      type="text"
                      id="nameInput"
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
                      id="nameInput"
                      label="User Weight"
                      name="weight"
                      :value="old('weight', $user->weight)"
                      placeholder="Enter User Weight"
                      :readonly="$readonly"
                      :disabled="$disabled"
                    />
                  </div>
                  <div class="col-md-3">
                    <x-user-select 
                      label="States" 
                      id="StateSelect" 
                      name="state_id" 
                      :options="$States"
                      :selected="old('state_id',$user->state_id)"
                      :disabled="$disabled"
                    />
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="citySelect">City</label>
                      <select id="citySelect" name="city_id" class="form-select form-control" {{$disabled}}>
                      </select>
                    </div>
                  </div>
                </div>
                <h6><b>Perfessional Details</b></h6>
                <div class="row">
                  <div class="col-md-3">
                    <x-user-select 
                      label="Education" 
                      id="EducationeSelect" 
                      name="education_id" 
                      :options="$Education"
                      :selected="old('education_id',$user->education_id)" 
                      :disabled="$disabled"
                    />
                  </div>
                  <div class="col-md-3">
                    <x-user-select 
                      label="Job Type" 
                      id="JobTypeSelect" 
                      name="job_type_id" 
                      :options="$JobType"
                      :selected="old('job_type_id',$user->job_type_id)" 
                      :disabled="$disabled"
                    />
                  </div>
                  <div class="col-md-3">
                    <x-user-select 
                      label="Company Type" 
                      id="CompanyTypeSelect" 
                      name="company_type_id" 
                      :options="$CompanyType"
                      :selected="old('company_type_id',$user->company_type_id)" 
                      :disabled="$disabled"
                    />
                  </div>
                  <div class="col-md-3">
                    <x-user-select 
                      label="Occupation" 
                      id="OccupationSelect" 
                      name="occupation_id" 
                      :options="$Occupation"
                      :selected="old('occupation_id',$user->occupation_id)" 
                      :disabled="$disabled"
                    />
                  </div>
                  <div class="col-md-3">
                    <x-user-select 
                      label="Annual Income" 
                      id="AnnualIncomeSelect" 
                      name="annual_income_id" 
                      :options="$AnnualIncome"
                      :selected="old('annual_income_id',$user->annual_income_id)" 
                      :disabled="$disabled"
                    />
                  </div>
                </div>
              </div>
              @if($formCondition === true)
              <div class="card-action">
                <button class="btn btn-success" type="submit">Update</button>
              </div>
              @endif
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
<script>
  $(document).ready(function() {

    $("#StateSelect").change(function() {
      let state = $(this).val();
      let url = "{{ route('user.city', ':state') }}".replace(':state', state);

      if (state) {
        $.ajax({
          url: url,
          type: 'GET',
          success: function(response) {
            let citySelect = $("#citySelect");
            citySelect.empty();
            citySelect.append('<option value="">Select City</option>');

            $.each(response.cities, function(key, value) {
              citySelect.append('<option value="' + value.id + '">' + value.name + '</option>');
            });
          },
          error: function(xhr) {
            console.error('Error fetching cities:', xhr);
          }
        });
      }
    });

    function loadCity() {
      let state = $("#StateSelect").val();
      let city = {{ $user->city_id ?? 'null' }};
      let url = "{{ route('user.city', ':state') }}".replace(':state', state);

      if (state) {
        $.ajax({
          url: url,
          type: 'GET',
          success: function(response) {
            let citySelect = $("#citySelect");
            citySelect.empty();
            citySelect.append('<option value="">Select City</option>');

            $.each(response.cities, function(key, value) {
              let selected = (value.id == city) ? 'selected' : '';
              citySelect.append('<option value="' + value.id + '" ' + selected + '>' + value.name + '</option>');
            });
          },
          error: function(xhr) {
            console.error('Error fetching cities:', xhr);
          }
        });
      }
    }
    loadCity();

    $("#religionSelect").change(function() {
      let religion = $(this).val();

      let url = "{{ route('user.caste', ':religion') }}".replace(':religion', religion);

      if (religion) {
        $.ajax({
          url: url,
          type: 'GET',
          success: function(response) {
            let casteSelect = $("#casteSelect");
            casteSelect.empty();

            $.each(response.castes, function(key, value) {
              casteSelect.append('<option value="' + value.id + '">' + value.name + '</option>');
            });
          },
          error: function(xhr) {
            console.error('Error fetching castes:', xhr);
          }
        });
      }
    });

    function loadCaste() {
      let religion = $("#religionSelect").val();
      let caste = {{$user->caste_id}};
      let url = "{{ route('user.caste', ':religion') }}".replace(':religion', religion);

      if (religion) {
        $.ajax({
          url: url,
          type: 'GET',
          success: function(response) {
            let casteSelect = $("#casteSelect");
            casteSelect.empty();

            $.each(response.castes, function(key, value) {
              let selected = (value.id == caste) ? 'selected' : '';
              casteSelect.append('<option value="' + value.id + '" ' + selected + '>' + value.name + '</option>');
            });
          },
          error: function(xhr) {
            console.error('Error fetching castes:', xhr);
          }
        });
      }
    }
    loadCaste();

  });
</script>