<x-app-layout>
  <div class="container">
    <div class="page-inner">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header d-flex justify-content-between">
              <h4 class="card-title">View Annual Income</h4>
              <a href="{{route('annualincome.create')}}" class="btn btn-info btn-sm">Add Annual Income</a>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="basic-datatables" class="display table table-striped table-hover">
                  <thead>
                    <tr>
                      <th>Id</th>
                      <th>Range</th>
                      <th>Status</th>
                      <th>Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($annualincomes as $data)
                      <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$data->range}}</td>
                        <td>
                          <span class="badge badge-{{ $data->status == 'show' ? 'success' : 'danger' }}">
                            {{ ucfirst($data->status) }}
                          </span>
                        </td>
                        <td>{{$data->created_at}}</td>
                        <td>
                          <a href="{{route('annualincome.edit',$data->aid)}}" class="btn btn-primary btn-sm">
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