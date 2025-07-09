<x-app-layout>
  <div class="container">
    <div class="page-inner">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <div class="card-title">Create Job Type</div>
            </div>

            <form action="{{route('jobtype.store')}}" method="post">
              @csrf
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <x-form-input
                      type="text"
                      id="nameInput"
                      label="Job Title"
                      name="name"
                      :value="old('name')"
                      placeholder="Enter Job Title"
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