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
                                <label for="biaya">Title Banner</label>
                                <input type="text" class="form-control" name="title_banner" value="{{$item->title_banner}}" required>
                                <div id="feedback-name" class=""></div>
                            </div>
                        </div>
                        @else
                        @endif
                        @if($item->image_banner != null)
                        <div class="row mb-4">
                            <div class="form-group col-md-6">
                                <label for="image">Gambar Banner</label>
                                <input type="file" class="form-control" name="image_banner" value="{{$item->image_banner}}"  accept="image/*" required>
                                <div id="feedback-image" class=""></div>
                            </div>
                        </div>
                        @else
                        @endif
                        <div class="row mb-4">
                            <div class="form-group col-md-6">
                                <label for="biaya">Title Card</label>
                                <input type="text" class="form-control" name="title" value="{{$item->title}}" @if($item->title === null) readonly @endif required>
                                <div id="feedback-tahun" class=""></div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="form-group col-md-6">
                                <label for="tahun">Deskripsi Card</label>
                                <input type="text" class="form-control" name="description" value="{{$item->description}}" @if($item->description === null) readonly @endif required>
                                <div id="feedback-tahun" class=""></div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="form-group col-md-6">
                                <label for="tahun">Icon</label>
                                <input type="text" class="form-control" name="icon" value="{{$item->icon}}" @if($item->icon === null) readonly @endif required>
                                <div id="feedback-description" class=""></div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="form-group col-md-6">
                                <label for="kode">Kode</label>
                                <select class="form-control" name="kode" required>
                                    <option value="">Pilih kode</option>
                                    <option value="ALAMAT_KANTOR" @if($item->kode === 'ALAMAT_KANTOR') selected @endif>ALAMAT KANTOR</option>
                                    <option value="HUBUNGI_KAMI" @if($item->kode === 'HUBUNGI_KAMI') selected @endif>HUBUNGI KAMI</option>
                                    <option value="EMAIL_KAMI" @if($item->kode === 'EMAIL_KAMI') selected @endif>EMAIL AKAMI</option>
                                    <option value="JAM_KERJA" @if($item->kode === 'JAM_KERJA') selected @endif>JAM KERJA</option>
                                    <!-- Tambahkan opsi sesuai kebutuhan -->
                                </select>
                                <div id="feedback-description" class=""></div>
                            </div>
                        </div>
                        @if($item->title_content != null)
                        <div class="row mb-4">
                            <div class="form-group col-md-6">
                                <label for="tahun">Title Konten</label>
                                <input type="text" class="form-control" name="title_content" value="{{$item->title_content}}"   required>
                                <div id="feedback-tahun" class=""></div>
                            </div>
                        </div>
                        @else
                        @endif
                        @if($item->content != null)
                        <div class="row mb-4">
                            <div class="form-group col-md-6">
                                <label for="tahun">Konten</label>
                                <input type="text" class="form-control" name="content" value="{{$item->content}}"  required>
                                <div id="feedback-description" class=""></div>
                            </div>
                        </div>
                        @else
                        @endif
                        @if($item->image != null)
                        <div class="row mb-4">
                            <div class="form-group col-md-6">
                                <label for="image">Gambar</label>
                                <input type="file" class="form-control" name="image" value="{{$item->image}}"  accept="image/*" required>
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
            url: "{{ route('kontak.update', $item->id) }}",
            dataType: 'json',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function(){
                btn.html('<div class="spinner-border text-white me-2 align-self-center loader-sm "></div> Loading').attr('disabled', true)
            },
            success: function(res){
                main.notification(res.message, NOTIFICATION_COLOR.SUCCESS)
                window.location.href = "{{ route('kontak.table') }}";
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
                        url: "{{route('kontak.update', $item->id)}}",
                        dataType: 'json',
                        data: formData,
                        beforeSend: function(){
                            btn.html('<div class="spinner-border text-white me-2 align-self-center loader-sm "></div> Loading').attr('disabled', true)
                        },
                        success: function(res){
                            main.notification(res.message, NOTIFICATION_COLOR.SUCCESS)
                            window.location.href = "{{route('kontak.index')}}";
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
        </script> --}}
    </x-slot>
</x-base-layout>
