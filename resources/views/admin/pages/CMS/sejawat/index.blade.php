<x-base-layout :title="$title">
    <x-slot name="headerFiles">
        <link rel="stylesheet" href="{{asset('src/plugins/src/filepond/filepond.min.css')}}">
        <link rel="stylesheet" href="{{asset('src/plugins/src/filepond/FilePondPluginImagePreview.min.css')}}">
        <link href="{{asset('src/plugins/css/light/filepond/custom-filepond.css')}}" rel="stylesheet" type="text/css" />

        <link rel="stylesheet" href="{{asset('src/assets/css/light/apps/blog-create.css')}}">
        <script src="{{asset('assets/ckeditor/ckeditor.js')}}"></script>
    </x-slot>

    <div class="mb-4 layout-spacing layout-top-spacing">
        <form id="form-data" method="POST" class="row">
            <div class="col-xxl-8 col-xl-12 col-lg-12 col-md-12 col-sm-12">

                <div class="widget widget-table-one position-relative">
                    <div class="widget-heading">
                        <h5 class="">{{$title}}</h5>
                        <div class="task-action">

                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="title" name="title" placeholder="Judul" value="{{$item['title']}}">
                            <div id="feedback-title" class=""></div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-sm-4">
                            <label for="product-images">Image</label>
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
                        <div class="col-sm-12">
                            <label>Deskripsi</label>
                            <textarea id="editor-content" name="content">{!! $item['content'] ? $item['content'] : '' !!}</textarea>
                            <div id="feedback-content" class=""></div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-sm-6">
                            <label>Title Link</label>
                            <input type="text" class="form-control" id="link_title" name="link_title" placeholder="Link Aplikasi" value="{{$item['link_title']}}">
                            <div id="feedback-link_title" class=""></div>
                        </div>
                        <div class="col-sm-6">
                            <label>Link Aplikasi</label>
                            <input type="text" class="form-control" id="link" name="link" placeholder="Link Aplikasi" value="{{$item['link_app']}}">
                            <div id="feedback-link" class=""></div>
                        </div>

                        <div class="col-xxl-2 col-sm-2 col-2 mt-3">
                            <button class="btn btn-success btn-kirim">Simpan</button>
                        </div>
                    </div>
                </div>
                <br>
            </div>

        </form>


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
                var textContent = CKEDITOR.replace('editor-content', {
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
                    removeButtons: 'About,Save,NewPage,ExportPdf,Preview,Print,Smiley,Iframe,Form,Checkbox,Radio,TextField,Textarea,Select,HiddenField,Find,SelectAll,Scayt,Replace,Language,PasteFromWord',
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
                    @if($item['image_url'])
                    files: [
                        {
                            source: '{{$item['image_url']}}',
                        },
                    ],
                    @endif
                });

                var form = $('#form-data');
                var btnSubmit = $('.btn-kirim')
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                form.on('submit', function(e){
                    e.preventDefault();

                    var file_upload = $('input[name="image"]').prop('files')[0];
                    var status = $('input[name="status"]').is(':checked');
                    var enableComments = $('input[name="enabled_comments"]').is(':checked');
                    var formData = new FormData(form[0]);
                    formData.append('_token', csrfToken);
                    formData.append('content', CKEDITOR.instances['editor-content'].getData());
                    formData.set('image', file_upload ? file_upload : '');
                    $.ajax({
                        type: 'POST',
                        enctype: 'multipart/form-data',
                        url: "{{route('cms.sejawat.actions')}}",
                        processData: false,
                        contentType: false,
                        data: formData,
                        beforeSend: function(){
                            btnSubmit.html('<div class="spinner-border text-white me-2 align-self-center loader-sm "></div> Loading').attr('disabled', true)
                            $('.invalid-feedback').removeClass('invalid-feedback d-block').html('')
                            for (instance in CKEDITOR.instances) {CKEDITOR.instances[instance].updateElement()}
                        },
                        success: function(res){
                            main.notification(res.message, NOTIFICATION_COLOR.SUCCESS)
                            window.location.href = "{{route('cms.sejawat.index')}}";
                            btnSubmit.html('Simpan').attr('disabled', false)
                        },
                        error: function(res){
                            var response = res.responseJSON;
                            btnSubmit.html('Simpan').attr('disabled', false)
                            main.notification(response.message, NOTIFICATION_COLOR.DANGER)
                            if(typeof res.responseJSON.errors === 'object'){
                                Object.keys(response.errors).map((i) => {
                                    var message = response.errors[i];
                                    $(`#feedback-${i}`).addClass('invalid-feedback d-block').html(message)
                                })
                            }
                        },
                        done: function(){
                        }
                    })
                })
            });
        </script>
    </x-slot>
</x-base-layout>
