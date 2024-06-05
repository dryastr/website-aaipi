<div class="row  align-self-center contact-wrapper">
    <div class="col-lg-5 d-flex justify-content-center">
        <img src="assets/img/login.gif" alt="" class="w-75">
    </div>
    <div class="col-lg-7">

        <div class="contact-form">
            <div class="contact-form-header">
                <h2>Login Anggota</h2>
                <p>Silakan login anggota disini: Anggota (Biasa, Luar Biasa, Kehormatan)</p>
            </div>

            <div class="jumbotron message-login fade hide">

            </div>

            <form id="form-login" method="POST" novalidate class="fade show">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input name="email" type="email" class="form-control" value="" placeholder="Email" required>
                            <div id="feedback-email" class="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="input-group" style="border: 1px solid #ced4da; border-radius: 8px;">
                                <input id="form_password" name="password" type="password" class="form-control" value=""
                                    style="border: none;" placeholder="Password" required>
                                <button type="button" class="btn" style="border:none" id="togglePassword"><i
                                        class="fa fa-eye"></i></button>
                            </div>
                            <div id="feedback-password" class="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-right mb-2">
                    <a href="{{ route('memberArea.forgot-password.index') }} "> Lupa Password ?<i
                            aria-hidden="true"></i></a>
                </div>
                {{-- <button  type="submit" class="btn btn-login btn-danger w-100 mb-3">Lanjutkan</button> --}}
                <button type="submit" class="btn btn-secondary btn-login w-100">SIGN IN</button>
                <div class="cek-user-result"></div>
                <div>


                    {{-- <button type="button" class="btn btn-warning btn-reset-aktifasi d-none">Reset </button>
                    <button type="button" class="btn btn-danger btn-submit-aktifasi d-none">Aktifkan </button> --}}

            </form>
            <div class="col-md-15">

            </div>
        </div>
    </div>
</div>

</div>




@section('js')
@parent
<script>
    $(document).ready(function () {
        var btn = $('.btn-login');
        var form = $('#form-login')
        var messageLogin = $('.message-login');

        form.on('submit', function (e) {
            e.preventDefault();
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var formData = form.serializeArray();
            formData.push({
                name: '_token',
                value: csrfToken
            })
            $.ajax({
                type: 'POST',
                url: "{{ route('memberLoginAction') }}",
                dataType: 'json',
                data: formData,
                beforeSend: function () {
                    if ($(`.form-control`).hasClass('is-invalid')) {
                        $(`.form-control`).removeClass('is-invalid')
                    }
                    //btn.html('<div class="spinner-border text-white me-2 align-self-center loader-sm "></div> Loading').attr('disabled', true)
                    var loaderContainer = $(
                        '<div class="d-flex align-items-center justify-content-center"></div>'
                    );
                    var spinner = $(
                        '<div class="spinner-border text-white me-2 loader-sm"></div>');
                    var loadingText = $('<div class="ms-1">Loading</div>');

                    loaderContainer.append(spinner).append(loadingText);
                    btn.html(loaderContainer).attr('disabled', true);
                },
                success: function (res) {
                    // main.notification(res.message, NOTIFICATION_COLOR.SUCCESS)
                    localStorage.setItem('menu', JSON.stringify(res.data.menu))
                    window.location.href = "{{ route('dashboard.view') }}";
                    // alert('dashboard.view')
                },
                error: function (res) {
                    var response = res.responseJSON;
                    btn.html('SIGN IN').attr('disabled', false)

                    if (typeof response.error === 'object') {
                        Object.keys(response.error).map((i) => {
                            var message = response.error[i];
                            $(`input[name="${i}"]`).addClass('is-invalid')
                            $(`#feedback-${i}`).addClass('invalid-feedback').html(
                                message)
                        })
                    } else {
                        // Tampilkan pesan kesalahan dari respons langsung
                        var errorMessage = response.message;
                        if (errorMessage) {
                            messageLogin.html(` <div class="alert alert-danger alert-dismissible" role="alert">
                                    <i class="fa fa-warning mr-2"></i>
                                    <small class="text-muted">${errorMessage}</small>
                                </div>`).removeClass('hide').addClass('show');
                        }
                    }
                },
                done: function () {}
            })
        })
        $('#togglePassword').on('click', function () {
            var passwordInput = $('#form_password');
            var type = passwordInput.attr('type') === 'password' ? 'text' : 'password';
            passwordInput.attr('type', type);
            $(this).find('i').toggleClass('fa-eye fa-eye-slash');
        })
    });

</script>
@endsection
