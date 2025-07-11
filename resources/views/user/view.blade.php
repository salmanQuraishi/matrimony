<x-app-layout>
  <div class="container">
    <div class="page-inner">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <div class="card-title">View User</div>
            </div>

            <form action="{{ route('user.edit', $user->id) }}" method="post">
              @csrf
              @method('PUT')

              <div class="card-body">
                <div class="row">
                  <div class="col-md-4">
                    <x-form-input
                      type="text"
                      id="nameInput"
                      label="Dummy Id"
                      name="dummyid"
                      :value="old('dummyid', $user->dummyid)"
                      placeholder="Enter Dummy Id"
                    />
                  </div>
                  <div class="col-md-4">
                    <x-form-input
                      type="text"
                      id="nameInput"
                      label="User Name"
                      name="name"
                      :value="old('name', $user->name)"
                      placeholder="Enter User Name"
                    />
                  </div>
                  <div class="col-md-4">
                    <x-form-input
                      type="text"
                      id="nameInput"
                      label="User Email"
                      name="email"
                      :value="old('email', $user->email)"
                      placeholder="Enter User Email"
                    />
                  </div>
                  <div class="col-md-4">
                    <x-form-input
                      type="number"
                      id="nameInput"
                      label="User Mobile"
                      name="mobile"
                      :value="old('mobile', $user->mobile)"
                      placeholder="Enter User Mobile"
                    />
                  </div>
                  <div class="col-md-4">
                    <x-form-input
                      type="text"
                      id="nameInput"
                      label="User Age"
                      name="age"
                      :value="old('age', $user->age)"
                      placeholder="Enter User Age"
                    />
                  </div>
                  <div class="col-md-4">
                    <x-form-input
                    type="date"
                    id="nameInput"
                    label="User DOB"
                    name="dob"
                    :value="old('dob', $user->dob)"
                    placeholder="Enter User DOB"
                    />
                  </div>
                  <div class="col-md-4">
                    <x-form-input
                      type="text"
                      id="nameInput"
                      label="User Height"
                      name="height"
                      :value="old('height', $user->height)"
                      placeholder="Enter User Height"
                    />
                  </div>
                  <div class="col-md-4">
                    <x-form-input
                      type="text"
                      id="nameInput"
                      label="User Weight"
                      name="weight"
                      :value="old('weight', $user->weight)"
                      placeholder="Enter User Weight"
                    />
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Gender</label><br>
                      <div class="d-flex">
                        <div class="form-check me-3">
                          <input class="form-check-input" type="radio" name="gender" id="genderMale" value="male"
                            {{ $user->gender == 'male' ? 'checked' : '' }}>
                          <label class="form-check-label" for="genderMale">
                            Male
                          </label>
                        </div>

                        <div class="form-check me-3">
                          <input class="form-check-input" type="radio" name="gender" id="genderFemale" value="female"
                            {{ $user->gender == 'female' ? 'checked' : '' }}>
                          <label class="form-check-label" for="genderFemale">
                            Female
                          </label>
                        </div>

                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="gender" id="genderOther" value="other"
                            {{ $user->gender == 'other' ? 'checked' : '' }}>
                          <label class="form-check-label" for="genderOther">
                            Other
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <x-form-textarea
                      id="myself"
                      name="myself"
                      label="About Myself"
                      rows="4"
                      placeholder="Enter About Myself"
                      :value="old('myself', $user->myself)"
                    />
                  </div>
                </div>
              </div>

              <div class="card-action">
                <button class="btn btn-success" type="submit">Update</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>