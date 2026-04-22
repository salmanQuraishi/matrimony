<x-app-layout>
    <div class="container">
        <div class="page-inner">

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Upload Multiple Images</h4>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('gallery.store', $userid) }}" method="POST" enctype="multipart/form-data" id="galleryUploadForm">
                                @csrf

                                <div class="form-group col-md-12">
                                    <label>Select Images</label>
                                    <input type="file"
                                        name="images[]"
                                        id="galleryImages"
                                        class="form-control"
                                        multiple
                                        accept="image/*"
                                        required>
                                </div>

                                {{-- Preview Area --}}
                                <div class="">
                                    <div class="row" id="imagePreviewContainer"></div>
                                </div>

                                <button type="submit" class="btn btn-primary  col-md-12">
                                    <i class="fa fa-upload"></i> Upload Images
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Existing Gallery Table --}}
            <div class="row">
                <div class="col-md-12">
                    <div class="card">

                        <div class="card-header">
                            <h4 class="card-title">View Gallery</h4>
                        </div>

                        <div class="card-body">

                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <div class="table-responsive">
                                <table id="basic-datatables" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Image</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($gallery as $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <img src="{{ asset($data->image_path) }}"
                                                        alt="image"
                                                        style="width:80px;height:60px;object-fit:cover;border-radius:5px;">
                                                </td>
                                                <td>{{ $data->created_at->format('d M Y') }}</td>
                                                <td>
                                                    <form action="{{ route('gallery.destroy', $data->gid) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Are you sure you want to delete this image?');">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                            <i class="fa fa-trash"></i> Delete
                                                        </button>
                                                    </form>
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

    {{-- Custom Style --}}
    <style>
        .preview-card {
            position: relative;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 10px;
            background: #fff;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .preview-img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 8px;
        }

        .remove-btn {
            position: absolute;
            top: 15px;
            right: 15px;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .file-name {
            font-size: 13px;
            margin-top: 8px;
            word-break: break-word;
            color: #555;
        }
    </style>

    {{-- Preview + Remove JS --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const fileInput = document.getElementById('galleryImages');
            const previewContainer = document.getElementById('imagePreviewContainer');

            let selectedFiles = [];

            fileInput.addEventListener('change', function (event) {
                const newFiles = Array.from(event.target.files);

                newFiles.forEach(file => {
                    if (!selectedFiles.some(existingFile =>
                        existingFile.name === file.name &&
                        existingFile.size === file.size &&
                        existingFile.lastModified === file.lastModified
                    )) {
                        selectedFiles.push(file);
                    }
                });

                updateFileInput();
                renderPreviews();
            });

            function updateFileInput() {
                const dataTransfer = new DataTransfer();

                selectedFiles.forEach(file => {
                    dataTransfer.items.add(file);
                });

                fileInput.files = dataTransfer.files;
            }

            function renderPreviews() {
                previewContainer.innerHTML = '';

                if (selectedFiles.length === 0) {
                    previewContainer.innerHTML = `
                        <div class="col-12">
                            <div class="alert alert-warning mb-0">
                                No images selected.
                            </div>
                        </div>
                    `;
                    return;
                }

                selectedFiles.forEach((file, index) => {
                    const reader = new FileReader();

                    reader.onload = function (e) {
                        const col = document.createElement('div');
                        col.className = 'col-md-3 col-sm-4 col-6';

                        col.innerHTML = `
                            <div class="preview-card">
                                <button type="button" class="btn btn-danger btn-sm remove-btn" data-index="${index}">
                                    <i class="fa fa-times"></i>
                                </button>
                                <img src="${e.target.result}" class="preview-img" alt="preview">
                                <div class="file-name">${file.name}</div>
                            </div>
                        `;

                        previewContainer.appendChild(col);

                        col.querySelector('.remove-btn').addEventListener('click', function () {
                            removeImage(index);
                        });
                    };

                    reader.readAsDataURL(file);
                });
            }

            function removeImage(index) {
                selectedFiles.splice(index, 1);
                updateFileInput();
                renderPreviews();
            }
        });
    </script>
</x-app-layout>