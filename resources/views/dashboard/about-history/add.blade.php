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
                        @if ($title_banner === null)
                        <div class="row mb-4">
                            <div class="form-group col-md-6">
                                <label for="biaya">Title Banner</label>
                                <input type="text" class="form-control" name="title_banner" required>
                                <div id="feedback-name" class=""></div>
                            </div>
                        </div>
                        @else
                        @endif
                      
                       @if($image_banner === null)
                       <div class="row mb-4">
                            <div class="form-group col-md-6">
                                <label for="image">Gambar Banner</label>
                                <input type="file" class="form-control" name="image_banner" accept="image/*" required>
                                <div id="feedback-image" class=""></div>
                            </div>
                        </div>
                        @else
                        @endif

                        @if($title_content === null)
                        <div class="row mb-4">
                            <div class="form-group col-md-6">
                                <label for="biaya">Title</label>
                                <input type="text" class="form-control" name="title" required>
                                <div id="feedback-name" class=""></div>
                            </div>
                        </div>
                        @else
                        @endif
                     
                        @if($description === null)
                        <div class="row mb-4">
                            {{-- <div class="form-group col-md-6">
                                <label for="biaya">Deskripsi</label>
                                <input type="text" class="form-control" name="description" required>
                                <div id="feedback-name" class=""></div>
                            </div>
                        </div> --}}
                        <div class="widget-content">
                            <div class="row mb-4">
                                <div class="col-sm-10">
                                    <label>Deskripsi</label>
                                    <div id="editor-description"></div>
                                </div>
                            </div>
                            </div>
                        </div>
                        @else
                        @endif
                        
                        @if ($image === null)
                        <div class="row mb-4">
                            <div class="form-group col-md-6">
                                <label for="image">Gambar </label>
                                <input type="file" class="form-control" name="image" accept="image/*" required>
                                <div id="feedback-image" class=""></div>
                            </div>
                        </div>
                        @else
                        @endif

                
                     
                           <a href="{{route('kontak.table')}}" class="btn btn-danger">Kembali</a>
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
     var textDescription = new Quill('#editor-description', {
                    modules: {
                        // toolbar: '#toolbar'
                    },
                    theme: 'snow'
                })
     form.on('submit', function (e) {
         e.preventDefault();
 
         var csrfToken = $('meta[name="csrf-token"]').attr('content');
         var formData = new FormData(form[0]);  // Gunakan FormData untuk menangani file input
 
         formData.append('_token', csrfToken);
         formData.append('description', textDescription.root.innerText.trim());
 
         $.ajax({
             type: 'POST',
             url: "{{ route('about-history.store') }}",
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
                 window.location.href = "{{ route('about-history.index') }}";
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
