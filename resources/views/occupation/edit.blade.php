<x-app-layout>
  <div class="container">
    <div class="page-inner">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <div class="card-title">Edit Occupation</div>
            </div>

            <form action="{{ route('occupation.update', $occupation->oid) }}" method="post">
              @csrf
              @method('PUT')

              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <x-form-input
                      type="text"
                      id="nameInput"
                      label="Occupation Title"
                      name="name"
                      :value="old('name', $occupation->name)"
                      placeholder="Enter Occupation Title"
                    />
                    <x-status-select 
                      id="statusSelect" 
                      name="status"
                      :selected="old('status',$occupation->status)"
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