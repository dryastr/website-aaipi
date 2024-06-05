<x-base-layout :title="$title">
    <div class="row layout-top-spacing">
        <div class="col-md-12 layout-spacing">
            <div class="widget widget-table-one">
                <div class="widget-heading">
                    <h5 class="">{{$title}}</h5>
                </div>
                <div class="widget-content">
                    <form id="form-data" method="POST" novalidate>
                        @if($item->title_banner != null)
                        <div class="row mb-4">
                            <div class="form-group col-md-6">
                                <label for="biaya">Title</label>
                                <input type="text" class="form-control" name="title_banner" value="{{$item->title_banner}}"  required>
                                <div id="feedback-tahun" class=""></div>
                            </div>
                        </div>
                        @else
                        @endif
                        @if($item->image_banner != null)
                        <div class="row mb-4">
                            <div class="form-group col-md-6">
                                <label for="biaya">Title</label>
                                <input type="file" class="form-control" name="image_banner" value="{{$item->image_banner}}"  required>
                                <div id="feedback-tahun" class=""></div>
                            </div>
                        </div>
                        @else
                        @endif
                        @if($item->title != null)
                        <div class="row mb-4">
                            <div class="form-group col-md-6">
                                <label for="biaya">Title</label>
                                <input type="text" class="form-control" name="title" value="{{$item->title}}"  required>
                                <div id="feedback-tahun" class=""></div>
                            </div>
                        </div>
                        @else
                        @endif

                        @if($item->description != null)  
                        <div class="row mb-4">
                            <div class="form-group col-md-6">
                                <label for="tahun">Descripsi</label>
                                <input type="text" class="form-control" name="description" value="{{$item->description}}" required>
                                <div id="feedback-tahun" class=""></div>
                            </div>
                        </div>
                        @else
                        @endif
                    
                        @if($item->image != null)
                        <div class="row mb-4">
                            <div class="form-group col-md-6">
                                <label for="image">Gambar</label>
                                <input type="file" class="form-control" name="image" accept="image/*"  required>
                                <div id="feedback-image" class=""></div>
                            </div>
                        </div>
                        @else
                        @endif
                        <a href="{{route('about-history.index')}}" class="btn btn-danger">Kembali</a>
                        <button type="submit" class="btn btn-primary btn-submit">Simpan</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <x-slot name="footerFiles">
    
        <script>
            $(document).ready(function(){
              var btn = $('.btn-submit');
              var form = $('#form-data')
              
              form.on('submit', function(e){
                  e.preventDefault();
                  var csrfToken = $('meta[name="csrf-token"]').attr('content');
                  var formData = new FormData(form[0]);  // Menggunakan FormData untuk menangani file input
          
                  formData.append('_token', csrfToken);
                  formData.append('_method', 'PUT');  // Menambahkan _method untuk menentukan metode PUT
          
                  $.ajax({
                      type: 'POST', // Menggunakan POST karena metode PUT dihandle oleh _method
                      url: "{{ route('about-history.update', $item->id) }}",
                      dataType: 'json',
                      data: formData,
                      contentType: false,
                      processData: false,
                      beforeSend: function(){
                          btn.html('<div class="spinner-border text-white me-2 align-self-center loader-sm "></div> Loading').attr('disabled', true)
                      },
                      success: function(res){
                          main.notification(res.message, NOTIFICATION_COLOR.SUCCESS)
                          window.location.href = "{{ route('about-history.index') }}";
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
        {{-- <script>

            $(document).ready(function(){
                var btn = $('.btn-submit');
                var form = $('#form-data')
                form.on('submit', function(e){
                    e.preventDefault();
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    var formData = form.serializeArray();
                    formData.push({name: '_token', value: csrfToken})
                    $.ajax({
                        type: 'PUT',
                        url: "{{route('about-history.update', $item->id)}}",
                        dataType: 'json',
                        data: formData,
                        beforeSend: function(){
                            btn.html('<div class="spinner-border text-white me-2 align-self-center loader-sm "></div> Loading').attr('disabled', true)
                        },
                        success: function(res){
                            main.notification(res.message, NOTIFICATION_COLOR.SUCCESS)
                            window.location.href = "{{route('about-history.index')}}";
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
                        done: function(){
                        }
                    })
                })
            });
    
            // $(document).ready(function(){
            //     var btn = $('.btn-submit');
            //     var form = $('#form-data')
            //     form.on('submit', function(e){
            //         e.preventDefault();
            //         var csrfToken = $('meta[name="csrf-token"]').attr('content');
            //         var formData = form.serializeArray();
            //         formData.push({name: '_token', value: csrfToken})
            //         $.ajax({
            //             type: 'PUT',
            //             url: "{{route('program-kerja.update', $item->id)}}",
            //             dataType: 'json',
            //             data: formData,
            //             beforeSend: function(){
            //                 btn.html('<div class="spinner-border text-white me-2 align-self-center loader-sm "></div> Loading').attr('disabled', true)
            //             },
            //             success: function(res){
            //                 main.notification(res.message, NOTIFICATION_COLOR.SUCCESS)
            //                 window.location.href = "{{route('program-kerja.index')}}";
            //             },
            //             error: function(res){
            //                 var response = res.responseJSON;
            //                 btn.html('Simpan').attr('disabled', false)
            //                 main.notification(response.message, NOTIFICATION_COLOR.DANGER)
            //                 if(typeof res.responseJSON.errors === 'object'){
            //                     Object.keys(response.errors).map((i) => {
            //                         var message = response.errors[i];
            //                         $(`#feedback-${i}`).addClass('invalid-feedback').html(message)
            //                     })
            //                 }
            //                 form.addClass('was-validated')
            //             },
            //             done: function(){
            //             }
            //         })
            //     })
            // });
        </script> --}}
    </x-slot>
</x-base-layout>
