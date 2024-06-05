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
                    <form id="form-data" method="POST"   novalidate  enctype="multipart/form-data">

                        <div class="row mb-4">
                            <div class="col-sm-10">
                                <label>Pertanyaan</label>
                                <div id="editor-pertanyaan" value="{{$item->pertanyaan}}"></div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-sm-10">
                                <label>Jawaban</label>
                                <div id="editor-jawaban" value="{{$item->jawaban}}"></div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-sm-10">
                                <label>Tampilkan di Halaman Depan</label>
                                <br>
                                <input type="checkbox" name="is_displayed" value="0" value="{{$item->is_displayed}}" @if($item->is_displayed === 1) checked @endif >
                              
                            </div>
                        </div>
                       
                        <a href="{{route('pertanyaan.index')}}" class="btn btn-danger">Kembali</a>
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
            var textVisi = new Quill('#editor-pertanyaan', {
             modules: {},
            theme: 'snow'
         });
        textVisi.root.innerHTML = '{{$item->pertanyaan}}';

        var textMisi = new Quill('#editor-jawaban', {
         modules: {},
            theme: 'snow'
        });
        textMisi.root.innerHTML = '{{$item->jawaban}}';

    
    form.on('submit', function (e) {
    e.preventDefault();

    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    var formData = new FormData(form[0]);

        formData.append('_token', csrfToken);
        formData.append('_method', 'PUT'); 
        formData.append('pertanyaan', textVisi.root.innerText.trim());
        formData.append('jawaban', textMisi.root.innerText.trim());

                $.ajax({
                    type: 'POST',
                    url: "{{ route('pertanyaan.update', $item->id) }}",
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
                        window.location.href = "{{ route('pertanyaan.index') }}";
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