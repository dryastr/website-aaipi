<x-base-layout :title="$title">
    <x-slot name="headerFiles">
        <link rel="stylesheet" href="{{asset('src/plugins/src/filepond/filepond.min.css')}}">
        <link rel="stylesheet" href="{{asset('src/plugins/src/filepond/FilePondPluginImagePreview.min.css')}}">
        <link href="{{asset('src/plugins/css/light/filepond/custom-filepond.css')}}" rel="stylesheet" type="text/css" />

        <link rel="stylesheet" href="{{asset('src/assets/css/light/apps/blog-create.css')}}">
        <script src="{{asset('assets/ckeditor/ckeditor.js')}}"></script>
    </x-slot>

    <div class="mb-4 layout-spacing layout-top-spacing">
        <form id="form-data" method="POST">
            <div class="widget widget-table-one position-relative">
                <div class="row">
                    <div class="col-md-6">
                        <div class="widget-heading">
                            <h5 class="">{{$title}}</h5>
                            <div class="task-action">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="title" name="title" placeholder="Judul"
                                    value="{{$item['title']}}">
                                <div id="feedback-title" class=""></div>
                            </div>
                        </div>

                        <div class="row mb-12">
                            <div class="col-sm-10">
                                <label for="product-images">Image</label>
                                <div class="multiple-file-upload">
                                    <input type="file" accept="image/png, image/jpeg, image/gif"
                                        class="filepond file-upload" name="image" id="product-images"
                                        data-allow-reorder="true" data-max-file-size="3MB" data-max-files="5">
                                </div>
                                <div id="feedback-image" class=""></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row mb-4">
                            <div class="col-sm-12">
                                <label>Deskripsi</label>
                                <textarea id="editor-content"
                                    name="content">{!! $item['content'] ? $item['content'] : '' !!}</textarea>
                                <div id="feedback-content" class=""></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-2 col-sm-2 col-2 mt-3">
                    <button class="btn btn-success btn-kirim w-100">Simpan</button>
                </div>
            </div>
        </form>

        <div class="col-md-12 mt-5">
            <div class="widget">
                <div class="task-action mb-3">

                    <a href="{{route('program-kerja.create')}}" class="btn btn-primary"><i class="fas fa-plus"></i>
                        Tambah</a>

                </div>
                <div class="widget-content">
                    <div class="table-responsive">
                        <table id="table-data" class="table table-bordered table-striped dt-table-hover"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>Judul Program</th>
                                    <th>Deskripsi Program</th>
                                    <th>Options</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
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

    <script src="{{asset('assets/ckeditor/ckeditor.js')}}"></script>
    <script>
        $(document).ready(function () {
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
                    url: "{{route('cms.program-kerja.actions')}}",
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
                        window.location.href = "{{route('cms.program-kerja.indexNew')}}";
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

            $('#table-data').DataTable({
                processing: true,
                serverSide: true,
                info: true,
                fnServerData: function (sSource, aoData, fnCallback, oSettings) {
                    var page = this.api().page.info().page;
                    let data = aoData.reduce((r, i) => {
                        r[i.name] = i.value
                        return r
                    }, {})
                    data['page'] = page + 1
                    oSettings.jqXHR = $.ajax({
                        url: "{{route('program-kerja.view')}}",
                        data: data,
                        success: fnCallback,
                    });
                },
                order: [],
                columns: [{
                        data: null,
                        render: function (data, type, row, meta) {
                            return meta.row + 1
                        },
                        visible: true,
                        orderable: false,
                        searchable: false,
                        width: '30px'
                    },
                    {data: 'title'},
                    {
                        data: null,
                        render: function (data, type, row, meta) {
                            return data.image_url ?
                                `<img src="${data.image_url}" width="50"/>` : '-'
                        },
                    },
                    {
                        data: null,
                        render: function (data, type, row, meta) {
                            var idDropdown = "tableDropdown-" + data.id
                            var linkEdit = "{{route('program-kerja.edit', ':id')}}".replace(
                                ':id', data.id);
                            var linkDelete = "{{route('program-kerja.delete', ':id')}}"
                                .replace(':id', data.id);
                            var html =
                                `
                                    <div class="d-inline-flex">
                                        <button type="button" class="btn btn-light btn-sm dropdown-toggle dropdown-toggle-split" id="` +
                                idDropdown + `" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-reference="parent">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="` + idDropdown + `">
                                            @can('program-kerja.edit')<a class="dropdown-item" href="${linkEdit}">Edit</a>@endcan
                                            @can('program-kerja.delete')<button class="dropdown-item" onClick="main.confirmDelete('${linkDelete}', '#table-data')">Hapus</button>@endcan
                                        </div>
                                    </div>
                                    `;
                            return html
                        },
                        visible: true,
                        orderable: false,
                        searchable: false,
                        width: '60px'
                    }
                ],
                dom: "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
                    "<'table-responsive'tr>" +
                    "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
                oLanguage: {
                    "oPaginate": {
                        "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                        "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                    },
                    "sInfo": "Showing page _PAGE_ of _PAGES_",
                    "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                    "sSearchPlaceholder": "Search...",
                    sLengthMenu: "Results :  _MENU_",
                },
                stripeClasses: [],
                lengthMenu: [5, 10, 20, 50],
                pageLength: 5
            });
        });
    </script>
</x-slot>

</x-base-layout>
