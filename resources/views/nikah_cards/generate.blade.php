<x-app-layout>
    <div class="container">
        <div class="page-inner">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="mb-0">Generate Nikah Card</h3>
                <a href="{{ route('nikah-card.list', $user->id) }}" class="btn btn-info btn-sm">
                    View Generated Cards
                </a>
            </div>

            <div class="row">
                @foreach($templates as $template)
                    <div class="col-md-3">
                        <div class="card shadow-sm">
                            <img src="{{ asset($template->image_path) }}" class="card-img-top" alt="{{ $template->name }}"
                                style="object-fit: cover;"
                                onerror="this.src='{{ asset('assets/img/no_image_available.jpg') }}'">

                            <div class="card-body text-center">
                                <h5>{{ $template->name }}</h5>

                                <form class="generateCardForm" action="{{ route('nikah-card.generate', $user->id) }}"
                                    method="POST">
                                    @csrf
                                    <input type="hidden" name="template_function" value="{{ $template->function_name }}">
                                    <input type="hidden" name="template_name" value="{{ $template->name }}">
                                    <input type="hidden" name="template_path" value="{{ $template->image_path }}">

                                    <button type="submit" class="btn btn-primary generateBtn">
                                        Generate Card
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const forms = document.querySelectorAll('.generateCardForm');

            forms.forEach(form => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();

                    const formData = new FormData(this);
                    const actionUrl = this.getAttribute('action');
                    const submitBtn = this.querySelector('.generateBtn');

                    submitBtn.disabled = true;

                    Swal.fire({
                        title: 'Please wait...',
                        text: 'Card is generating...',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    fetch(actionUrl, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                            'Accept': 'application/json'
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
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: data.message || 'Card generated successfully',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                if (data.redirect_url) {
                                    window.location.href = data.redirect_url;
                                } else {
                                    window.location.reload();
                                }
                            });
                        })
                        .catch(error => {
                            let errorMessage = 'Something went wrong';

                            if (error.message) {
                                errorMessage = error.message;
                            } else if (error.errors) {
                                errorMessage = Object.values(error.errors).flat().join('\n');
                            }

                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: errorMessage
                            });
                        })
                        .finally(() => {
                            submitBtn.disabled = false;
                        });
                });
            });
        });
    </script>
</x-app-layout>