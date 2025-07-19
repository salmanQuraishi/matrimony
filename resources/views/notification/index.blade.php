<x-app-layout>
  <div class="container">
    <div class="page-inner">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header d-flex justify-content-between">
              <h4 class="card-title">View Notification</h4>
              <a href="{{route('notification.create')}}" class="btn btn-info btn-sm">Add Notification</a>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="basic-datatables" class="display table table-striped table-hover">
                  <thead>
                    <tr>
                      <th>Id</th>
                      <th>Titile</th>
                      <th>Status</th>
                      <th>Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($notifications as $data)
                      <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$data->title}}</td>
                        <td>
                          <span class="badge badge-{{ $data->status == 'show' ? 'success' : 'danger' }}">
                            {{ ucfirst($data->status) }}
                          </span>
                        </td>
                        <td>{{$data->created_at}}</td>
                        <td>
                          <a href="{{route('notification.send',['id' => $data->nid])}}" class="btn btn-info btn-sm">
                            <span class="btn-label">
                              <i class="fa fa-bell"></i>
                            </span>
                            Send
                          </a>
                          <a href="{{route('notification.edit',$data->nid)}}" class="btn btn-primary btn-sm">
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