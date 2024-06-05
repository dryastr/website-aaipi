<x-base-layout :title="$title">
    <x-slot name="headerFiles">
        
        <link rel="stylesheet" href="{{asset('src/plugins/src/filepond/filepond.min.css')}}">
        <link rel="stylesheet" href="{{asset('src/plugins/src/filepond/FilePondPluginImagePreview.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('src/plugins/src/tagify/tagify.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('src/assets/css/light/forms/switches.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('src/plugins/css/light/editors/quill/quill.snow.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('src/plugins/css/light/tagify/custom-tagify.css')}}">
        <link href="{{asset('src/plugins/css/light/filepond/custom-filepond.css')}}" rel="stylesheet" type="text/css" />


        <link rel="stylesheet" href="{{asset('src/assets/css/light/apps/blog-create.css')}}">
        <style>
            .ql-editor strong {
                font-weight: bold;
            }
        </style>
    </x-slot>
    <div class="row layout-top-spacing">
        <div class="col-md-12 layout-spacing">
            <div class="widget widget-table-one">
                <div class="widget-heading">
                    <h5 class="">{{$title}}</h5>
                </div>
                <div class="widget-content">
                    <form id="form-data" method="POST" novalidate>
                        <div class="row mb-4">
                            <div class="form-group col-md-10">
                                <label for="title_banner">Title</label>
                                <input type="text" class="form-control" name="title_banner" required>
                                <div id="feedback-name" class=""></div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="form-group col-md-6">
                                <label for="conten_tentang">Description</label>
                                <textarea class="form-control" name="conten_tentang" required></textarea>
                                <div id="feedback-name" class=""></div>
                            </div>
                        </div>
                        <div class="widget-content">
                            <!-- <div class="row mb-4">
                                <div class="form-group col-md-6">
                                    <label for="visi">visi</label>
                                    <textarea class="form-control" name="visi" required></textarea>
                                    <div id="feedback-name" class=""></div>
                        
                                </div>
                            </div> -->
                            <div class="row mb-4">
                                <div class="col-sm-10">
                                    <label>Misi</label>
                                    <div id="editor-visi"></div>
                                </div>
                            </div>
                            <!-- <div class="row mb-4">
                                <div class="form-group col-md-6">
                                    <label for="misi">misi</label>
                                    <textarea class="form-control" name="misi" required></textarea>
                                    <div id="feedback-name" class=""></div>
                                </div>
                            </div> -->
                            <div class="row mb-4">
                                <div class="col-sm-10">
                                    <label>Misi</label>
                                    <div id="editor-misi"></div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="form-group col-md-6">
                                    <label for="banner">Banner</label>
                                    <input type="file" class="form-control" name="banner" id="banner-input" required>
                                    <div id="feedback-name" class=""></div>
                                </div>
                            </div>
                        <div class="row mb-4">
                            <div class="form-group col-md-6">
                                <label for="image">Image</label>
                                <input type="file" class="form-control" name="image" id="image-input" required>
                                <div id="feedback-name" class=""></div>
                            </div>
                        </div>

                        

                        <a href="{{route('CMS.visi-misi.index')}}" class="btn btn-danger">Kembali</a>
                        <button type="submit" class="btn btn-primary btn-submit">Simpan</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
    

    <x-slot name="footerFiles">
        <script src="{{asset('src/plugins/src/filepond/filepond.min.js')}}"></script>
        <script src="{{asset('src/plugins/src/filepond/FilePondPluginFileValidateType.min.js')}}"></script>
        <script src="{{asset('src/plugins/src/filepond/FilePondPluginImageExifOrientation.min.js')}}"></script>
        <script src="{{asset('src/plugins/src/filepond/FilePondPluginImagePreview.min.js')}}"></script>
        <script src="{{asset('src/plugins/src/filepond/FilePondPluginImageCrop.min.js')}}"></script>
        <script src="{{asset('src/plugins/src/filepond/FilePondPluginImageResize.min.js')}}"></script>
        <script src="{{asset('src/plugins/src/filepond/FilePondPluginImageTransform.min.js')}}"></script>
        <script src="{{asset('src/plugins/src/filepond/filepondPluginFileValidateSize.min.js')}}"></script>
        <script src="{{asset('src/plugins/src/editors/quill/quill.js')}}"></script>
    <script>
       $(document).ready(function () {
            var btn = $('.btn-submit');
            var form = $('#form-data');
            var textVisi = new Quill('#editor-visi', {
                    modules: {
                        // toolbar: '#toolbar'
                    },
                    theme: 'snow'
                })

            var textMisi = new Quill('#editor-misi', {
                modules: {
                    // toolbar: '#toolbar'
                },
                theme: 'snow'
            })

            FilePond.registerPlugin(
            FilePondPluginImagePreview,
            FilePondPluginImageExifOrientation,
            FilePondPluginFileValidateSize,
            FilePondPluginFileValidateType
        );
        var bannerInput = document.getElementById('banner-input');
        var imageInput = document.getElementById('image-input');
        var imagePreview = document.getElementById('selected-image');  // Ganti dengan ID sesuai dengan kebutuhan

        var bannerPond = FilePond.create(bannerInput, {
            allowReorder: true,
            maxFileSize: '3MB',
            maxFiles: 5,
            acceptedFileTypes: ['image/png', 'image/jpeg', 'image/gif'],
            onaddfile: function (error, file) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                };
                reader.readAsDataURL(file.file);
            },
            onremovefile: function () {
                imagePreview.src = '#';
                imagePreview.style.display = 'none';
            }
    
});


        var imagePond = FilePond.create(imageInput, {
            allowReorder: true,
            maxFileSize: '3MB',
            maxFiles: 5,
            acceptedFileTypes: ['image/png', 'image/jpeg', 'image/gif'],
            onaddfile: function (error, file) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                };
                reader.readAsDataURL(file.file);
            },
            onremovefile: function () {
                imagePreview.src = '#';
                imagePreview.style.display = 'none';
            }
        });


            form.on('submit', function (e) {
                e.preventDefault();

                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var formData = new FormData(form[0]);  // Gunakan FormData untuk menangani file input

                formData.append('_token', csrfToken);
                formData.append('visi', textVisi.root.innerText.trim());
                formData.append('misi', textMisi.root.innerText.trim());
                formData.set('banner', bannerPond.getFiles()[0]?.file ?? '');
                formData.set('image', imagePond.getFiles()[0]?.file ?? '');

                $.ajax({
                    type: 'POST',
                    url: "{{ route('CMS.visi-misi.store') }}",
                    dataType: 'json',
                    data: formData,
                    contentType: false,  // Tetapkan contentType dan processData ke false
                    processData: false,
                    beforeSend: function () {
                        btn.html('<div class="spinner-border text-white me-2 align-self-center loader-sm "></div> Loading')
                            .attr('disabled', true);
                    },
                    success: function (res) {
                        main.notification(res.message, NOTIFICATION_COLOR.SUCCESS);
                        window.location.href = "{{ route('CMS.visi-misi.index') }}";
                    },
                    error: function (res) {
                        var response = res.responseJSON;
                        btn.html('Simpan').attr('disabled', false);
                        main.notification(response.message, NOTIFICATION_COLOR.DANGER);

                        if (typeof response.errors === 'object') {
                            Object.keys(response.errors).map(function (i) {
                                var message = response.errors[i];
                                $('#feedback-' + i).addClass('invalid-feedback').html(message);
                            });
                        }

                        form.addClass('was-validated');
                    },
                    complete: function () {
                        // Handle completion if needed
                    }
                });
            });
        });

    </script>
</x-slot>

</x-base-layout>