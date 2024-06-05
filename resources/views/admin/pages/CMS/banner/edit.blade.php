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
                            <div class="col-sm-6">
                                <label for="type">Tampilan Banner</label>
                                <select class="form-select" id="type" name="type">
                                    @foreach($typeOptions as $value => $label)
                                        <option value="{{ $value }}" {{ $item->type == $value ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-sm-6" id="color-input-container" style="display: none;">
                                <label for="color">Warna Latar Belakang</label>
                                <div class="input-group">
                                    <input type="color" class="p-0" name="color_manual" id="color_manual" placeholder="Warna Latar Belakang" style="width: 49px; height: 49px; border: none" value="{{$item['color']}}">
                                    <input type="text" class="form-control" name="color" id="color" placeholder="Pilih Warna" value="{{$item['color']}}">
                                </div>
                                <div id="feedback-color" class=""></div>
                            </div>
                        </div>
                       
                        <div class="row mb-4">
                            <div class="col-sm-6">
                            <label for="title">Judul</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Judul"
                                value="{{$item['title']}}">
                                <div id="feedback-title" class=""></div>
                            </div>

                            <div class="col-sm-6">
                                <label for="link">Link</label>
                                <input type="text" class="form-control" name="link" placeholder="Link"  value="{{$item['link']}}">
                                <div id="feedback-tahun" class=""></div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-sm-5">
                                <label for="product-images">Gambar</label>
                                <div class="multiple-file-upload">
                                    <input type="file" accept="image/png, image/jpeg, image/gif"
                                        class="filepond file-upload" name="image" id="product-images"
                                        data-allow-reorder="true" data-max-file-size="3MB" data-max-files="5">
                                </div>
                                <div id="feedback-image" class=""></div>
                            </div>
                        </div>
                    
                        <div class="row mb-4">
                            <div class="col-sm-12">
                                <label>Deskripsi</label>
                                <textarea id="editor-desc"
                                    name="desc">{!! $item['desc'] ? $item['desc'] : '' !!}</textarea>
                                <div id="feedback-desc" class=""></div>
                            </div>
                        </div>

                        <a href="{{route('CMS.banner.index')}}" class="btn btn-danger">Kembali</a>
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

                var btn = $('.btn-submit');
                var form = $('#form-data');

                form.on('submit', function (e) {
                    e.preventDefault();

                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    var formData = new FormData(form[0]);

                    formData.append('_token', csrfToken);
                    formData.append('_method', 'PUT');
                    formData.append('desc', CKEDITOR.instances['editor-desc'].getData());

                    $.ajax({
                        type: 'POST',
                        url: "{{ route('CMS.banner.update', $item->id) }}",
                        dataType: 'json',
                        data: formData,
                        contentType: false,
                        processData: false,
                        beforeSend: function () {
                            btn.html(
                                    '<div class="spinner-border text-white me-2 align-self-center loader-sm "></div> Loading'
                                )
                                .attr('disabled', true);
                        },
                        success: function (res) {
                            main.notification(res.message, NOTIFICATION_COLOR.SUCCESS);
                            window.location.href = "{{ route('CMS.banner.index') }}";
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
        <script>
            const colorPicker = document.getElementById('color');
            const colorInput = document.getElementById('color_manual');
            
            function setColorManual(colorValue) {
                colorInput.value = colorValue;
            }

            colorInput.addEventListener('input', function(event) {
                colorPicker.value = event.target.value;
            });
        
            colorPicker.addEventListener('input', function(event) {
                colorInput.value = event.target.value;
            });
            
            colorInput.addEventListener('input', function(event) {
                setColorManual(event.target.value);
                
                colorPicker.value = event.target.value;
            });
            
            setColorManual(colorInput.value);
        </script>
        <script>
            const typeSelect = document.getElementById('type');
            const colorInputContainer = document.getElementById('color-input-container');
        
            function toggleColorInputVisibility() {
                if (typeSelect.value === 'quote') {
                    colorInputContainer.style.display = 'block';
                } else {
                    colorInputContainer.style.display = 'none';
                }
            }
        
            toggleColorInputVisibility();
        
            typeSelect.addEventListener('change', function(event) {
                toggleColorInputVisibility();
            });
        </script>
    </x-slot>

</x-base-layout>