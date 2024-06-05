<x-base-layout :title="$title">
    <x-slot name="headerFiles">
        <link rel="stylesheet" href="{{asset('src/orgchart/css/jquery.orgchart.css')}}">
        <link rel="stylesheet" href="{{asset('src/plugins/src/filepond/filepond.min.css')}}">
        <link rel="stylesheet" href="{{asset('src/plugins/src/filepond/FilePondPluginImagePreview.min.css')}}">
        <link href="{{asset('src/plugins/css/light/filepond/custom-filepond.css')}}" rel="stylesheet" type="text/css" />

        <link rel="stylesheet" href="{{asset('src/assets/css/light/apps/blog-create.css')}}">
        <script src="{{asset('assets/ckeditor/ckeditor.js')}}"></script>
        <style>
            #chart-container {
                font-family: Arial;
                height: 420px;
                border: 2px dashed #aaa;
                border-radius: 5px;
                overflow: auto;
                text-align: center;
            }
            .orgchart .node .content, .orgchart .node .title{
                white-space: normal;
                height: auto;
                width: auto;
                min-width: 130px;
                padding-left: 10px;
                padding-right: 10px;
            }

            #chart-container .orgchart .node .content .title img {
    width: 50px;
    height: 50px;
}
        </style>
    </x-slot>
    <div class="row layout-top-spacing">
        <div class="col-md-12 layout-spacing">
            <form id="form-data" method="POST" class="row">
                <div class="widget widget-table-one">
                    <div class="widget-heading">
                        <h5 class="">{{$title}}</h5>
                    </div>
                    <!-- <div class="widget-content">
                        <div class="row mb-4">
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="title" name="title" placeholder="Judul" value="{{$item['title']}}">
                                <div id="feedback-title" class=""></div>
                            </div>
                        </div>
                        <div id="chart-container"></div>
                    </div> -->
                    <div class="row mb-4">
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="title" name="title" placeholder="Judul" value="{{$item['title']}}">
                                <div id="feedback-title" class=""></div>
                            </div>
                        </div>
                    <div class="row mb-4">
                        <div class="col-sm-12">
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
                    <div class="task-action">
                                <button class="btn btn-success btn-kirim">Simpan</button>
                            </div>
                </div>

            </form>

        </div>
    </div>
    <x-slot name="footerFiles">
        <script type="text/javascript" src="{{asset('src/orgchart/js/jquery.orgchart.js')}}"></script>
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

                // @if($item['content'])
                // var datascource = JSON.parse({!!json_encode($item['content'])!!});
                // @else
                // var datascource = {
                //     name: 'Nama',
                //     title: 'Jabatan'
                // };
                // @endif

                // var oc = $('#chart-container').orgchart({
                //     'data' : datascource,
                //     'nodeContent': 'title',
                //     'pan': true,
                //     'zoom': true,
                //     'showControls': true,
                //     'parentNodeSymbol': '',
                //     'includeNodeData': true,
                //     'createNode': function($node, data) {
                //         $node.children('.title').html(`<p contenteditable="true" class="text-white text-name">${data.name}</p>`)
                //         $node.children('.content').html(`
                //             <div class="d-flex align-items-center">
                //                 <img src="/assets/img/logo/aaip-logo.png" class="rounded-circle avatar-small mr-15" style="width: 50px; height: 50px;" alt="Employee Image">
                //                 <div contenteditable="true" class="text-content">${data.title}</div>
                //             </div>                 
                //             <div class="p-1">
                //                 <a href="javascript:void(0);" class="text-success btn-add-node"><i class="fa fa-plus-circle"></i></a>
                //                 ${data.level > 1 ? '<a href="javascript:void(0);" class="text-danger btn-remove-node"><i class="fa fa-minus-circle"></i></a>' : ''}
                //             </div>
                //         `)

                //     },
                // });
                // $('.orgchart').addClass('noncollapsable');

                // oc.$chartContainer.on('click', '.btn-add-node', function(event){
                //     var $node = $(event.target).parent().parent().parent().parent();
                //     if (!$node.siblings('.nodes').length) {
                //         var rel = '100';
                //         oc.addChildren($node, [{ 'name': 'name', 'title': 'title', 'relationship': '100' }]);
                //     } else {
                //         oc.addSiblings($node.siblings('.nodes').find('.node:first'), [{ 'name': 'name', 'title': 'title', 'relationship': '110' }]);
                //     }
                // })

                // oc.$chartContainer.on('click', '.btn-remove-node', function(event){
                //     var $node = $(event.target).parent().parent().parent().parent();
                //     oc.removeNodes($node);
                // })

                // $('.btn-save').on('click', function(){
                //     var $chart = oc.$chart
                //     let a = loopD($chart);
                //     console.log(JSON.stringify(a));
                // })

                // function loopD($chart){
                //     var $node = $chart.find('.node:first');
                //     var textName = $node.find('.text-name').html();
                //     var textContent = $node.find('.text-content').html();
                //     var subObj = {
                //         name: textName,
                //         title: textContent
                //     };
                //     // $.each($node.data('nodeData'), function(k, v){
                //     //     subObj[k] = v;
                //     // })
                //     $node.siblings('.nodes').children().each(function() {
                //         if (!subObj.children) { subObj.children = []; }
                //             subObj.children.push(loopD($(this)));

                //     });

                //     return subObj;
                // }

                var form = $('#form-data');
                var btnSubmit = $('.btn-kirim')
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                form.on('submit', function(e){
                    e.preventDefault();

                    var file_upload = $('input[name="image"]').prop('files')[0];
                    // var $chart = oc.$chart
                    // let contentO = loopD($chart);
                    var formData = new FormData(form[0]);
                    formData.append('_token', csrfToken);
                    // formData.append('content', JSON.stringify(contentO));
                    formData.set('image', file_upload ? file_upload : '');

                    $.ajax({
                        type: 'POST',
                        enctype: 'multipart/form-data',
                        url: "{{route('CMS.struktur-organisasi.actions')}}",
                        processData: false,
                        contentType: false,
                        data: formData,
                        beforeSend: function(){
                            btnSubmit.html('<div class="spinner-border text-white me-2 align-self-center loader-sm "></div> Loading').attr('disabled', true)
                            $('.invalid-feedback').removeClass('invalid-feedback d-block').html('')
                        },
                        success: function(res){
                            main.notification(res.message, NOTIFICATION_COLOR.SUCCESS)
                            window.location.href = "{{route('CMS.struktur-organisasi.index')}}";
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
