@extends('admin.pages.profile.index')

@push('headerFile')
<link rel="stylesheet" type="text/css" href="{{asset('src/plugins/src/stepper/bsStepper.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('src/assets/css/light/scrollspyNav.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{asset('src/plugins/css/light/stepper/custom-bsStepper.css')}}">

@endpush

@section('content')


<div class="bs-stepper stepper-icons">
    <div class="bs-stepper-header" role="tablist">
        <div class="step" data-target="#withIconsStep-one">
            <button type="button" class="step-trigger" role="tab" >
                <span class="bs-stepper-circle"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></span>
                <span class="bs-stepper-label">Form Pembayaran</span>
            </button>
        </div>
        <div class="line"></div>
        <div class="step" data-target="#withIconsStep-two">
            <button type="button" class="step-trigger" role="tab"  >
                <span class="bs-stepper-circle"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-send"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg></span>
                <span class="bs-stepper-label">Konfirmasi Pembayaran</span>
            </button>
        </div>
        <div class="line"></div>
        <div class="step" data-target="#withIconsStep-three">
            <button type="button" class="step-trigger" role="tab"  >
                <span class="bs-stepper-circle"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map-pin"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg></span>
                <span class="bs-stepper-label">
                    <span class="bs-stepper-title">Informasi</span>
                </span>
            </button>
        </div>
    </div>
    <div class="bs-stepper-content">
        <div id="withIconsStep-one" class="content" role="tabpanel">
            <form>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Jumlah Tagihan</label>
                            {{-- <div class="form-control">{{$biaya_keanggotaan['biaya_rupiah']}}</div> --}}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Nominal Bayar</label>
                            {{-- <div class="form-control">{{$biaya_keanggotaan['biaya_rupiah']}}</div> --}}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Bukti Pembayaran</label>
                            <div class="file-upload">
                                <input type="file" class="form-control" name="bukti_transfer" />
                            </div>
                            <div id="feedback-current_password" class=""></div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="button-action mt-5">
                {{-- <button class="btn btn-secondary btn-prev me-3" disabled>Prev</button> --}}
                <button class="btn btn-secondary btn-nxt">Lanjut</button>
            </div>
        </div>
        <div id="withIconsStep-two" class="content" role="tabpanel">
            <form id="form-aktifasi-keanggotaan">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Nama</label>
                            <div class="form-control">{{$user['fullname']}}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>NRP</label>
                            <div class="form-control">-</div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Jumlah Tagihan</label>
                            {{-- <div class="form-control">{{$biaya_keanggotaan['biaya_rupiah']}}</div> --}}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Nominal Bayar</label>
                            {{-- <div class="form-control preview-nominal_bayar">{{$biaya_keanggotaan['biaya_rupiah']}}</div> --}}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Bukti Upload</label>
                            <div class="form-control preview-file-name"></div>
                            <a href="" class="btn-preview-file" target="_blank">Preview</a>
                        </div>
                    </div>
                </div>

                <div class="button-action mt-5">
                    <button type="button" class="btn btn-secondary btn-prev me-3">Kembali</button>
                    <button type="button" class="btn btn-secondary btn-submit">Kirim</button>
                </div>
            </form>
        </div>
        <div id="withIconsStep-three" class="content" role="tabpanel" >
            <div class="alert alert-icon-left alert-light-success fade show mb-4" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>

                @if ($status_keanggotaan['status'] == 'belum-aktif')
                <strong>Pembayaran Anda Telah Berhasil Dikirim</strong>
                <p>Terima kasih telah melakukan pembayaran keanggotaan. Kami akan segera memverifikasi informasi pembayaran Anda dalam waktu 2x24 jam. Setelah pembayaran dikonfirmasi, keanggotaan Anda akan aktif dan Anda akan menerima email konfirmasi. Terima kasih atas kesabaran dan kepercayaan Anda.</p>
                @endif

                @if ($status_keanggotaan['status'] == 'mendekati-kadaluwarsa')
                <strong>Pembayaran Perpanjangan Berhasil Diterima</strong>
                <p>Terima kasih telah memperbaharui keanggotaan Anda. Kami akan memverifikasi pembayaran Anda dalam waktu 2x24 jam. Email konfirmasi akan dikirimkan kepada Anda setelah pembayaran dikonfirmasi, memastikan keanggotaan Anda tetap aktif tanpa terputus. Kami menghargai komitmen Anda untuk tetap bersama kami.</p>
                @endif

                @if ($status_keanggotaan['status'] == 'kadaluwarsa')
                <strong>Pembayaran Pembaruan Keanggotaan Anda Berhasil</strong>
                <p>Kami sangat mengapresiasi Anda telah memperbaharui keanggotaan yang telah kedaluwarsa. Kami akan memverifikasi pembayaran Anda dalam 2x24 jam dan Anda akan menerima email konfirmasi segera setelahnya. Selamat datang kembali, dan terima kasih telah bergabung kembali dengan kami!</p>
                @endif

                @if ($status_keanggotaan['status'] == 'masa-tenggang')
                <strong>Pembayaran Anda Diterima Selama Masa Tenggang</strong>
                <p>Terima kasih telah memperbaharui keanggotaan Anda selama masa tenggang. Kami akan memproses verifikasi pembayaran Anda dalam 2x24 jam. Setelah pembayaran dikonfirmasi, Anda akan menerima email dan keanggotaan Anda akan kembali aktif. Kami senang Anda memilih untuk tetap bersama kami.</p>
                @endif
            </div>


            <div class="button-action mt-3">
                <a href="{{route('profile.aktifasi-keanggotaan')}}" class="btn btn-success me-3">Kembali</a>
            </div>
        </div>
    </div>
</div>


@endsection

@push('footerFile')
<script src="{{asset('src/plugins/src/stepper/bsStepper.min.js')}}"></script>

<script>
    var stepperWizardIcon = document.querySelector('.stepper-icons');
    var stepperIcon = new Stepper(stepperWizardIcon, {
        animation: true
    })
    var stepperNextButtonIcon = stepperWizardIcon.querySelectorAll('.btn-nxt');
    var stepperPrevButtonIcon = stepperWizardIcon.querySelectorAll('.btn-prev');

    stepperNextButtonIcon.forEach(element => {
        element.addEventListener('click', function() {
            stepperIcon.next();
        })
    });

    stepperPrevButtonIcon.forEach(element => {
        element.addEventListener('click', function() {
            stepperIcon.previous();
        })
    });

    stepperWizardIcon.addEventListener('show.bs-stepper', function (event) {
        if (event.detail.from < event.detail.to) {
            stepperWizardIcon.querySelectorAll('.step')[event.detail.from].classList.add('crossed');
        } else {
            stepperWizardIcon.querySelectorAll('.step')[event.detail.to].classList.remove('crossed');
        }
    })


    $(document).ready(function(){
        $('input[name="bukti_transfer"]').on('change', function(e){
            const file = e.target.files[0];
            const bFile = URL.createObjectURL(file);
            $('.btn-preview-file').attr('href', bFile)
            $('.preview-file-name').html(file.name)
        })

        // $('input[name="nominal_bayar"]').on('input', function(e){
        //     var value = e.target.value;

        //     nStr = value;
        //     x = nStr.split(',');
        //     x1 = x[0];
        //     x2 = x.length > 1 ? ',' + x[1] : '';
        //     var rgx = /(\d+)(\d{3})/;
        //     while (rgx.test(x1)) {
        //         x1 = x1.replace(rgx, '$1' + '.' + '$2');
        //     }

        //     $('.preview-nominal_bayar').html(x1 + x2)
        // });

        $('.btn-submit').on('click', function(e){
            var form = $('#form-aktifasi-keanggotaan');
            var bukti_transfer = $('input[name="bukti_transfer"]').prop('files')[0];
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var formData = new FormData(form[0]);
            formData.append('_token', csrfToken);
            formData.append('bukti_transfer', bukti_transfer);
            formData.append('nominal', 0);

            $.ajax({
                type: 'POST',
                enctype: 'multipart/form-data',
                url: "{{route('profile.aktifasi-keanggotaan-action')}}",
                processData: false,
                contentType: false,
                data: formData,
                beforeSend: function(){
                    if($(`.form-control`).hasClass('is-invalid')){
                        $(`.form-control`).removeClass('is-invalid')
                    }
                    $('.btn-submit').html('<div class="spinner-border text-white me-2 align-self-center loader-sm "></div> Loading').attr('disabled', true)
                },
                success: function(res){
                    main.notification(res.message, NOTIFICATION_COLOR.SUCCESS)
                    $('.btn-submit').html('Simpan Perubahan').attr('disabled', false)
                    stepperIcon.next();
                },
                error: function(res){
                    var response = res.responseJSON;
                    $('.btn-submit').html('Simpan Perubahan').attr('disabled', false)
                    main.notification(response.message, NOTIFICATION_COLOR.DANGER)
                    if(typeof res.responseJSON.errors === 'object'){
                        Object.keys(response.errors).map((i) => {
                            var message = response.errors[i];
                            $(`input[name="${i}"]`).addClass('is-invalid')
                            $(`textarea[name="${i}"]`).addClass('is-invalid')
                            $(`#feedback-${i}`).addClass('invalid-feedback').html(message)
                        })
                    }
                },
            })
        })
    })
</script>
@endpush
