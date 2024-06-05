<x-base-layout :title="$title">
    <div class="row layout-top-spacing">
        <div class="col-md-12 layout-spacing">
            <div class="widget widget-table-one">
                <div class="widget-heading">
                    <h5 class="">{{$title}}</h5>
                </div>
                <div class="widget-content">
                    <form id="form-data" method="POST" novalidate>
                        <div class="row mb-4">
                            <div class="form-group col-md-6">
                                <label for="jabatan">Jabatan</label>
                                <select class="form-control" name="jabatan" required>
                                    <option value="">Pilih</option>
                                 <option value="ketua">KETUA</option>
                                 <option value="manajemen-eksekutif">MANAJEMEN EKSEKUTIF</option>
                                <option value="komite-kode-etik">KOMITE KODE ETIK</option>
                                 <option value="komite-standar-audit">KOMITE STANDAR AUDIT</option>
                                 <option value="komite-telaah-sejawat">KOMITE TELAAH SEJAWAT</option>
                              
                    
                            </select>
                     <div id="feedback-description" class=""></div>
                            </div>
                        <!-- <div class="row mb-4">
                            <div class="form-group col-md-6">
                                <label for="tahun">tahun</label>
                                <input type="text" class="form-control" name="tahun" required>
                                <div id="feedback-description" class=""></div>
                            </div>
                        </div> -->
                        <div class="widget-content">
                            <div class="row mb-4">
                                <div class="form-group col-md-6">
                                    <label for="jabatan_title">Sebagai</label>
                                    <input type="text" class="form-control" name="jabatan_title" required>
                                    <div id="feedback-name" class=""></div>
                                </div>
                            </div>
                            <div class="widget-content">
                                <div class="row mb-4">
                                    <div class="form-group col-md-6">
                                        <label for="desc_jabatan">desc title</label>
                                        <input type="text" class="form-control" name="desc_jabatan" required>
                                        <div id="feedback-name" class=""></div>
                                    </div>
                                </div>
                        
                        <a href="{{route('CMS.struktur-organisasi.index')}}" class="btn btn-danger">Kembali</a>
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
    var form = $('#form-data');

    form.on('submit', function(e){
        e.preventDefault();
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        // Use FormData to handle file uploads
        var formData = new FormData(form[0]);
        formData.append('_method', 'PUT'); // Laravel expects PUT requests to have _method parameter

        $.ajax({
            type: 'POST', // Use POST method as most servers do not support PUT in AJAX requests
            url: "{{ route('CMS.struktur-organisasi.update', $item->id) }}",
            dataType: 'json',
            data: formData,
            contentType: false, // important for FormData
            processData: false, // important for FormData
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            beforeSend: function(){
                btn.html('<div class="spinner-border text-white me-2 align-self-center loader-sm "></div> Loading').attr('disabled', true);
            },
            success: function(res){
                main.notification(res.message, NOTIFICATION_COLOR.SUCCESS);
                window.location.href = "{{ route('CMS.struktur-organisasi.index') }}";
            },
            error: function(res){
                var response = res.responseJSON;
                btn.html('Simpan').attr('disabled', false);
                main.notification(response.message, NOTIFICATION_COLOR.DANGER);

                if(typeof res.responseJSON.errors === 'object'){
                    Object.keys(response.errors).map((i) => {
                        var message = response.errors[i];
                        $(`#feedback-${i}`).addClass('invalid-feedback').html(message);
                    });
                }

                form.addClass('was-validated');
            },
            complete: function(){
                // This callback will be called whether the request succeeds or fails
                // You can perform any additional actions here
            }
        });
    });
});
        </script>
    </x-slot>
</x-base-layout>
