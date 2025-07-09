<x-app-layout>
  <div class="container">
    <div class="page-inner">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <div class="card-title">Create Caste</div>
            </div>

            <form action="{{route('caste.store')}}" method="post">
              @csrf
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <x-form-select 
                      label="Choose a Religion" 
                      id="religionSelect" 
                      name="religion_id" 
                      :options="$religions"
                      :selected="old('religion_id')" 
                    />
                    <x-form-input
                      type="text"
                      id="nameInput"
                      label="Caste Title"
                      name="name"
                      :value="old('name')"
                      placeholder="Enter Caste Title"
                    />
                    <x-form-textarea
                      id="description"
                      name="description"
                      label="Description"
                      rows="4"
                      placeholder="Enter Description"
                      :value="old('description')"
                    />
                    <x-status-select 
                      id="statusSelect" 
                      name="status" 
                      :selected="old('status')" 
                    />
                  </div>
                </div>
              </div>
              <div class="card-action">
                <button class="btn btn-success" type="submit">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>