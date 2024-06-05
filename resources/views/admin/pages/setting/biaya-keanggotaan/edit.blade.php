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
                                <label for="biaya">biaya</label>
                                <input type="text" class="form-control" name="biaya" value="{{$item->biaya}}" required>
                                <div id="feedback-tahun" class=""></div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="form-group col-md-6">
                                <label for="tahun">tahun</label>
                                <input type="text" class="form-control" name="tahun" value="{{$item->tahun}}" required>
                                <div id="feedback-tahun" class=""></div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="form-group col-md-6">
                                <label for="status">Status</label>
                                <select class="form-control" name="status"  required>
                                    <option value="" disabled>Pilih</option>
                                    <option value="active" {{ $item->status == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ $item->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                <div id="feedback-status" class=""></div>
                            </div>
                        </div>
                        

                        <div class="row mb-4">
                            <div class="form-group col-md-6">
                                <label for="jenis_keanggotaan">Jenis Keanggotaan</label>
                                <select class="form-control" name="jenis_keanggotaan" required>
                                    <option value="" disabled>Pilih</option>
                                    <option value="anggota-biasa" {{ $item->jenis_keanggotaan == 'anggota-biasa' ? 'selected' : '' }}>Anggota Biasa</option>
                                    <option value="anggota-luar-biasa" {{ $item->jenis_keanggotaan == 'anggota-luar-biasa' ? 'selected' : '' }}>Anggota Luar Biasa</option>
                                    <option value="anggota-kehormatan" {{ $item->jenis_keanggotaan == 'anggota-kehormatan' ? 'selected' : '' }}>Anggota Kehormatan</option>
                                </select>
                                <div id="feedback-jenis_keanggotaan" class=""></div>
                            </div>
                        </div>
                        
                        <a href="{{route('setting.biaya-keanggotaan.index')}}" class="btn btn-danger">Kembali</a>
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
                    var formData = form.serializeArray();
                    formData.push({name: '_token', value: csrfToken})
                    $.ajax({
                        type: 'PUT',
                        url: "{{route('setting.biaya-keanggotaan.update', $item->id)}}",
                        dataType: 'json',
                        data: formData,
                        beforeSend: function(){
                            btn.html('<div class="spinner-border text-white me-2 align-self-center loader-sm "></div> Loading').attr('disabled', true)
                        },
                        success: function(res){
                            main.notification(res.message, NOTIFICATION_COLOR.SUCCESS)
                            window.location.href = "{{route('setting.biaya-keanggotaan.index')}}";
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
        </script>
    </x-slot>
</x-base-layout>
