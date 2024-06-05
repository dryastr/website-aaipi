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
                    <h6>{{$title_form}}</h6>
                    <br>
                    <div class="row mb-4">
                        <div class="form-group col-md-12">
                            <label for="facebook">Facebook</label>
                            <input type="text" class="form-control" name="facebook" placeholder="Msukkan Url Facebook" value="{{$item['facebook']}}">
                            <div id="feedback-facebook" class=""></div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="form-group col-md-12">
                            <label for="title">Twitter</label>
                            <input type="text" class="form-control" name="twitter" placeholder="Msukkan Url Twitter" value="{{$item['twitter']}}">
                            <div id="feedback-twitter" class=""></div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="form-group col-md-12">
                            <label for="title">Linkedin</label>
                            <input type="text" class="form-control" name="linkedin" placeholder="Msukkan Url Linkedin" value="{{$item['linkedin']}}">
                            <div id="feedback-linkedin" class=""></div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="form-group col-md-12">
                            <label for="title">Youtube</label>
                            <input type="text" class="form-control" name="youtube" placeholder="Msukkan Url Youtube" value="{{$item['youtube']}}">
                            <div id="feedback-youtube" class=""></div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="form-group col-md-12">
                            <label for="title">Instagram</label>
                            <input type="text" class="form-control" name="instagram" placeholder="Msukkan Url Instagram" value="{{$item['instagram']}}">
                            <div id="feedback-instagram" class=""></div>
                        </div>
                    </div>

                    <div class="col-xxl-12 col-sm-4 col-12 mx-auto">
                        <button class="btn btn-success btn-kirim ">Simpan</button>
                    </div>
                </div>

            </div>

            {{-- <div class="col-xxl-4 col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-xxl-0 mt-4"> --}}
                {{-- <div class="widget">
                    <div class="row">
                        <div class="row mb-4">
                            <div class="form-group col-md-12">
                                <label for="facebook">Facebook</label>
                                <input type="text" class="form-control" name="facebook" value="{{$item['facebook']}}">
                                <div id="feedback-facebook" class=""></div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="form-group col-md-12">
                                <label for="title">Twitter</label>
                                <input type="text" class="form-control" name="twitter" value="{{$item['twitter']}}">
                                <div id="feedback-twitter" class=""></div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="form-group col-md-12">
                                <label for="title">Linkedin</label>
                                <input type="text" class="form-control" name="linkedin" value="{{$item['linkedin']}}">
                                <div id="feedback-linkedin" class=""></div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="form-group col-md-12">
                                <label for="title">Youtube</label>
                                <input type="text" class="form-control" name="youtube" value="{{$item['youtube']}}">
                                <div id="feedback-youtube" class=""></div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="form-group col-md-12">
                                <label for="title">Instagram</label>
                                <input type="text" class="form-control" name="instagram" value="{{$item['instagram']}}">
                                <div id="feedback-instagram" class=""></div>
                            </div>
                        </div>

                        <div class="col-xxl-12 col-sm-4 col-12 mx-auto">
                            <button class="btn btn-success btn-kirim w-100">Simpan</button>
                        </div>

                    </div>
                </div>
            </div> --}}
        </form>


    </div>

    <x-slot name="footerFiles">
        <script src="{{asset('src/plugins/src/editors/quill/quill.js')}}"></script> 
        <script>
            $(document).ready(function () {
         var btn = $('.btn-submit');
         var form = $('#form-data');
     
         form.on('submit', function (e) {
             e.preventDefault();
     
             var csrfToken = $('meta[name="csrf-token"]').attr('content');
             var formData = new FormData(form[0]);  // Gunakan FormData untuk menangani file input
     
             formData.append('_token', csrfToken);
            //  formData.append('pertanyaan', textPertanyaan.root.innerText.trim());
            //  formData.append('jawaban', textJawaban.root.innerText.trim());

     
             $.ajax({
                 type: 'POST',
                 url: "{{ route('cms.media-social.actions') }}",
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
                     window.location.href = "{{ route('cms.media-social.index') }}";
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
