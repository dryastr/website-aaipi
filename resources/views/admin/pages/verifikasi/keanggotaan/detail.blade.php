<x-base-layout :title="$title">
    <div class="row layout-top-spacing">
        <div class="col-md-12 layout-spacing">
            <div class="widget widget-table-one">
                <div class="widget-heading">
                    <h5 class="">{{$title}}</h5>
                    <div class="task-action">
                        {{-- <a href="{{route('verifikasi.keanggotaan.index')}}" class="btn btn-warning">Kembali</a>
                        <a href="{{route('verifikasi.keanggotaan.decision', [$item['pid'], 'disetujui'])}}" class="btn btn-success">Setujui </a>
                        <a href="{{route('verifikasi.keanggotaan.decision', [$item['pid'], 'ditolak'])}}" class="btn btn-danger">Tolak</a> --}}
                    </div>
                </div>
                <div class="widget-content">
                    <h6 class="">General Information</h6>
                    <div class="row">
                        <div class="col-xl-2 col-lg-12 col-md-4">
                            <img alt="avatar" src="{{asset($item['avatar_url'] ? $item['avatar_url'] : 'assets/img/user.png')}}" class="rounded-circle" width="100%">
                        </div>
                        <div class="col-xl-10 col-lg-12 col-md-8 mt-md-0 mt-4">
                            <div class="form">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Full Name</label>
                                            <div class="form-control mb-3">{{$item['fullname']}}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <div class="form-control mb-3">{{$item['email']}}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nomor Telepon</label>
                                            <div class="form-control mb-3">{{$item['mobile'] ? $item['mobile'] : '-'}}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Jenis Keanggotaan</label>
                                            <div class="form-control mb-3">{{$item['role']['name']}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="form">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Keputusan</label>
                                            <select class="form-select select-status" name="status_approval">
                                                <option value="">Pilih Keputusan</option>
                                                <option value="disetujui">Setujui</option>
                                                <option value="ditolak">Tolak</option>
                                            </select>
                                            <div id="feedback-status_approval" class=""></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4 f-alasan d-none">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label>Alasan</label>
                                            <textarea name="catatan" class="form-control"></textarea>
                                            <div id="feedback-catatan" class=""></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <a href="{{route('verifikasi.keanggotaan.index')}}" class="btn btn-warning">Kembali</a>
                                        <button class="btn btn-primary btn-kirim">Kirim</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ($item['role_id'] == 3)
                        <div class="col-sm-12 col-md-6">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th colspan="3" class="text-center">Persyaratan Pendaftaran</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Judul</th>
                                        <th class="text-center">Persyaratan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($item_persyaratan['data'])
                                    @foreach($item_persyaratan['data'] as $row => $value)
                                    <tr>
                                        <td style="white-space: normal">{{$row + 1}}</td>
                                        <td style="white-space: normal">{{$value['title']}}</td>
                                        <td style="white-space: normal">
                                        @if($value['type'] == 'file')
                                            @isset($value['url_file'])
                                            <a class="btn btn-primary" href="{{$value['url_file']}}" target="_blank">Buka Dokumen</a>
                                            @endisset
                                        @else
                                        <div class="text-center" style="font-size: 18px">
                                            <i class="fa {{$value['value'] ? 'fa-check-square text-success' : 'fa-times-circle text-danger'}}"></i>
                                        </div>
                                        @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endisset
                                </tbody>
                            </table>
                        </div>
                        @endif

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

                var btn = $('.btn-kirim');
                btn.on('click', function(){
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    var status = $('.select-status').val();
                    var catatan = $('textarea[name="catatan"]').val();
                    $.ajax({
                        type: 'POST',
                        url: "{{route('verifikasi.keanggotaan.decision', [$item['pid']])}}",
                        dataType: 'json',
                        data: {
                            '_token': csrfToken,
                            'status_approval': status,
                            'catatan': status == 'ditolak' ? catatan : null
                        },
                        beforeSend: function(){
                            $('.invalid-feedback').removeClass('invalid-feedback d-block').html('')
                            btn.html('<div class="spinner-border text-white me-2 align-self-center loader-sm "></div> Loading').attr('disabled', true)
                        },
                        success: function(res){
                            main.notification(res.message, NOTIFICATION_COLOR.SUCCESS)
                            window.location.href = "{{route('verifikasi.keanggotaan.index')}}";
                            btn.html('Kirim').attr('disabled', false)
                        },
                        error: function(res){
                            var response = res.responseJSON;
                            btn.html('Kirim').attr('disabled', false)
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
