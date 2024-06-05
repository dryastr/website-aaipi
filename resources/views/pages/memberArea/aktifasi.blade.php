<div class="row  contact-wrapper">
    <div class="col-lg-5">
        <img src="assets/img/bg-aktivasi.png" alt="">
    </div>
    <div class="col-lg-7">

            <div class="contact-form">
                <div class="contact-form-header">
                    <h2>Belum punya akun? Tapi anda anggota AAIPI? Yuk Aktivasi...</h2>
                    <p>
                        1. Silahkan masukan NIP dan email anda yang terdaftar di aplikasi SIBIJAK.<br>
                        2. Buka email anda lalu klik tautan yang dikirimkan jika ke email anda untuk memulai aktivasi akun AAIPI.<br>
                        3. Jika email belum terdaftar pada aplikasi SIBIJAK maka silahkan lakukan pemutakhiran data profile SIBIJAK anda terlebih dahulu.
                    </p>
                </div>

                <div class="jumbotron message-registrasi-aktifasi fade hide">

                </div>

                <form id="registrasi-aktifasi-form" class="fade show">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input id="nip-form-aktifasi" type="text" class="form-control" name="nip" placeholder="NIP" required>
                                <span class="message-error-nip text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input id="email-form-aktifasi" type="email" class="form-control" name="email" placeholder="Email" required>
                                <span class="message-error-email text-danger"></span>
                            </div>
                        </div>
                    </div>

                    <button id="btn-check-user" type="button" class="btn btn-danger w-100 mb-3">Lanjutkan</button>

                    <div class="cek-user-result"></div>

                    <button type="button" class="btn btn-warning btn-reset-aktifasi d-none">Reset </button>
                    <button type="button" class="btn btn-danger btn-submit-aktifasi d-none">Aktifkan </button>
                    <div class="text-center">
                        {{-- Sudah Punya Akun? <a href="{{route('login')}}">Masuk</a> --}}
                    </div>
                </form>
            </div>
    </div>

</div>



@section('js')
@parent
<script>
    $(document).ready(function(){
        var urlCheckUser = '{{route('memberArea.check-user')}}';
        var btnCheckUser = $('#btn-check-user')
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var formRegistrasiAktifasi = $('#registrasi-aktifasi-form');

        // Check User
        var inputNip = $('#nip-form-aktifasi');
        var inputEmail = $('#email-form-aktifasi');
        var checkUserResult = $('.cek-user-result');
        var btnSubmitAktifasi = $('.btn-submit-aktifasi');
        var btnResetAktifasi = $('.btn-reset-aktifasi');
        var messageRegistrasiAktifasi = $('.message-registrasi-aktifasi');

        btnCheckUser.on('click', function(){
            $.ajax({
                method: 'POST',
                url: urlCheckUser,
                data: {
                    nip: inputNip.val(),
                    email: inputEmail.val(),
                    _token: csrfToken
                },
                beforeSend: function(){
                    btnCheckUser.html('Mohon Tunggu').prop('disabled', true);
                    $('.message-error-nip').html('')
                    $('.message-error-email').html('')
                },
                // success: function(res){
                //     if(res.status === 200){
                //         var html = ''
                //         if(res.data){
                //             var data = res.data;
                //             btnCheckUser.addClass('d-none').html('Lanjutkan').prop('disabled', false);
                //             btnSubmitAktifasi.removeClass('d-none')
                //             btnResetAktifasi.removeClass('d-none')
                //             inputNip.prop('readonly', true)
                //             inputEmail.prop('readonly', true)
                //             html = `<table class="table table-borderless">
                //                         <tr>
                //                             <th width="20%">Nama</th>
                //                             <td width="5%">:</td>
                //                             <td id="registrasi-aktifasi-fullname">${data.data?.nama_lengkap}</td>
                //                         </tr>
                //                         <tr>
                //                             <th>Jabatan</th>
                //                             <td>:</td>
                //                             <td id="registrasi-aktifasi-jabatan">${data.data?.nama_jenjang_jabatan}</td>
                //                         </tr>
                //                     </table>`
                //             checkUserResult.html(html);
                //         }else{
                //             btnCheckUser.html('Lanjutkan').prop('disabled', false);
                //             html = `<div class="alert alert-danger" role="alert">Data APIP Tidak ditemukan</div>`
                //             checkUserResult.html(html);
                //         }
                //     }
                // },
                success: function(res){
                    if(res && res.status === 200 && res.data) {
                        var data = res.data;
                        btnCheckUser.addClass('d-none').html('Lanjutkan').prop('disabled', false);
                        btnSubmitAktifasi.removeClass('d-none');
                        btnResetAktifasi.removeClass('d-none');
                        inputNip.prop('readonly', true);
                        inputEmail.prop('readonly', true);
                        var html = `<table class="table table-borderless">
                                        <tr>
                                            <th width="20%">Nama</th>
                                            <td width="5%">:</td>
                                            <td id="registrasi-aktifasi-fullname">${data.nama_lengkap}</td>
                                        </tr>
                                        <tr>
                                            <th>Jabatan</th>
                                            <td>:</td>
                                            <td id="registrasi-aktifasi-jabatan">${data.nama_jenjang_jabatan}</td>
                                        </tr>
                                    </table>`;
                        checkUserResult.html(html);
                    } else {
                        btnCheckUser.html('Lanjutkan').prop('disabled', false);
                        var html = `<div class="alert alert-danger" role="alert">Data APIP Tidak ditemukan</div>`;
                        checkUserResult.html(html);
                    }
                },
                error:function(e){
                    btnCheckUser.html('Lanjutkan').prop('disabled', false);
                    if(e.status === 422){
                        let errorMessage = e.responseJSON.errors
                        Object.keys(errorMessage).map(i => {
                            var message = errorMessage[i];
                            // console.log(message)
                            $('.message-error-' + i).html(message)
                        })
                    }
                }
            })
        })

        // Handle Reset Form Aktifasi
        btnResetAktifasi.on('click', function(){
            resetFormRegistrasiAktifasi()
        })

        // Submit aktifasi
        btnSubmitAktifasi.on('click', function(){
            var fullname = $('#registrasi-aktifasi-fullname')
            var jabatan = $('#registrasi-aktifasi-jabatan')

            $.ajax({
                method: 'POST',
                url: '{{route('memberArea.registrasi-aktifasi')}}',
                data: {
                    _token: csrfToken,
                    nip: inputNip.val(),
                    email: inputEmail.val(),
                    fullname: fullname.html(),
                    jabatan: jabatan.html(),
                },
                beforeSend: function(){
                    btnSubmitAktifasi.html('Proses...').prop('disabled', true);
                },
                success: function(res){
                    btnSubmitAktifasi.html('Aktifkan').prop('disabled', false);
                    formRegistrasiAktifasi.removeClass('show').addClass('hide');
                    resetFormRegistrasiAktifasi();


                    messageRegistrasiAktifasi.html(`<div class="card">
                        <div class="card-body" style="text-align: center !important;">
                            <div style="text-align:center !important; margin:15px;"><img src="assets/img/bg-email.png" alt=""></div>

                            <h4 ><i class="fa fa-check-circle green"></i> Registrasi Berhasil</h4>

                        <p class="lead">Mohon untuk mengecek email anda untuk melakukan verifikasi. Terimakasih.</p>
                        <p class="lead">
                            <button class="btn btn-primary btn-kembali">Kembali</button>
                        </p></div></div>`).removeClass('hide').addClass('show');
                },
                error:function(e){
                    btnSubmitAktifasi.html('Aktifkan').prop('disabled', false);
                    if(e.status === 422){
                        let errorMessage = e.responseJSON.errors
                        Object.keys(errorMessage).map(i => {
                            var message = errorMessage[i];
                            // console.log(message)
                            $('.message-error-' + i).html(message)
                        })
                    }
                }
            })
        })

        // function reset form
        function resetFormRegistrasiAktifasi(){
            btnCheckUser.removeClass('d-none').html('Lanjutkan').prop('disabled', false);
            btnSubmitAktifasi.addClass('d-none')
            btnResetAktifasi.addClass('d-none')
            checkUserResult.html('');
            inputNip.val('').prop('readonly', false)
            inputEmail.val('').prop('readonly', false)
        }

        $(document).on('click', ".btn-kembali", function() {
            messageRegistrasiAktifasi.html('').removeClass('show').addClass('hide');
            formRegistrasiAktifasi.removeClass('hide').addClass('show');
        });

    })
</script>
@endsection
