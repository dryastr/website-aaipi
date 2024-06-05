@extends('admin.pages.profile.index')

@section('content')

<div class="row">
    <div class="col-lg-12 mx-auto">
        <form id="form-change-password">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label>Password Lama</label>
                        <input type="password" class="form-control" name="current_password">
                        <div id="feedback-current_password" class=""></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mt-1 mb-3">
                        <label>Password Baru</label>
                        <input type="password" class="form-control" name="new_password">
                        <div id="feedback-new_password" class=""></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label>Konfirmasi Password Baru</label>
                        <input type="password" class="form-control" name="new_password_confirmation">
                        <div id="feedback-new_password_confirmation" class=""></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mt-1">
                    <div class="form-group text-end">
                        <button type="submit" class="btn btn-success btn-submit">Simpan Perubahan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('footerFile')
<script>
    $(document).ready(function(){
        var form = $('#form-change-password');
        var btn = $('.btn-submit');

        form.on('submit', function(e){
            e.preventDefault();
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var formData = new FormData(form[0]);
            formData.append('_token', csrfToken)
            $.ajax({
                type: 'POST',
                enctype: 'multipart/form-data',
                url: "{{route('profile.change-password-action')}}",
                processData: false,
                contentType: false,
                data: formData,
                beforeSend: function(){
                    if($(`.form-control`).hasClass('is-invalid')){
                        $(`.form-control`).removeClass('is-invalid')
                    }
                    btn.html('<div class="spinner-border text-white me-2 align-self-center loader-sm "></div> Loading').attr('disabled', true)
                },
                success: function(res){
                    main.notification(res.message, NOTIFICATION_COLOR.SUCCESS)
                    btn.html('Simpan Perubahan').attr('disabled', false)
                    window.location.href = "{{route('profile.change-password')}}";
                },
                error: function(res){
                    var response = res.responseJSON;
                    btn.html('Simpan Perubahan').attr('disabled', false)
                    main.notification(response.message, NOTIFICATION_COLOR.DANGER)
                    console.log(res.responseJSON.errors)
                    if(typeof res.responseJSON.errors === 'object'){
                        Object.keys(response.errors).map((i) => {
                            var message = response.errors[i];
                            $(`input[name="${i}"]`).addClass('is-invalid')
                            $(`textarea[name="${i}"]`).addClass('is-invalid')
                            $(`#feedback-${i}`).addClass('invalid-feedback').html(message)
                        })
                    }
                },
            });
        })
    })
</script>
@endpush
