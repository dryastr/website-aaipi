<x-base-layout :title="$title">
    <div class="row layout-top-spacing">
        <div class="col-md-12 layout-spacing">
            <div class="widget widget-table-one">
                <div class="widget-heading">
                    <h5 class="">{{$title}}</h5>
                    <div class="task-action">
                        {{-- <a href="{{route('verifikasi.keanggotaan.decision', [$item['pid'], 'disetujui'])}}" class="btn btn-success">Setujui </a>
                        <a href="{{route('verifikasi.keanggotaan.decision', [$item['pid'], 'ditolak'])}}" class="btn btn-danger">Tolak</a> --}}
                    </div>
                </div>
                <div class="widget-content">
                    {{-- <h6 class="">General Information</h6> --}}
                    <div class="row">
                        {{-- <div class="col-xl-2 col-lg-12 col-md-4"></div> --}}
                        <div class="col-xl-10 col-lg-12 col-md-8 mt-md-0 mt-4">
                            <div class="form">
                                {{-- {{$item}} --}}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nama lengkap</label>
                                            <div class="form-control mb-3">{{$item['user']['fullname']}}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <div class="form-control mb-3">{{$item['user']['email']}}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nomor Telepon</label>
                                            <div class="form-control mb-3">{{$item['user']['mobile'] ? $item['user']['mobile'] : '-'}}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Jenis Keanggotaan</label>
                                            <div class="form-control mb-3">{{$item['user']['role']['name']}}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Tagihan</label>
                                            <div class="form-control mb-3">{{$item['tagihan_rupiah']}}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nominal Bayar</label>
                                            <div class="form-control mb-3">{{$item['nominal_bayar_rupiah']}}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Tanggal Bayar</label>
                                            <div class="form-control mb-3">{{$item['tanggal_bayar']}}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        @if($item->attachment)
                                        @if($item->attachment->path)
                                        <a class="btn btn-primary" href="{{ $item->attachment->file_url }}" target="_blank">Buka Dokumen</a>
                                        @else
                                            <p>Attachment tidak ditemukan.</p>
                                        @endif
                                    @else
                                        <p>Tidak ada attachment.</p>
                                    @endif
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Status Pembayaran</label>
                                            <select class="form-select mb-3 select-status" name="status">
                                                <option value="">Pilih Status Pembayaran</option>
                                                <option value="terverifikasi">Diterima</option>
                                                <option value="ditolak">Ditolak</option>
                                            </select>
                                            <div id="feedback-status" class=""></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group f-alasan d-none">
                                            <label>Alasan Ditolak</label>
                                            <input class="form-control mb-3" name="alasan" placeholder="*wajib diisi">
                                            <div id="feedback-alasan" class=""></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <a href="{{route('verifikasi.keanggotaan.index')}}" class="btn btn-warning">Kembali</a>
                                        <button class="btn btn-primary btn-kirim">Kirim</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <x-slot name="footerFiles">
        <script>
            $(document).ready(function(){
                $('.select-status').on('change', function(e){
                    var value = e.target.value
                    var eCatatan = $('.f-alasan')

                    if(value == 'ditolak'){
                        eCatatan.removeClass('d-none')
                    }else{
                        eCatatan.addClass('d-none')
                    }
                })

                var btn = $('.btn-kirim')
                btn.on('click', function(){
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    var status = $('.select-status').val();
                    var alasan = $('input[name="alasan"]').val();
                    $.ajax({
                        type: 'POST',
                        url: "{{route('verifikasi.pembayaran.decision', [$item['pid']])}}",
                        dataType: 'json',
                        data: {
                            '_token': csrfToken,
                            'status': status,
                            'alasan': status == 'ditolak' ? alasan : null
                        },
                        beforeSend: function(){
                            btn.html('<div class="spinner-border text-white me-2 align-self-center loader-sm "></div> Loading').attr('disabled', true)
                        },
                        success: function(res){
                            main.notification(res.message, NOTIFICATION_COLOR.SUCCESS)
                            window.location.href = "{{route('verifikasi.pembayaran.index')}}";
                            btn.html('Simpan').attr('disabled', false)
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
