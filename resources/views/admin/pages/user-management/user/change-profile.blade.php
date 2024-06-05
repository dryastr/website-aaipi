<x-base-layout :title="$title">
    <div class="row layout-top-spacing">
        <div class="col-md-12 layout-spacing">
            <div class="widget widget-table-one">
                <div class="widget-heading">
                    <h5 class="">{{$title}}</h5>
                </div>
                <div class="widget-content">
                    <ul class="nav nav-pills" id="animateLine" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="animated-underline-home-tab" data-bs-toggle="tab" href="#animated-underline-home" role="tab" aria-controls="animated-underline-home" aria-selected="true">
                                <i class="fas fa-id-card"></i> Informasi Umum
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="animated-underline-profile-tab" data-bs-toggle="tab" href="#animated-underline-profile" role="tab" aria-controls="animated-underline-profile" aria-selected="false" tabindex="-1">
                                <i class="fas fa-unlock-alt"></i> Ubah Password
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" id="animateLineContent-4">
                        <div class="tab-pane fade show active" id="animated-underline-home" role="tabpanel" aria-labelledby="animated-underline-home-tab">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                    <h4 class="mt-3">Informasi Umum</h4>
                                    <form id="form-data" method="POST" novalidate>
                                        <div class="row mb-4">
                                            <div class="form-group col-md-6">
                                                <label for="name">Nama</label>
                                                <input type="text" class="form-control" name="name" required>
                                                <div id="feedback-name" class=""></div>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="form-group col-md-6">
                                                <label for="email">Email</label>
                                                <input type="email" class="form-control" name="email" required>
                                                <div id="feedback-email" class=""></div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-submit">Simpan</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="animated-underline-profile" role="tabpanel" aria-labelledby="animated-underline-profile-tab">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                    <h4 class="mt-3">Ubah Password</h4>
                                    <form id="form-change-password" method="POST" novalidate>
                                        <div class="row mb-4">
                                            <div class="form-group col-md-6">
                                                <label for="name">Password Lama</label>
                                                <input type="text" class="form-control" name="name" required>
                                                <div id="feedback-name" class=""></div>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="form-group col-md-6">
                                                <label for="email">Password Baru</label>
                                                <input type="email" class="form-control" name="email" required>
                                                <div id="feedback-email" class=""></div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-submit">Simpan</button>
                                    </form>
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
                var btn = $('.btn-submit');
                var form = $('#form-data')
                form.on('submit', function(e){
                    e.preventDefault();
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    var formData = form.serializeArray();
                    formData.push({name: '_token', value: csrfToken})
                    $.ajax({
                        type: 'POST',
                        url: "{{route('user-management.role.store')}}",
                        dataType: 'json',
                        data: formData,
                        beforeSend: function(){
                            btn.html('<div class="spinner-border text-white me-2 align-self-center loader-sm "></div> Loading').attr('disabled', true)
                        },
                        success: function(res){
                            main.notification(res.message, NOTIFICATION_COLOR.SUCCESS)
                            window.location.href = "{{route('user-management.role.index')}}";
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
