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

    <div class="mb-4 layout-spacing layout-top-spacing">
        <form id="form-data" method="POST" class="row">
            <div class="col-xxl-9 col-xl-12 col-lg-12 col-md-12 col-sm-12">

                <div class="widget widget-table-one position-relative">
                    <div class="widget-heading">
                        <h5 class="">{{$title}}</h5>
                        <div class="task-action">

                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="title" name="title" placeholder="Judul" value="{{$item['title']}}">
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-sm-12">
                            <label>Content</label>
                            <div id="editor-content">{!! $item['content'] !!}</div>
                        </div>
                    </div>

                </div>

            </div>

            <div class="col-xxl-3 col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-xxl-0 mt-4">
                <div class="widget">
                    <div class="row">
                        <div class="col-xxl-12 mb-4">
                            <div class="switch form-switch-custom switch-inline form-switch-primary">
                                <input class="switch-input" type="checkbox" role="switch" id="status" name="status" @if ($item['status'] == 'publish') checked @endif>
                                <label class="switch-label" for="status">Publish</label>
                            </div>
                        </div>
                        <div class="col-xxl-12 mb-4">
                            <div class="switch form-switch-custom switch-inline form-switch-primary">
                                <input class="switch-input" type="checkbox" role="switch" id="enableComment" name="enabled_comments" @if ($item['enabled_comments']) checked @endif>
                                <label class="switch-label" for="enableComment">Enable Comments</label>
                            </div>
                        </div>
                        <div class="col-xxl-12 col-md-12 mb-4">
                            <label for="tags">Tags</label>
                            <input id="tags" class="blog-tags" name="tags" value="{{$item['tags']}}">
                        </div>

                        <div class="col-xxl-12 col-md-12 mb-4">
                            <label for="category">Category</label>
                            <input id="category" name="kategori" value="{{$item['kategori']}}">
                        </div>

                        <div class="col-xxl-12 col-md-12 mb-4">

                            <label for="product-images">Featured Image</label>
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

                        </div>

                        <div class="col-xxl-12 col-sm-4 col-12 mx-auto">
                            <button class="btn btn-success btn-kirim w-100">Simpan</button>
                        </div>

                    </div>
                </div>
            </div>
        </form>


    </div>

    <x-slot name="footerFiles">
        <script src="{{asset('src/plugins/src/editors/quill/quill.js')}}"></script>
        <script src="{{asset('src/plugins/src/filepond/filepond.min.js')}}"></script>
        <script src="{{asset('src/plugins/src/filepond/FilePondPluginFileValidateType.min.js')}}"></script>
        <script src="{{asset('src/plugins/src/filepond/FilePondPluginImageExifOrientation.min.js')}}"></script>
        <script src="{{asset('src/plugins/src/filepond/FilePondPluginImagePreview.min.js')}}"></script>
        <script src="{{asset('src/plugins/src/filepond/FilePondPluginImageCrop.min.js')}}"></script>
        <script src="{{asset('src/plugins/src/filepond/FilePondPluginImageResize.min.js')}}"></script>
        <script src="{{asset('src/plugins/src/filepond/FilePondPluginImageTransform.min.js')}}"></script>
        <script src="{{asset('src/plugins/src/filepond/filepondPluginFileValidateSize.min.js')}}"></script>

        <script src="{{asset('src/plugins/src/tagify/tagify.min.js')}}"></script>
        <script>

            $(document).ready(function(){
                var textContent = new Quill('#editor-content', {
                    modules: {
                        // toolbar: '#toolbar'
                    },
                    theme: 'snow'
                })

                FilePond.registerPlugin(
                    FilePondPluginImagePreview,
                    FilePondPluginImageExifOrientation,
                    FilePondPluginFileValidateSize,
                    FilePondPluginFileValidateType,
                    // FilePondPluginImageEdit
                );

                var ecommerce = FilePond.create(document.querySelector('.file-upload'), {

                    storeAsFile: true,
                    @if($item['image_url'])
                    files: [
                        {
                            // the server file reference
                            source: '{{$item['image_url']}}',

                            // set type to limbo to tell FilePond this is a temp file
                            // options: {
                            //     type: 'image/png',
                            // },
                        },
                    ],
                    @endif
                });

                var inputTags = document.querySelector('input[name="tags"]');
                var inputKategori = document.querySelector('input[name="kategori"]');

                var fTags = new Tagify(inputTags);
                var fKategori = new Tagify(inputKategori);

                var form = $('#form-data');
                var inputTitle = $('input[name="title"]');
                var inputSlug = $('input[name="slug"]');
                var btnSubmit = $('.btn-kirim')
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                form.on('submit', function(e){
                    e.preventDefault();

                    var file_upload = $('input[name="image"]').prop('files')[0];
                    var status = $('input[name="status"]').is(':checked');
                    var enableComments = $('input[name="enabled_comments"]').is(':checked');
                    var formData = new FormData(form[0]);
                    formData.append('_token', '{{csrf_token()}}');
                    formData.append('_method', 'PUT');
                    formData.append('content', textContent.root.innerHTML);
                    formData.set('tags', getValueTags(inputTags.value));
                    formData.set('kategori', getValueTags(inputKategori.value));
                    formData.set('image', file_upload ? file_upload : '');
                    formData.set('status', status);
                    formData.set('enabled_comments', enableComments);
                    $.ajax({
                        type: 'POST',
                        enctype: 'multipart/form-data',
                        url: "{{route('cms.news.update', $item->pid)}}",
                        processData: false,
                        contentType: false,
                        data: formData,
                        beforeSend: function(){
                            btnSubmit.html('<div class="spinner-border text-white me-2 align-self-center loader-sm "></div> Loading').attr('disabled', true)
                        },
                        success: function(res){
                            main.notification(res.message, NOTIFICATION_COLOR.SUCCESS)
                            window.location.href = "{{route('cms.news.index')}}";
                            btnSubmit.html('Simpan').attr('disabled', false)
                        },
                        error: function(res){
                            var response = res.responseJSON;
                            btnSubmit.html('Simpan').attr('disabled', false)
                            main.notification(response.message, NOTIFICATION_COLOR.DANGER)
                            if(typeof res.responseJSON.errors === 'object'){
                                Object.keys(response.errors).map((i) => {
                                    var message = response.errors[i];
                                    $(`#feedback-${i}`).addClass('invalid-feedback').html(message)
                                })
                            }
                        },
                        done: function(){
                        }
                    })
                })

                function getValueTags(data){
                    if(data){
                        data = JSON.parse(data);
                        data = data.reduce((r, i, k) => {
                            r += k === 0 ? i.value : ',' + i.value;
                            return r;
                        }, '')
                        return data
                    }else{
                        return '';
                    }
                }
            });
        </script>
    </x-slot>
</x-base-layout>
