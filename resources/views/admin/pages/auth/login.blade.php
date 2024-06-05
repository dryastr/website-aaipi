<x-base-layout title="Login">
    <x-slot name="headerFiles">
        <link href="{{asset('layouts/modern-light-menu/css/light/plugins.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('src/assets/css/light/authentication/auth-cover.css')}}" rel="stylesheet" type="text/css" />
    </x-slot>
    <div class="auth-container d-flex">

        <div class="container mx-auto align-self-center">

            <div class="row">

                <div class="col-6 d-lg-flex d-none h-100 my-auto top-0 start-0 text-center justify-content-center flex-column">
                    <div class="auth-cover-bg-image"></div>
                    <div class="auth-overlay"></div>

                    <div class="auth-cover">

                        <div class="position-relative">

                            <img src="{{asset('src/assets/img/auth-cover.svg')}}" alt="auth-img">

                            <h2 class="mt-5 text-white font-weight-bolder px-2">AAIPI Login Panel</h2>
                            <p class="text-white px-2">Asosisasi Auditor Intern Pemerintah Indonesia</p>
                        </div>

                    </div>

                </div>

                <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-8 col-12 d-flex flex-column align-self-center ms-lg-auto me-lg-0 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <form id="form-login" method="POST" novalidate>
                                <div class="row">
                                    <div class="col-md-12 mb-3">

                                        <h2>Sign In</h2>
                                        <p>Enter your email and password to login</p>

                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input name="email" type="email" class="form-control" value="admin@mail.com" required>
                                            <div id="feedback-email" class="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-4">
                                            <label class="form-label">Password</label>
                                            <input name="password" type="password" class="form-control" value="Password123" required>
                                            <div id="feedback-password" class="">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-4">
                                            <button type="submit" class="btn btn-secondary btn-login w-100">SIGN IN</button>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="text-center">
                                            <p class="mb-0">Dont't have an account ? <a href="{{route('memberArea.index')}}" class="text-warning">Sign Up</a></p>
                                        </div>
                                    </div>

                                </div>
                            </form>

                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <x-slot name="footerFiles">
        <script>
            $(document).ready(function(){
                var btn = $('.btn-login');
                var form = $('#form-login')
                form.on('submit', function(e){
                    e.preventDefault();
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    var formData = form.serializeArray();
                    formData.push({name: '_token', value: csrfToken})
                    $.ajax({
                        type: 'POST',
                        url: "{{route('loginAction')}}",
                        dataType: 'json',
                        data: formData,
                        beforeSend: function(){
                            if($(`.form-control`).hasClass('is-invalid')){
                                $(`.form-control`).removeClass('is-invalid')
                            }
                            btn.html('<div class="spinner-border text-white me-2 align-self-center loader-sm "></div> Loading').attr('disabled', true)
                        },
                        success: function(res){
                            main.notification(res.message, NOTIFICATION_COLOR.SUCCESS)
                            localStorage.setItem('menu', JSON.stringify(res.data.menu))
                            window.location.href = "{{route('dashboard.admin.view')}}";
                        },
                        error: function(res){
                            var response = res.responseJSON;
                            btn.html('SIGN IN').attr('disabled', false)
                            main.notification(response.message, NOTIFICATION_COLOR.DANGER)
                            if(typeof res.responseJSON.error === 'object'){
                                Object.keys(response.error).map((i) => {
                                    var message = response.error[i];
                                    $(`input[name="${i}"]`).addClass('is-invalid')
                                    $(`#feedback-${i}`).addClass('invalid-feedback').html(message)
                                })
                            }
                            // form.addClass('was-validated')
                        },
                        done: function(){
                        }
                    })
                })

            })
        </script>
    </x-slot>

</x-base-layout>

