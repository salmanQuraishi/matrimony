<x-app-layout>
  <div class="container">
    <div class="page-inner">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header d-flex justify-content-between">
              <h4 class="card-title">View Job Type</h4>
              <a href="{{route('jobtype.create')}}" class="btn btn-info btn-sm">Add Job Type</a>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="basic-datatables" class="display table table-striped table-hover">
                  <thead>
                    <tr>
                      <th>Id</th>
                      <th>Name</th>
                      <th>Status</th>
                      <th>Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($jobtypes as $data)
                      <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$data->name}}</td>
                        <td>
                          <span class="badge badge-{{ $data->status == 'show' ? 'success' : 'danger' }}">
                            {{ ucfirst($data->status) }}
                          </span>
                        </td>
                        <td>{{$data->created_at}}</td>
                        <td>
                          <a href="{{route('jobtype.edit',$data->jtid)}}" class="btn btn-primary btn-sm">
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