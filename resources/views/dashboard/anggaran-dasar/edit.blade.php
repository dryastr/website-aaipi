<x-base-layout :title="$title">
    <x-slot name="headerFiles">
        <link rel="stylesheet" href="{{asset('src/plugins/src/filepond/filepond.min.css')}}">
        <link href="{{asset('src/plugins/css/light/filepond/custom-filepond.css')}}" rel="stylesheet" type="text/css" />
    </x-slot>
    <div class="row layout-top-spacing">
        <div class="col-md-12 layout-spacing">
            <div class="widget widget-table-one">
                <div class="widget-heading">
                    <h5 class="">{{$title}}</h5>
                </div>
                <div class="widget-content">
                    <form id="form-data" method="POST" novalidate  enctype="multipart/form-data">
                        <div class="row mb-4">
                            <div class="form-group col-md-6">
                                <label for="biaya">Title</label>
                                <input type="text" class="form-control" name="title" value="{{$item->title}}" @if($item->title === null) readonly @endif required>
                                <div id="feedback-tahun" class=""></div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="form-group col-md-6">
                                <label for="file">File <i>*Format PDF</i></label>
                                <div class="multiple-file-upload">
                                    <input type="file"
                                        accept="application/pdf"
                                        class="filepond file-upload"
                                        name="file"
                                        id="product-images"
                                        data-allow-reorder="true"
                                        data-max-file-size="3MB"
                                        data-max-files="5">
                                </div>
                                <div id="feedback-file" class=""></div>
                            </div>
                        </div>
                        <a href="{{route('anggaran-dasar.index')}}" class="btn btn-danger">Kembali</a>
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
        <script>
            $(document).ready(function(){
                var btn = $('.btn-submit');
                var form = $('#form-data')

                FilePond.registerPlugin(
                    FilePondPluginFileValidateSize,
                    FilePondPluginFileValidateType,
                    // FilePondPluginImageEdit
                );

                var ecommerce = FilePond.create(document.querySelector('.file-upload'), {
                    storeAsFile: true,
                    @if($item['image_url'])
                    files: [
                        {
                            source: '{{$item['image_url']}}',
                        },
                    ],
                    @endif
                });

                form.on('submit', function(e){
                    e.preventDefault();
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    var formData = new FormData(form[0]);  // Menggunakan FormData untuk menangani file input

                    formData.append('_token', csrfToken);
                    formData.append('_method', 'PUT');  // Menambahkan _method untuk menentukan metode PUT

                    $.ajax({
                        type: 'POST', // Menggunakan POST karena metode PUT dihandle oleh _method
                        url: "{{ route('anggaran-dasar.update', $item->id) }}",
                        dataType: 'json',
                        data: formData,
                        contentType: false,
                        processData: false,
                        beforeSend: function(){
                            btn.html('<div class="spinner-border text-white me-2 align-self-center loader-sm "></div> Loading').attr('disabled', true)
                        },
                        success: function(res){
                            main.notification(res.message, NOTIFICATION_COLOR.SUCCESS)
                            window.location.href = "{{ route('anggaran-dasar.index') }}";
                        },
                        error: function(res){
                            var response = res.responseJSON;
                            btn.html('Simpan').attr('disabled', false)
                            main.notification(response.message, NOTIFICATION_COLOR.DANGER)
                            if(typeof res.responseJSON.errors === 'object'){
                                Object.keys(response.errors).map((i) => {
                                    var message = response.errors[i];
                                    $(`#feedback-${i}`).addClass('invalid-feedback').html(message)
                                })
                            }
                            form.addClass('was-validated')
                        },
                        complete: function(){
                            //...
                        }
                    });
                });
            });
        </script>
    </x-slot>
</x-base-layout>
