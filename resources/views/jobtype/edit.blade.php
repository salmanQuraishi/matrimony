<x-app-layout>
  <div class="container">
    <div class="page-inner">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <div class="card-title">Edit Job Type</div>
            </div>

            <form action="{{ route('jobtype.update', $jobtype->jtid) }}" method="post">
              @csrf
              @method('PUT')

              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <x-form-input
                      type="text"
                      id="nameInput"
                      label="job Title"
                      name="name"
                      :value="old('name', $jobtype->name)"
                      placeholder="Enter job Title"
                    />
                    <x-status-select 
                      id="statusSelect" 
                      name="status"
                      :selected="old('status',$jobtype->status)"
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