<x-app-layout>
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-12">

                    <div class="card">

                        {{-- Header --}}
                        <div class="card-header border-0 py-3">
                            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 w-100">

                                <div>
                                    <h4 class="card-title mb-1 fw-bold text-dark">
                                        Nikah Cards List
                                    </h4>

                                    <p class="mb-0 text-muted small">
                                        Manage generated nikah cards, preview and download templates.
                                    </p>
                                </div>

                                <div class="d-flex align-items-center gap-2">

                                    <a href="{{ route('nikah-card.form', $user->id) }}"
                                        class="btn btn-primary btn-sm px-4 shadow-sm">

                                        <i class="fas fa-plus-circle me-1"></i>
                                        Add / Update Cards
                                    </a>

                                </div>

                            </div>
                        </div>

                        {{-- Body --}}
                        <div class="card-body">
                            <div class="table-responsive">

                                <table id="basic-datatables"
                                    class="display table table-striped table-hover align-middle">

                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>User</th>
                                            <th>Template</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse($cards as $key => $card)

                                            <tr id="cardRow{{ $card->id }}">

                                                <td>{{ $key + 1 }}</td>

                                                <td>
                                                    {{ $card->user->name ?? 'N/A' }}
                                                </td>

                                                <td>
                                                    <span class="badge bg-secondary px-3 py-2">
                                                        {{ $card->template_name }}
                                                    </span>
                                                </td>

                                                <td>

                                                    <div class="d-flex flex-wrap gap-2">

                                                        <a href="{{ asset($card->card_path) }}" target="_blank"
                                                            class="btn btn-info btn-sm">

                                                            <i class="fas fa-eye me-1"></i>
                                                            Preview
                                                        </a>

                                                        <a href="{{ route('nikah-card.download', $card->id) }}"
                                                            class="btn btn-success btn-sm">

                                                            <i class="fas fa-download me-1"></i>
                                                            Download
                                                        </a>

                                                        <button type="button" class="btn btn-danger btn-sm deleteCardBtn"
                                                            data-id="{{ $card->id }}"
                                                            data-url="{{ route('nikah-card.delete', $card->id) }}">

                                                            <i class="fas fa-trash me-1"></i>
                                                            Delete
                                                        </button>

                                                    </div>

                                                </td>

                                            </tr>

                                        @empty

                                            <tr>
                                                <td colspan="4" class="text-center">
                                                    No cards found
                                                </td>
                                            </tr>

                                        @endforelse
                                    </tbody>

                                </table>

                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Delete Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const deleteButtons = document.querySelectorAll('.deleteCardBtn');

            deleteButtons.forEach(button => {

                button.addEventListener('click', function () {

                    let cardId = this.dataset.id;
                    let deleteUrl = this.dataset.url;

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This card will be deleted permanently!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, Delete',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {

                        if (result.isConfirmed) {

                            Swal.fire({
                                title: 'Deleting...',
                                text: 'Please wait',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                showConfirmButton: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });

                            fetch(deleteUrl, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json',
                                    'X-Requested-With': 'XMLHttpRequest'
                                }
                            })
                                .then(async response => {

                                    const data = await response.json();

                                    if (!response.ok) {
                                        throw data;
                                    }

                                    return data;
                                })
                                .then(data => {

                                    document.getElementById('cardRow' + cardId).remove();

                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted',
                                        text: data.message,
                                        timer: 2000,
                                        showConfirmButton: false
                                    });

                                })
                                .catch(error => {

                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: error.message || 'Something went wrong'
                                    });

                                });

                        }

                    });

                });

            });

        });
    </script>

</x-app-layout>