<x-base-layout :title="$title">
    <div class="row layout-top-spacing">
        <div class="col-md-12 layout-spacing">
            <div class="widget widget-table-one">
                <div class="widget-heading">
                    <h5 class="">{{ $title }}</h5>
                </div>
                <div class="widget-content">
                    <form id="form-data" action="{{ $item->id }}" enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="row mb-4">
                            <div class="form-group col-md-6">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" name="title"
                                    value="{{ old('title', $item->title) }}">
                                <div id="feedback-name" class=""></div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="form-group col-md-6">
                                <label for="subtitle">Sub Title</label>
                                <input type="text" class="form-control" name="subtitle"
                                    value="{{ old('subtitle', $item->subtitle) }}">
                                <div id="feedback-name" class=""></div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="form-group col-md-6">
                                <label for="desc">Description</label>
                                <input type="text" class="form-control" name="desc"
                                    value="{{ old('desc', $item->desc) }}">
                                <div id="feedback-name" class=""></div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="form-group col-md-6">
                                <label for="image">Gambar</label>
                                <input type="file" class="form-control" name="image" value="{{ $item->image }}" accept="img/*" onchange="previewImage()">
                                @if ($item->image)
                                    <div class="mt-3 ms-3" id="image-preview">
                                        <img src="{{ url($item->image_url) }}" alt="Current Image" style="max-width: 100px;">
                                    </div>
                                @endif
                                <div id="feedback-description" class=""></div>
                            </div>
                        </div>
                        <a href="{{ route('CMS.lms-app.index') }}" class="btn btn-danger">Kembali</a>
                        <button type="submit" class="btn btn-primary btn-submit">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <x-slot name="footerFiles">
        <script>
            function previewImage() {
                var input = document.querySelector('input[name="image"]');
                var preview = document.getElementById('image-preview');

                // Hapus gambar sebelumnya jika ada
                while (preview.firstChild) {
                    preview.removeChild(preview.firstChild);
                }

                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        var img = document.createElement('img');
                        img.src = e.target.result;
                        img.alt = 'Preview Image';
                        img.style.maxWidth = '100px';
                        preview.appendChild(img);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }
            $(document).ready(function() {
                var btn = $('.btn-submit');
                var form = $('#form-data');
                form.on('submit', function(e) {
                    e.preventDefault();
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    var formData = new FormData(form[0]);
                    formData.append('_token', csrfToken);
                    formData.append('_method', 'PUT');
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('CMS.lms-app.update', $item->id) }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: 'json',
                        processData: false,
                        contentType: false,
                        data: formData,
                        beforeSend: function() {
                            btn.html(
                                '<div class="spinner-border text-white me-2 align-self-center loader-sm"></div> Loading'
                            ).attr('disabled', true)
                        },
                        success: function(res) {
                            main.notification(res.message, NOTIFICATION_COLOR.SUCCESS);
                            window.location.href = "{{ route('CMS.lms-app.index') }}";
                        },
                        error: function(res) {
                            var response = res.responseJSON;
                            btn.html('Simpan').attr('disabled', false);
                            main.notification(response.message, NOTIFICATION_COLOR.DANGER);
                            if (typeof res.responseJSON.errors === 'object') {
                                Object.keys(response.errors).map((i) => {
                                    var message = response.errors[i];
                                    $(`#feedback-${i}`).addClass('invalid-feedback').html(
                                        message);
                                });
                            }
                            form.addClass('was-validated');
                        }
                    });
                });
            });
        </script>
    </x-slot>
</x-base-layout>
