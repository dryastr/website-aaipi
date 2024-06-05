<x-base-layout :title="$title">
    <div class="row layout-top-spacing">
        <div class="col-md-12 layout-spacing">
            <div class="widget widget-table-one">
                <div class="widget-heading">
                    <h5 class="">Add Lms App</h5>
                </div>
                <form action="" id="form-data">
                    <div class="row mb-4">
                        <div class="form-group col-md-6">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" name="title" required>
                            <div id="feedback-name" class=""></div>
                        </div>
                    </div>
                    <div class="widget-content">
                        <div class="row mb-4">
                            <div class="form-group col-md-6">
                                <label for="subtitle">Subtitle</label>
                                <input type="text" class="form-control" name="subtitle" required>
                                <div id="feedback-name" class=""></div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="form-group col-md-6">
                                <label for="desc">Description</label>
                                <input type="text" class="form-control" name="desc" required>
                                <div id="feedback-name" class=""></div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="form-group col-md-6">
                                <label for="image">Image</label>
                                <input type="file" class="form-control" name="image" required
                                    onchange="previewImageNew()">
                                <div id="feedback-image" class="mt-3 ms-3"></div>
                            </div>
                        </div>
                        <a href="{{ route('CMS.lms-app.index') }}" class="btn btn-danger">Kembali</a>
                        <button type="submit" class="btn btn-primary btn-submit">Simpan</button>
                    </div>
                </form>
            </div>

        </div>
    </div>


    <x-slot name="footerFiles">
        <script>
            function previewImageNew() {
                var inputNew = document.querySelector('input[name="image"]');
                var feedbackImage = document.getElementById('feedback-image');

                feedbackImage.innerHTML = '';

                if (inputNew.files && inputNew.files[0]) {
                    var readerNew = new FileReader();

                    readerNew.onload = function(e) {
                        var imgNew = document.createElement('img');
                        imgNew.src = e.target.result;
                        imgNew.alt = 'Preview New Image';
                        imgNew.style.maxWidth = '100px';
                        feedbackImage.appendChild(imgNew);
                    }

                    readerNew.readAsDataURL(inputNew.files[0]);
                }
            }
            $(document).ready(function() {
                var btn = $('.btn-submit');
                var form = $('#form-data');

                form.on('submit', function(e) {
                    e.preventDefault();

                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    var formData = new FormData(form[0]); // Gunakan FormData untuk menangani file input

                    formData.append('_token', csrfToken);

                    $.ajax({
                        type: 'POST',
                        url: "{{ route('CMS.lms-app.store') }}",
                        dataType: 'json',
                        data: formData,
                        contentType: false, // Tetapkan contentType dan processData ke false
                        processData: false,
                        beforeSend: function() {
                            btn.html(
                                    '<div class="spinner-border text-white me-2 align-self-center loader-sm "></div> Loading'
                                )
                                .attr('disabled', true);
                        },
                        success: function(res) {
                            main.notification(res.message, NOTIFICATION_COLOR.SUCCESS);
                            window.location.href = "{{ route('CMS.lms-app.index') }}";
                        },
                        error: function(res) {
                            var response = res.responseJSON;
                            btn.html('Simpan').attr('disabled', false);
                            main.notification(response.message, NOTIFICATION_COLOR.DANGER);

                            if (typeof response.errors === 'object') {
                                Object.keys(response.errors).map(function(i) {
                                    var message = response.errors[i];
                                    $('#feedback-' + i).addClass('invalid-feedback').html(
                                        message);
                                });
                            }

                            form.addClass('was-validated');
                        },
                        complete: function() {
                            // Handle completion if needed
                        }
                    });
                });
            });
        </script>
    </x-slot>

</x-base-layout>
