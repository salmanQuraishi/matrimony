<x-app-layout>
  <div class="container">
    <div class="page-inner">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">View User</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="basic-datatables" class="display table table-striped table-hover">
                  <thead>
                    <tr>
                      <th>Id</th>
                      <th>Profile</th>
                      <th>Name</th>
                      <th>Mobile</th>
                      <th>Religion</th>
                      <th>Caste</th>
                      <th>Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($users as $data)
                      <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>
                          <img src="{{ asset(!empty($data->profile) ? $data->profile : 'assets/img/no_image_available.jpg') }}" alt="profile" class="rounded" style="width:60px">
                        </td>
                        <td>{{$data->name}}</td>
                        <td>{{$data->mobile}}</td>
                        <td>{{$data->religion->name ?? null}}</td>
                        <td>{{$data->caste->name ?? null}}</td>
                        <td>{{ $data->created_at->format('Y-m-d') }}</td>
                        <td>
                          <a href="{{route('chat.index',$data->id)}}" class="btn btn-info btn-sm">
                            <span class="btn-label">
                              <i class="fa fa-eye"></i>
                            </span>
                            Chat
                          </a>
                          <a href="{{route('user.view',$data->id)}}" class="btn btn-info btn-sm">
                            <span class="btn-label">
                              <i class="fa fa-eye"></i>
                            </span>
                            View
                          </a>
                          <a href="{{route('user.edit',$data->id)}}" class="btn btn-primary btn-sm">
                            <span class="btn-label">
                              <i class="fa fa-edit"></i>
                            </span>
                            Edit
                          </a>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>


      </div>
    </div>
  </div>
</x-app-layout>