<x-base-layout :title="$title">
<x-slot name="headerFiles">
        <link rel="stylesheet" href="{{asset('src/plugins/src/filepond/filepond.min.css')}}">
        <link rel="stylesheet" href="{{asset('src/plugins/src/filepond/FilePondPluginImagePreview.min.css')}}">
        <link href="{{asset('src/plugins/css/light/filepond/custom-filepond.css')}}" rel="stylesheet" type="text/css" />

        <link rel="stylesheet" href="{{asset('src/assets/css/light/apps/blog-create.css')}}">
        <script src="{{asset('assets/ckeditor/ckeditor.js')}}"></script>
    </x-slot>

    <div class="mb-4 layout-spacing layout-top-spacing">
        <div class="widget widget-table-one position-relative">
                    <form id="form-data" method="POST" novalidate enctype="multipart/form-data">
                    <div class="widget-heading">
                            <h5 class="">{{$title}}</h5>
                            <div class="task-action">
                            </div>
                        </div>
                       
                    <div class="row mb-4">
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="title" name="title" placeholder="Judul"
                                    >
                                <div id="feedback-title" class=""></div>
                            </div>
                        </div>

                        <!-- <div class="row mb-5">
                            <div class="col-sm-5">
                                <label for="product-images">Image</label>
                                <div class="multiple-file-upload">
                                    <input type="file" accept="image/png, image/jpeg, image/gif"
                                        class="filepond file-upload" name="image" id="product-images"
                                        data-allow-reorder="true" data-max-file-size="3MB" data-max-files="5">
                                </div>
                                <div id="feedback-image" class=""></div>
                            </div>
                        </div> -->
                    
                        <div class="row mb-4">
                            <div class="col-sm-12">
                                <label>Deskripsi</label>
                                <textarea id="editor-desc"
                                    name="desc"></textarea>
                                <div id="feedback-desc" class=""></div>
                            </div>
                        </div>


                        <a href="{{route('CMS.fungsi-unit-kerja.index')}}" class="btn btn-danger">Kembali</a>
                        <button type="submit" class="btn btn-primary btn-submit">Simpan</button>
                    </form>
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
        <script>
            $(document).ready(function () {
                var textContent = CKEDITOR.replace('editor-desc', {
                    extraPlugins: 'uploadimage',
                    removePlugins: 'easyimage, cloudservices, exportpdf',
                    toolbarGroups: [
                        { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
                        { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
                        { name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
                        { name: 'forms', groups: [ 'forms' ] },
                        { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
                        { name: 'links', groups: [ 'links' ] },
                        { name: 'insert', groups: [ 'insert' ] },
                        { name: 'styles', groups: [ 'styles' ] },
                        { name: 'colors', groups: [ 'colors' ] },
                        { name: 'tools', groups: [ 'tools' ] },
                        { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
                        { name: 'others', groups: [ 'others' ] },
                        { name: 'about', groups: [ 'about' ] }
                    ],
                    removeButtons: 'About,Save,NewPage,ExportPdf,Preview,Print,Smiley,Iframe,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Find,SelectAll,Scayt,Replace,Language,PasteFromWord',
                });

                FilePond.registerPlugin(
                    FilePondPluginImagePreview,
                    FilePondPluginImageExifOrientation,
                    FilePondPluginFileValidateSize,
                    FilePondPluginFileValidateType,
                    // FilePondPluginImageEdit
                );

                var ecommerce = FilePond.create(document.querySelector('.file-upload'), {
                storeAsFile: true,
                
            });

                var btn = $('.btn-submit');
                var form = $('#form-data');

                form.on('submit', function (e) {
                    e.preventDefault();

                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    var formData = new FormData(form[0]); // Gunakan FormData untuk menangani file input

                    formData.append('_token', csrfToken);
                    formData.append('desc', CKEDITOR.instances['editor-desc'].getData());

                    $.ajax({
                        type: 'POST',
                        url: "{{ route('CMS.fungsi-unit-kerja.store') }}",
                        dataType: 'json',
                        data: formData,
                        contentType: false, // Tetapkan contentType dan processData ke false
                        processData: false,
                        beforeSend: function () {
                            btn.html(
                                    '<div class="spinner-border text-white me-2 align-self-center loader-sm "></div> Loading'
                                )
                                .attr('disabled', true);
                        },
                        success: function (res) {
                            main.notification(res.message, NOTIFICATION_COLOR.SUCCESS);
                            window.location.href = "{{ route('CMS.fungsi-unit-kerja.index') }}";
                        },
                        error: function (res) {
                            var response = res.responseJSON;
                            btn.html('Simpan').attr('disabled', false);
                            main.notification(response.message, NOTIFICATION_COLOR.DANGER);

                            if (typeof response.errors === 'object') {
                                Object.keys(response.errors).map(function (i) {
                                    var message = response.errors[i];
                                    $('#feedback-' + i).addClass('invalid-feedback')
                                        .html(message);
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