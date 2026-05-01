<x-app-layout>
  <style>
    .icon-btn {
      width: 34px;
      height: 34px;
      padding: 0;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      border-radius: 8px;
    }

    .icon-btn i {
      font-size: 14px;
    }
  </style>
  <div class="container">
    <div class="page-inner">
      <div class="row">
        <div class="col-md-12">
          <div class="card custom-table-card">
            <div class="card-header">
              <h4 class="card-title mb-0">View User</h4>
            </div>

            <div class="card-body">
              <div class="table-responsive">
                <table id="basic-datatables"
                  class="table custom-data-table table-striped table-hover align-middle mb-0">
                  <thead>
                    <tr>
                      <th>Sr. No.</th>
                      <th>Profile</th>
                      <th>Name</th>
                      <th>Mobile</th>
                      <th>Religion</th>
                      <th>Caste</th>
                      <th>Date</th>
                      <th class="text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($users as $data)
                      <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>
                          <img
                            src="{{ asset(!empty($data->profile) ? $data->profile : 'assets/img/no_image_available.jpg') }}"
                            alt="profile" class="rounded" style="width:60px">
                        </td>

                        <td>{{ $data->name }}</td>
                        <td>{{ $data->mobile }}</td>
                        <td>{{ $data->religion->name ?? '-' }}</td>
                        <td>{{ $data->caste->name ?? '-' }}</td>
                        <td>{{ $data->created_at->format('Y-m-d') }}</td>

                        <td class="text-center">
                          <div class="table-action-group">
                            <a href="{{ route('chat.index', encrypt($data->id)) }}"
                              class="btn btn-warning btn-sm icon-btn" title="Chat">
                              <i class="fab fa-rocketchat"></i>
                            </a>

                            <a href="{{ route('user.view', $data->id) }}" class="btn btn-info btn-sm icon-btn"
                              title="View">
                              <i class="fa fa-eye"></i>
                            </a>

                            <a href="{{ route('user.edit', $data->id) }}" class="btn btn-primary btn-sm icon-btn"
                              title="Edit">
                              <i class="fa fa-edit"></i>
                            </a>

                            <a href="{{ route('gallery.index', $data->id) }}" class="btn btn-secondary btn-sm icon-btn"
                              title="Gallery">
                              <i class="fa fa-images"></i>
                            </a>

                            @if(app()->environment('production'))
                              <a href="{{ route('nikah-card.list', $data->id) }}" 
                                class="btn btn-secondary btn-sm icon-btn"
                                title="card">
                                  <i class="fa fa-file"></i>
                              </a>
                            @endif

                          </div>
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