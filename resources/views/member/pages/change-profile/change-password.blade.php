@extends('member.layouts.master')

@section('title', 'Home')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    {{-- Konten halaman home --}}
    <div class="row">
        <section class="about-me line col-md-12 padding_30 padbot_45">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="section-title bottom_30"><span></span><h2>{{ $title }}</h2></div>
                        </div>
                        <div class="col-md-6" style="text-align: right">
                            <!-- Tambahkan tombol kembali -->
                            {{-- --}}
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li style="padding-left: 10px;">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form action="{{ route('member.change-password.action') }}" method="POST" enctype="multipart/form-data" class="g-3">
                        @csrf
                        <div class="row">
                            <div class="col-md-6" style="margin-bottom: 2rem">
                                <label class="form-label">Password Lama</label>
                                <input type="password" class="form-control" name="current_password">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6" style="margin-bottom: 2rem">
                                <label class="form-label">Password Baru</label>
                                <div class="form-group">
                                    <div style="display: flex; border: 1px solid #ced4da; border-radius: 4px;">
                                        <input id="change_password" type="password" class="form-control-password"
                                            name="new_password">
                                        <button type="button" class="btn-eye" id="toggleChangePassword"><i
                                                class="fa fa-eye"></i></button>
                                    </div>
                                    @if ($errors->has('new_password'))
                                        <span
                                            style="color: red; font-size: 12px; margin-top: 2px;">{{ 'Password Baru wajib diisi' }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6" style="margin-bottom: 2rem">
                                <label class="form-label">Konfirmasi Password Baru</label>
                                <div class="form-group">
                                    <div style="display: flex; border: 1px solid #ced4da; border-radius: 4px;">
                                        <input id="confirm_change_password" type="password" class="form-control-password"
                                            name="new_password_confirmation">
                                        <button type="button" class="btn-eye" id="toggleConfirmChangePassword"><i
                                                class="fa fa-eye"></i></button>
                                    </div>
                                    @if ($errors->has('new_password_confirmation'))
                                        <span
                                            style="color: red; font-size: 12px; margin-top: 2px;">{{ 'Konfirmasi password wajib diisi' }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                            <div class="" style="margin-bottom: 2rem">
                                <button type="submit" class="btn btn-success">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection

<style>
    .input-group {
        display: block !important;
    }
    .form-control-password {
        width: calc(100% - 32px);
        display: block;
        height: 34px;
        padding: 6px 12px;
        font-size: 14px;
        line-height: 1.42857143;
        color: #555;
        background-color: #fff;
        background-image: none;
        border-radius: 4px;
        border: none;
    }
    .btn-eye {
        display: inline-block;
        padding: 6px 12px;
        margin-bottom: 0;
        font-size: 14px;
        font-weight: normal;
        line-height: 1.42857143;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        -ms-touch-action: manipulation;
        touch-action: manipulation;
        cursor: pointer;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        background-image: none;
        border: 1px solid transparent;
        border-radius: 4px;
        background-color: #fff;
    }
</style>

@push('scripts')
<script>
     $('#toggleChangePassword').on('click', function() {
                var changePasswordInput = $('#change_password');
                var type = changePasswordInput.attr('type') === 'password' ? 'text' : 'password';
                changePasswordInput.attr('type', type);
                $(this).find('i').toggleClass('fa-eye fa-eye-slash');
    })
    $('#toggleConfirmChangePassword').on('click', function() {
                var confirmChangePasswordInput = $('#confirm_change_password');
                var type = confirmChangePasswordInput.attr('type') === 'password' ? 'text' : 'password';
                confirmChangePasswordInput.attr('type', type);
                $(this).find('i').toggleClass('fa-eye fa-eye-slash');
    })
</script>
@endpush
