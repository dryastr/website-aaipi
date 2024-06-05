@extends('layouts.master')

@section('content')

<main class="main">


<!-- Registrasi area -->
<div class="row  contact-wrapper py-120">
    <div class="col-lg-5">
        <img src="{{asset('assets/img/bg-verified.png')}}" alt="">
    </div>
    <div class="col-lg-7">


        <div class="jumbotron">
            <h4 ><i class="fa fa-check-circle green"></i> Registrasi Berhasil</h4>
            <p class="lead message-response">{{$message}}</p>
            @isset($data)
            <form id="registrasi-aktifasi-form" class="fade show">
                <input type="hidden" name="kode" value="{{$data['kode']}}"/>
                <input type="hidden" name="email" value="{{$data['email']}}"/>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mt-1 mb-3">
                                <label>Password</label>
                                <input type="password" class="form-control" name="password">
                                <div id="feedback-password" class=""></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label>Konfirmasi Password</label>
                                <input type="password" class="form-control" name="password_confirmation">
                                <div id="feedback-password_confirmation" class=""></div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-danger w-100 mb-3 btn-proses">Proses</button>

                </div>
            </form>
            @endisset
            <hr class="my-4">
            <p class="lead">
              <a class="btn btn-primary btn-danger" href="{{route('memberArea.index')}}" role="button">Masuk Member Area</a>
            </p>
          </div>
        </div>
</div>
<!-- end Registrasi area -->

</main>

@isset($data)

@section('js')
<script>
    $(document).ready(function(){
        var form = $('#registrasi-aktifasi-form');
        var btn = $('.btn-proses');

        form.on('submit', function(e){
            e.preventDefault();
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var formData = new FormData(form[0]);
            formData.append('_token', csrfToken);
            $.ajax({
                type: 'POST',
                enctype: 'multipart/form-data',
                url: "{{route('memberArea.setup-password')}}",
                processData: false,
                contentType: false,
                data: formData,
                beforeSend: function(){
                    if($(`.form-control`).hasClass('is-invalid')){
                        $(`.form-control`).removeClass('is-invalid')
                    }
                    btn.html('<i class="fal fa-spinner fa-spin"></i> Loading').attr('disabled', true)
                },
                success: function(res){
                    btn.html('Proses').attr('disabled', false)
                    form[0].reset();
                    form.addClass('d-none');
                    $('.message-response').html(res.message);
                },
                error: function(res){
                    var response = res.responseJSON;
                    btn.html('Proses').attr('disabled', false)
                    if(typeof res.responseJSON.errors === 'object'){
                        Object.keys(response.errors).map((i) => {
                            var message = response.errors[i];
                            $(`input[name="${i}"]`).addClass('is-invalid')
                            $(`#feedback-${i}`).addClass('invalid-feedback').html(message)
                        })
                    }
                }
            })
        })
    })
</script>
@endsection

@endisset

@endsection
