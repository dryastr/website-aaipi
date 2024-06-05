<x-base-layout :title="$title">
    <x-slot name="headerFiles">
        
        <link rel="stylesheet" type="text/css" href="{{asset('src/plugins/css/light/editors/quill/quill.snow.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('src/plugins/css/light/tagify/custom-tagify.css')}}">
        

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
                                <label for="title_banner">Title Banner</label>
                                <input type="text" class="form-control" name="title_banner" value="{{$item->title_banner}}"required>
                                <div id="feedback-name" class=""></div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="form-group col-md-6">
                                <label for="conten_tentang">Description</label>
                                <textarea class="form-control" name="conten_tentang" required>{{$item->conten_tentang}}</textarea>
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
                                    <div id="editor-visi" value="{{$item->visi}}"></div>
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
                                    <div id="editor-misi" value="{{$item->misi}}"></div>
                                </div>
                            </div>
                        <div class="row mb-4">
                            <div class="form-group col-md-6">
                                <label for="Banner">Banner</label>
                                <input type="file" class="form-control" name="banner" required>
                                <div id="feedback-name" class=""></div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="form-group col-md-6">
                                <label for="image">Image</label>
                                <input type="file" class="form-control" name="image" required>
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
    <script src="{{asset('src/plugins/src/editors/quill/quill.js')}}"></script>
    <script>
       $(document).ready(function () {
            var btn = $('.btn-submit');
            var form = $('#form-data');
            var textVisi = new Quill('#editor-visi', {
             modules: {},
            theme: 'snow'
         });
        textVisi.root.innerText = '{{$item->visi}}';

        var textMisi = new Quill('#editor-misi', {
         modules: {},
            theme: 'snow'
        });
        textMisi.root.innerText = '{{$item->misi}}';

    
    form.on('submit', function (e) {
    e.preventDefault();

    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    var formData = new FormData(form[0]);

    formData.append('_token', csrfToken);
    formData.append('_method', 'PUT'); 
    formData.append('visi', textVisi.root.innerText.trim());
    formData.append('misi', textMisi.root.innerText.trim());

    // Check if files are selected before appending them
    var bannerFile = $('input[name="banner"]').prop('files')[0];
    if (bannerFile) {
        formData.append('banner', bannerFile);
    }

    var imageFile = $('input[name="image"]').prop('files')[0];
    if (imageFile) {
        formData.append('image', imageFile);
    }

    $.ajax({
                    type: 'POST',
                    url: "{{ route('CMS.visi-misi.update', $item->id) }}",
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