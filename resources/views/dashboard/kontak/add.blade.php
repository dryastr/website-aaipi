<x-base-layout :title="$title">
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
                     
                        <div class="row mb-4">
                            <div class="form-group col-md-6">
                                <label for="biaya">Title Card</label>
                                <input type="text" class="form-control" name="title" required>
                                <div id="feedback-name" class=""></div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="form-group col-md-6">
                                <label for="tahun">Deskripsi Card</label>
                                <input type="text" class="form-control" name="description" required>
                                <div id="feedback-description" class=""></div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="form-group col-md-6">
                                <label for="tahun">Icon</label>
                                <input type="text" class="form-control" name="icon" required>
                                <div id="feedback-description" class=""></div>
                            </div>
                            <p>Silahkan masukkan icon contoh : fas fa-map-marker-alt</p>
                        </div>
                        <div class="row mb-4">
                            <div class="form-group col-md-6">
                                <label for="kode">Kode</label>
                                <select class="form-control" name="kode" required>
                                    <option value="">Pilih kode</option>
                                    <option value="ALAMAT_KANTOR">ALAMAT KANTOR</option>
                                    <option value="HUBUNGI_KAMI">HUBUNGI KAMI</option>
                                    <option value="EMAIL_KAMI">EMAIL AKAMI</option>
                                    <option value="JAM_KERJA">JAM KERJA</option>
                                    <!-- Tambahkan opsi sesuai kebutuhan -->
                                </select>
                                <div id="feedback-description" class=""></div>
                            </div>
                        </div>
                        
                        @if ($title_content === null)
                        <div class="row mb-4">
                            <div class="form-group col-md-6">
                                <label for="title_content">Title Konten</label>
                                <input type="text" class="form-control" name="title_content"  required>
                                <div id="feedback-tahun" class=""></div>
                            </div>
                        </div>
                        @else
                        @endif
                       
                        @if ($content === null)     
                        <div class="row mb-4">
                            <div class="form-group col-md-6">
                                <label for="tahun">Konten</label>
                                <input type="text" class="form-control" name="content" required>
                                <div id="feedback-description" class=""></div>
                            </div>
                        </div>
                        @else
                        @endif
                        
                        @if ($image === null)
                        <div class="row mb-4">
                            <div class="form-group col-md-6">
                                <label for="image">Gambar Kontent</label>
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
   

    <script>
        $(document).ready(function () {
     var btn = $('.btn-submit');
     var form = $('#form-data');
 
     form.on('submit', function (e) {
         e.preventDefault();
 
         var csrfToken = $('meta[name="csrf-token"]').attr('content');
         var formData = new FormData(form[0]);  // Gunakan FormData untuk menangani file input
 
         formData.append('_token', csrfToken);
 
         $.ajax({
             type: 'POST',
             url: "{{ route('kontak.store') }}",
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
                 window.location.href = "{{ route('kontak.table') }}";
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
