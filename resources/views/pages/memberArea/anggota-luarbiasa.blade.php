@php

    $passwordGuidelines = 'Kata Sandi (8 - 15) terdapat campuran (Huruf Besar, Huruf kecil, Angka dan Spesial Karakter). Contoh: P4s5woRd!#@';

@endphp

<div class="col-12 d-flex justify-content-between flex-wrap contact-after-register">

    <div class="contact-wrapper">
        <div class="contact-form row">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body">

                        <div class="contact-form-header">
                            <h2>Daftar Persyaratan Menjadi Anggota Luar Biasa</h2>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <ol>
                                    @foreach ($persyaratan as $item)
                                        <li style="list-style: decimal">
                                            <div>{{ $item['title'] }}</div>
                                            <ul class="ms-3">
                                                @foreach ($item['childrens'] as $itemc)
                                                    <li style="list-style: disc">{{ $itemc['title'] }}</li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endforeach
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-7">

                <div class="contact-form-header">
                    <h2>Buat Sebuah Akun</h2>
                </div>
                <div class="jumbotron message-registrasi-luarbiasa fade hide"></div>
                <form id="registrasi-luarbiasa-form" class="fade show" novalidate>
                    @csrf
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="text" id='fullname-form-luarbiasa' class="form-control" name="fullname"
                                placeholder="Masukan Nama Anda" required maxlength="50">
                            <div id="message-error-fullname" class=""></div>
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="email" id="email-form-luarbiasa" class="form-control" name="email"
                                placeholder="Masukan Email Anda" required maxlength="50">
                            <div id="message-error-email" class=""></div>
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="input-group">
                                <button type="button" class="btn"
                                    style="border: 1px solid #ced4da; color:#000 !important;" id="telp_indo"
                                    disabled>+62</button>
                                <input type="text" id="mobile-form-luarbiasa" class="form-control" name="mobile"
                                    style="border: 1px solid #ced4da;" placeholder="Nomor Handphone" required
                                    maxlength="13">
                            </div>
                            <div id="message-error-mobile" class=""></div>
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="input-group" style="border: 1px solid #ced4da; border-radius: 8px;">
                                <input id="password-form-luarbiasa" type="password" class="form-control" style="border: none" name="password" placeholder="Kata Sandi" required oninput="checkPasswordStrength()" maxlength="15">
                                <button type="button" class="btn" style="border:none" id="togglePasswordLuarbiasa">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </div>
                            <div id="password-strength-container" style="margin-top: 5px;"></div>
                            <div class="d-flex flex-column mt-1">
                                <span class="password-guidelines" style="font-size: 12px">{{$passwordGuidelines}}</span>
                                <div id="message-error-password" class=""></div>
                                <span class="note-password" style="font-size:12px; color: red;">Catatan: Special karakter harus mengandung !$#%</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="input-group" style="border: 1px solid #ced4da; border-radius: 8px;">
                                <input id="confirm-password-form-luarbiasa" type="password" class="form-control" style="border: none" name="confirm_password" placeholder="Konfirmasi Kata Sandi" required maxlength="15">
                                <button type="button" class="btn" style="border:none" id="toggleConfirmPasswordLuarbiasa">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </div>
                            <div id="message-error-confirm_password" class=""></div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th colspan="2" class="text-left"><i class="fa fa-check-circle green"></i> Syarat Dokumen</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($persyaratanForm as $item)
                                    <tr>
                                        <td style="padding: 20px;">
                                            @if ($item['type'] == 'file')
                                                {{ $item['label'] }}
                                                <input class="form-control" type="file" accept="{{ $item['enctype_file'] }}" name="syarat_pendaftaran_{{ $item['id'] }}" />
                                                <span style="font-size: 12px">
                                                    @if ($item->requirment_filed)
                                                        File harus berupa
                                                        ({{ $item->requirment_filed == 'pdf' ? 'pdf' : 'jpg, jpeg, png' }}),
                                                        @if ($item->requirment_filed == 'pdf' || $item->requirment_filed == 'png')
                                                            Maksimal {{ $item->requirment_filed == 'pdf' ? '2' : '2' }} MB
                                                        @elseif ($item->requirment_filed == 'jpg' || $item->requirment_filed == 'jpeg')
                                                            Maksimal 1 MB
                                                        @endif
                                                    @endif
                                                </span>
                                                <div id="message-error-syarat_pendaftaran_{{ $item['id'] }}" class=""></div>
                                            @else
                                                <div class="form-check">
                                                    <div>
                                                        <p>Dibawah merupakan syarat menjadi Anggota luar biasa</p>
                                                    </div>
                                                    <input class="form-check-input me-2" type="checkbox" name="syarat_pendaftaran_{{ $item['id'] }}" id="syarat_pendaftaran_{{ $item['id'] }}" />
                                                    <label class="form-check-label" for="syarat_pendaftaran_{{ $item['id'] }}" style="color: #000">
                                                        {{ $item['label'] }}
                                                    </label>
                                                    <div id="message-error-syarat_pendaftaran_{{ $item['id'] }}" class=""></div>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="my-4 form-check">
                            <input class="form-check-input me-2" type="checkbox" name="agreement" id="agreement" />
                            <label class="form-check-label" for="agreement" style="color: #000">
                                Saya menyatakan bahwa saya bertanggung jawab atas keaslian dokumen yang saya lampirkan.
                            </label>
                            <div id="message-error-agreement" class=""></div>
                        </div>

                        <button id="daftar-luar-biasa" type="submit" class="theme-btn btn-block btn-submit-luarbiasa">Daftar <i class="far fa-paper-plane"></i></button>

                        <div class="text-center">
                            {{-- Sudah Punya Akun? <a href="{{route('login')}}">Masuk</a> --}}
                        </div>

                        <div class="col-md-12 mt-3">
                            <div class="form-messege text-success"></div>
                        </div>
                    </div>
                </form>
                <div id="toastContainer" class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                    <!-- Toast -->
                    <div id="toast" class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body">
                                Operasi Gagal!
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                    </div>
                    <!-- End of Toast -->
                </div>
            </div>
        </div>
    </div>
</div>


@section('js')
    @parent
    <script>
         function checkPasswordStrength() {
            var password = document.getElementById("password-form-luarbiasa").value;
            var strengthContainer = document.getElementById("password-strength-container");
            var lowerCaseLetters = /[a-z]/g; 
            var upperCaseLetters = /[A-Z]/g;
            var numbers = /[0-9]/g;

            var strength = 0;

        
            if (password.length >= 6) {
                strength += 1;
            }

        
            if (password.match(lowerCaseLetters)) {
                strength += 1;
            }

            
            if (password.match(upperCaseLetters)) {
                strength += 1;
            }
            
            if (password.match(numbers)) {
                strength += 1;
            }

            switch (strength) {
                case 0:
                    strengthContainer.innerHTML = "";
                    break;
                case 1:
                    strengthContainer.innerHTML = "<span style='color: red; font-size: 12px'>Kata sandi lemah</span>";
                    break;
                case 2:
                    strengthContainer.innerHTML = "<span style='color: orange;  font-size: 12px'>Kata sandi cukup kuat</span>";
                    break;
                case 3:
                case 4:
                    strengthContainer.innerHTML = "<span style='color: green;  font-size: 12px'>Kata sandi sangat kuat</span>";
                    break;
            }
        }
        $(document).ready(function() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var formRegistrasiLuarbiasa = $('#registrasi-luarbiasa-form');
            var btnSubmitLuarbiasa = $('.btn-submit-luarbiasa');
            var messageRegistrasiLuarbiasa = $('.message-registrasi-luarbiasa');

            formRegistrasiLuarbiasa.on('submit', function(e) {
                e.preventDefault();

                var formData = new FormData(formRegistrasiLuarbiasa[0]);
                formData.append('_token', csrfToken);

                $.ajax({
                    type: 'POST',
                    enctype: 'multipart/form-data',
                    url: '{{ route('memberArea.registrasi-luarbiasa') }}',
                    processData: false,
                    contentType: false,
                    data: formData,
                    beforeSend: function() {
                        btnSubmitLuarbiasa.html('Proses...').prop('disabled', true);
                        $('.invalid-feedback').removeClass('invalid-feedback d-block').html('')
                    },
                    success: function(res) {
                        Snackbar.show({
                            text: 'Operasi berhasil!',
                            backgroundColor: '#28a745',
                        });
                        btnSubmitLuarbiasa.html('Daftar').prop('disabled', false);
                        formRegistrasiLuarbiasa.removeClass('show').addClass('hide');
                        formRegistrasiLuarbiasa[0].reset();
                        messageRegistrasiLuarbiasa.html(`<div class="card">
                    <div class="card-body" style="text-align: center !important;">
                        <div style="text-align:center !important; margin:15px;"><img src="assets/img/bg-email.png" alt=""></div>

                        <h4 ><i class="fa fa-check-circle green"></i> Registrasi Berhasil</h4>
                    <p class="lead">Mohon untuk mengecek email anda untuk melakukan verifikasi. Terimakasih </p>
                    <p class="lead">
                        <button class="btn btn-primary btn-kembali-anggota-luar-biasa">Kembali</button>
                    </p></div></div>`).removeClass('hide').addClass('show');
                        var contactFormOffset = $('.contact-after-register').offset().top;
                        $('html, body').animate({
                            scrollTop: contactFormOffset
                        }, 1000);
                    },
                    error: function(e) {
                        btnSubmitLuarbiasa.html('Daftar').prop('disabled', false);
                        if (e.status === 422) {
                            let errors = e.responseJSON.errors;
                            if (errors.password) {
                                var errorMessage = errors.password;
                                $('#message-error-password').addClass('invalid-feedback d-block').html(errorMessage);
                                var toast = new bootstrap.Toast(document.getElementById('toast'));
                                $('#toast .toast-body').html(errorMessage);
                                toast.show();
                            }
                            
                            // Menampilkan pesan kesalahan secara berurutan
                            let keys = Object.keys(errors);
                            let index = 0;
                            let displayError = function() {
                                if (index < keys.length) {
                                    let errorMessage = errors[keys[index]];
                                    $('#message-error-' + keys[index]).addClass('invalid-feedback d-block').html(errorMessage);
                                    
                                    // Menampilkan pesan kesalahan dalam toast
                                    var toast = new bootstrap.Toast(document.getElementById('toast'));
                                    $('#toast .toast-body').html(errorMessage);
                                    toast.show();
                                    
                                    index++;
                                    setTimeout(displayError, 1500);
                                }
                            };
                            
                            displayError(); // Menampilkan pesan kesalahan pertama
                            
                            $('.password-guidelines').hide();
                            $('.note-password').hide();
                        } else {
                            // Jika status bukan 422, tampilkan pesan kesalahan umum dalam toast
                            var toast = new bootstrap.Toast(document.getElementById('toast'));
                            $('#toast .toast-body').html('Operasi Gagal!');
                            toast.show();
                        }
                    }

                });
            });

            $('#togglePasswordLuarbiasa').on('click', function() {
                var passwordInput = $('#password-form-luarbiasa');
                var type = passwordInput.attr('type') === 'password' ? 'text' : 'password';
                passwordInput.attr('type', type);
                $(this).find('i').toggleClass('fa-eye fa-eye-slash');
            });

            $('#toggleConfirmPasswordLuarbiasa').on('click', function() {
                var passwordInput = $('#confirm-password-form-luarbiasa');
                var type = passwordInput.attr('type') === 'password' ? 'text' : 'password';
                passwordInput.attr('type', type);
                $(this).find('i').toggleClass('fa-eye fa-eye-slash');
            });
            $(document).on('click', ".btn-kembali-anggota-luar-biasa", function() {
                messageRegistrasiLuarbiasa.html('').removeClass('show').addClass('hide');
                formRegistrasiLuarbiasa.removeClass('hide').addClass('show');
            });
        });
    </script>
@endsection
