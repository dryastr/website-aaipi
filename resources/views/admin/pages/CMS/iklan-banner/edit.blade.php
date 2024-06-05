<x-base-layout :title="$title">
    <x-slot name="headerFiles">
        <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/src/tomSelect/tom-select.default.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/css/light/tomSelect/custom-tomSelect.css') }}">
        <link rel="stylesheet" href="{{ asset('src/plugins/src/filepond/filepond.min.css') }}">
        <link rel="stylesheet" href="{{ asset('src/plugins/src/filepond/FilePondPluginImagePreview.min.css') }}">
        <link href="{{ asset('src/plugins/css/light/filepond/custom-filepond.css') }}" rel="stylesheet"
            type="text/css" />
    </x-slot>
    <div class="row layout-top-spacing">
        <div class="col-md-12 layout-spacing">
            <div class="widget widget-table-one">
                <div class="widget-heading">
                    <h5 class="">{{ $title }}</h5>
                </div>
                <form action="" id="form-data">
                    {{-- @csrf --}}
                    <div class="widget-content">
                        <div class="row mb-4">
                            <div class="form-group col-md-6">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" name="title" value="{{$item->title}}">
                                <div id="feedback-title" class=""></div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="form-group col-md-6">
                                <label for="image">Gambar</label>
                                <div class="multiple-file-upload">
                                    <input type="file"
                                        accept="image/png, image/jpeg, image/gif"
                                        class="filepond file-upload"
                                        name="image"
                                        id="product-images"
                                        data-allow-reorder="true"
                                        data-max-file-size="3MB"
                                        data-max-files="5">
                                </div>
                                <div id="feedback-image" class=""></div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="form-group col-md-6">
                                <label for="url">URL</label>
                                <input type="text" class="form-control" name="url" value="{{$item->url}}">
                                <div id="feedback-url" class=""></div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="form-group col-md-6">
                                <label for="target">Target</label>
                                <input type="text" class="form-control" name="target" value="{{$item->target}}">
                                <div id="feedback-target" class=""></div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-submit">Simpan</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <x-slot name="footerFiles">
        <script src="{{asset('src/plugins/src/tomSelect/tom-select.base.js')}}"></script>
        <script src="{{asset('src/plugins/src/filepond/filepond.min.js')}}"></script>
        <script src="{{asset('src/plugins/src/filepond/FilePondPluginFileValidateType.min.js')}}"></script>
        <script src="{{asset('src/plugins/src/filepond/FilePondPluginImageExifOrientation.min.js')}}"></script>
        <script src="{{asset('src/plugins/src/filepond/FilePondPluginImagePreview.min.js')}}"></script>
        <script src="{{asset('src/plugins/src/filepond/FilePondPluginImageCrop.min.js')}}"></script>
        <script src="{{asset('src/plugins/src/filepond/FilePondPluginImageResize.min.js')}}"></script>
        <script src="{{asset('src/plugins/src/filepond/FilePondPluginImageTransform.min.js')}}"></script>
        <script src="{{asset('src/plugins/src/filepond/filepondPluginFileValidateSize.min.js')}}"></script>

        <script>
            $(document).ready(function() {
                var btn = $('.btn-submit');
                var form = $('#form-data');

                FilePond.registerPlugin(
                    FilePondPluginImagePreview,
                    FilePondPluginImageExifOrientation,
                    FilePondPluginFileValidateSize,
                    FilePondPluginFileValidateType,
                    // FilePondPluginImageEdit
                );

                var ecommerce = FilePond.create(document.querySelector('.file-upload'), {

                    storeAsFile: true,
                    @if($item['image'])
                    files: [
                        {
                            // the server file reference
                            source: '{{$item['image']}}',

                            // set type to limbo to tell FilePond this is a temp file
                            // options: {
                            //     type: 'image/png',
                            // },
                        },
                    ],
                    @endif
                });

                form.on('submit', function(e) {
                    e.preventDefault();

                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    var formData = new FormData(form[0]); 

                    formData.append('_token', csrfToken);
                    formData.append('_method', 'PUT');

                    $.ajax({
                        type: 'POST',
                        url: "{{ route('cms.iklan-banner.update', $item['id']) }}",
                        dataType: 'json',
                        data: formData,
                        contentType: false,
                        processData: false,
                        beforeSend: function() {
                            btn.html(
                                    '<div class="spinner-border text-white me-2 align-self-center loader-sm "></div> Loading'
                                    )
                                .attr('disabled', true);
                        },
                        success: function(res) {
                            main.notification(res.message, NOTIFICATION_COLOR.SUCCESS);
                            window.location.href = "{{ route('cms.iklan-banner.index') }}";
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

                        }
                    });
                });
            });
        </script>
    </x-slot>

</x-base-layout>