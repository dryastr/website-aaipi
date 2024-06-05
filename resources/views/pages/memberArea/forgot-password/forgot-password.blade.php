@extends('layouts.master')

@section('content')

<div class="card">
    <div class="card-body">
        <div class="row align-self-center contact-wrapper">
            <div class="col-lg-5 d-flex justify-content-center">
                <img src="assets/img/login.gif" alt="" class="w-10"> <!-- Adjust the width as needed -->
            </div>
            <div class="col-lg-7">
                <div class="contact-form">
                    <div class="contact-form-header" id="contact-form-header">
                        <h2>Verifikasi Email</h2>
                        <p>Kirim Email untuk Ubah password</p>
                    </div>

                    <div class="jumbotron message-login fade hide"></div>

                    <!-- Form -->
                    <form id="form-login" method="POST" novalidate class="fade show">
                        @csrf <!-- Add CSRF token -->

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input name="email" type="email" class="form-control" value="" placeholder="Email" required>
                                    <div id="feedback-email" class=""></div>
                                <span style="font-size:12px; color: red;">Catatan: Masukan Email Yang Terdaftar ! </span>
                            </div>
                            <button type="submit" class="btn btn-secondary btn-login w-100">Kirim</button>

                        <div class="cek-user-result"></div>

                        <div class="mt-3 text-center">
                            <a href="{{ route("memberArea.index") }}" class="btn w-100" style="background-color: #D21A26; color: white;">Kembali</a>
                        </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- End Form -->
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
    @parent

    <!-- Script for handling form submission via AJAX -->
    <script>
      $(document).ready(function(){
    var btn = $('.btn-login');
    var form = $('#form-login');
    var formtitle = $('#contact-form-header');
    var messageLogin = $('.message-login');

    form.on('submit', function(e){
        e.preventDefault();
        var formData = form.serialize();

        $.ajax({
            type: 'POST',
            url: "{{ route('memberArea.forgot-password.action') }}",
            dataType: 'json',
            data: formData,
            beforeSend: function(){
                $('.form-control').removeClass('is-invalid');
                btn.html('<div class="spinner-border text-white me-2 align-self-center loader-sm "></div> Loading').attr('disabled', true);
            },
            success: function(res) {
                Snackbar.show({
                    text: 'Operasi berhasil! ' + res.message,
                    backgroundColor: '#28a745',
                });

                messageLogin.html(`<div class="alert alert-success alert-dismissible" role="alert">
                    <i class="fa fa-check-circle mr-2"></i>
                    <small class="text-muted">Email verifikasi telah berhasil dikirim.</small>
                </div>`).removeClass('hide').addClass('show');

                form.hide();
                formtitle.hide();

                btn.html('Kirim').attr('disabled', false);
                form[0].reset();
            },
            error: function(e) {
                // Always treat the error as success for unregistered email
                Snackbar.show({
                    text: 'Email berhasil terkirim. Silakan periksa email Anda.',
                    backgroundColor: '#28a745',
                });

                messageLogin.html(`<div class="alert alert-success alert-dismissible" role="alert">
                    <i class="fa fa-check-circle mr-2"></i>
                    <small class="text-muted">Email verifikasi telah berhasil dikirim.</small>
                </div>`).removeClass('hide').addClass('show');

                form.hide();
                formtitle.hide();

                btn.html('Kirim').attr('disabled', false);
            },
            done: function(){
                // Additional actions after AJAX call is done
            }
        });
    });
});

    </script>
    <!-- End Script -->
@endsection
