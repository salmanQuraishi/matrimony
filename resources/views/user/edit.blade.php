<x-app-layout>
  <div class="container">
    <div class="page-inner">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <div class="card-title">Edit Religion</div>
            </div>

            <form action="{{ route('religion.update', $religion->rid) }}" method="post">
              @csrf
              @method('PUT')

              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <x-form-input
                      type="text"
                      id="nameInput"
                      label="Religion Title"
                      name="name"
                      :value="old('name', $religion->name)"
                      placeholder="Enter Religion Title"
                    />
                    <x-form-textarea
                      id="description"
                      name="description"
                      label="Description"
                      rows="4"
                      placeholder="Enter description"
                      :value="old('description', $religion->description)"
                    />
                    <x-status-select 
                      id="statusSelect" 
                      name="status"
                      :selected="old('status',$religion->status)"
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