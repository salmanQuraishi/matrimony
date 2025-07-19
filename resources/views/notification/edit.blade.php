<x-app-layout>
  <div class="container">
    <div class="page-inner">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <div class="card-title">Edit Notification</div>
            </div>

            <form action="{{route('notification.update',$notification->nid)}}" method="post" enctype="multipart/form-data">
              @csrf
              <div class="card-body">
                <div class="row">
                  <div class="col-md-9">
                    <x-form-textarea
                      id="Editor"
                      name="desc"
                      label="Description"
                      rows="4"
                      placeholder="Enter Description"
                      :value="old('desc',$notification->desc)"
                    />
                  </div>
                  <div class="col-md-3">
                    <div class="col-md-12" style="padding: 10px">
                      <img width="100%"
                        src="{{old(asset('/add-img-placeholder.jpg'),asset('/'.$notification->image))}}"
                        id="slider-preview">
                    </div>
                    <x-form-input type="file" id="image-slider" name="image" :value="old('image',$notification->image)" />
                  </div>
                  <div class="col-md-6">
                    <x-form-input type="text" id="nameInput" label="Title" name="title" :value="old('title',$notification->title)"
                      placeholder="Enter Title" />
                  </div>
                  <div class="col-md-6">
                    <x-status-select id="statusSelect" name="status" :selected="old('status',$notification->status)" />
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
@include('notification.ckEditor')