@extends('layouts.reset')

<div class="card">
    <div class="card-body">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-7">
                    <img src="assets/img/bg-aktivasi.png" alt="">
                </div>
                <div class="col-lg-7">
                    <div class="contact-form">
                <div class="contact-form-header">
                    <h2>Silahkan Reset Password</h2>
                    <p>
                       Silahkan Reset Password
                    </p>
                </div>

                <div class="jumbotron message-registrasi-aktifasi fade hide"></div>

                <form id="registrasi-aktifasi-form" class="fade show" method="post">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="input-group" style="border: 1px solid #ced4da; border-radius: 8px;">
                                    <input id="new_password-form-aktifasi" type="password"
                                        class="form-control" name="new_password" style="border:none;"   
                                        placeholder="new password" required>
                                    <button type="button" class="btn" style="border:none"
                                        id="togglePassword"><i class="fa fa-eye"></i></button>
                                </div>
                                <span class="message-error-new_password text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-15">
                            <div class="form-group">
                                <div class="input-group" style="border: 1px solid #ced4da; border-radius: 8px;">
                                    <input id="new_password_confirmation-form-aktifasi"
                                        type="password" class="form-control" style="border:none"
                                        name="new_password_confirmation"
                                        placeholder="new password confirmation" required >
                                    <button type="button" class="btn " style="border:none"
                                        id="toggleConfirmation"><i class="fa fa-eye"></i></button>
                                </div>
                                <span class="message-error-new_password_confirmation text-danger"></span>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button id="btn-check-user" type="button"
                        class="btn btn-danger w-100 mb-3">Reset</button>

                        <div class="mt-3 text-center">
                            <a href="{{ route("memberArea.index") }}" class="btn w-100" style="background-color: #dc3545; color: white;">Kembali</a>
                        </div>

                </form>
            </div>
    </div>
    </div>
</div>

</div>


@section('js')
    @parent
    <script>
       $(document).ready(function () {
    var btn = $('#btn-check-user');
    var form = $('#registrasi-aktifasi-form');
    var messageLogin = $('.message-registrasi-aktifasi');
    btn.on('click', function () {
        var formData = form.serialize();
        console.log('Form Data:', formData);
        $.ajax({
            type: 'POST',
            // Menggunakan URL tanpa menyertakan token di URL
            url: "{{ route('memberArea.reset-password.action', $token) }}",
            dataType: 'json',
            data: formData,
                    beforeSend: function () {
                        if ($('.form-control').hasClass('is-invalid')) {
                            $('.form-control').removeClass('is-invalid');
                        }
                        btn.html('<div class="spinner-border text-white me-2 align-self-center loader-sm"></div> Loading').attr('disabled', true);
                    },
                    success: function (res) {
                       
                            Snackbar.show({
                                text: 'Operasi berhasil! ' + res.message,
                                backgroundColor: '#28a745',
                            });
                            btn.html('Reset').attr('disabled', false);
                            // localStorage.setItem('menu', JSON.stringify(res.data.menu));
                            window.location.href = "{{ route('memberArea.index') }}";
                 
                    },
                    error: function (e) {
                        // console.log(e)
                        // Snackbar.show({
                        //     text: 'Operasi Gagal! ' + e.responseJSON.message,
                        //     backgroundColor: 'red',
                        // });
                        btn.html('Reset').attr('disabled', false);
                        if (e.status === 422) {
                            let errorMessage = e.responseJSON.errors;
                           
                            Object.keys(errorMessage).map(i => {
                                var message = errorMessage[i];
                                $(`input[name="${i}"]`).addClass('is-invalid');
                                $(`.message-error-${i}`).html(message[0]);
                            });
                        } else {
                            messageLogin.html(`<div class="alert alert-danger alert-dismissible" role="alert">
                                <i class="fa fa-warning mr-2"></i>
                                <small class="text-muted">${e.responseJSON.message}</small>
                            </div>`).removeClass('hide').addClass('show');
                        }
                    },
                    complete: function () {
                        // Additional actions after AJAX call is complete
                    }
                });
            });
        });

        // Toggle password visibility
        $('#togglePassword').on('click', function () {
            var passwordInput = $('#new_password-form-aktifasi');
            var type = passwordInput.attr('type') === 'password' ? 'text' : 'password';
            passwordInput.attr('type', type);
            $(this).find('i').toggleClass('fa-eye fa-eye-slash');
        });

        // Toggle password confirmation visibility
        $('#toggleConfirmation').on('click', function () {
            var confirmationInput = $('#new_password_confirmation-form-aktifasi');
            var type = confirmationInput.attr('type') === 'password' ? 'text' : 'password';
            confirmationInput.attr('type', type);
            $(this).find('i').toggleClass('fa-eye fa-eye-slash');
        });

    </script>
    <style>
        #togglePassword:focus, #toggleConfirmation:focus {
            outline: none;
        }
    
        /* Additional styles for the larger card */
        .larger-card {
            max-width: 800px; /* Adjust the maximum width as needed */
            margin: 0 auto; /* Center the card horizontally */
        }
    </style>
@endsection