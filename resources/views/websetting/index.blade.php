<x-app-layout>
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Update Web Setting</div>
                        </div>

                        <form action="{{ route('websetting.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <x-form-input type="text" id="titleInput" label="Title" name="title"
                                            :value="old('title', $setting->title)" placeholder="Enter Title" />
                                    </div>

                                    <div class="col-md-4">
                                        <x-form-input type="email" id="emailInput" label="Email" name="email"
                                            :value="old('email', $setting->email)" placeholder="Enter Email" />
                                    </div>

                                    <div class="col-md-4">
                                        <x-form-input type="text" id="mobileInput" label="Mobile" name="mobile"
                                            :value="old('mobile', $setting->mobile)" placeholder="Enter Mobile Number" />
                                    </div>

                                    <div class="col-md-12">
                                        <x-form-textarea id="address" name="address" label="Address" rows="4"
                                            placeholder="Enter Address" :value="old('address', $setting->address)" />
                                    </div>

                                    <div class="col-md-4">
                                        <x-form-input type="file" label="Logo Light" id="logo-input" name="logo"
                                        :value="old('', $setting->logo)" accept="image/*" />
                                        <div class="col-md-12">
                                            <img width="100%" src="{{ asset('/' . $setting->logo) }}"
                                                id="logo-preview" style="cursor: pointer;">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <x-form-input type="file" label="Logo Dark" id="logo-dark-input" name="logo_dark"
                                        :value="old('', $setting->logo_dark)" accept="image/*" />
                                        <div class="col-md-12">
                                            <img width="100%" src="{{ asset('/' . $setting->logo_dark) }}"
                                                id="logo-dark-preview" style="cursor: pointer;">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <x-form-input type="file" label="Favicon" id="favicon-input" name="favicon"
                                        :value="old('', $setting->favicon)" accept="image/*" />
                                        <div class="col-md-4">
                                            <img width="100%" src="{{ asset('/' . $setting->favicon) }}"
                                                id="favicon-preview" style="cursor: pointer;">
                                        </div>
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

<script>
    function setupImagePreview(inputId, previewId) {
        const input = document.getElementById(inputId);
        const preview = document.getElementById(previewId);

        preview?.addEventListener('click', function () {
            input.click();
        });

        input?.addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function () {
                preview.src = reader.result;
            };
            reader.readAsDataURL(file);
        });
    }

    setupImagePreview('logo-dark-input', 'logo-dark-preview');
    setupImagePreview('logo-input', 'logo-preview');
    setupImagePreview('favicon-input', 'favicon-preview');
</script>