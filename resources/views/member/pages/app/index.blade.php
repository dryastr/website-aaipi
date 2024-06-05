@extends('member.layouts.master')

@section('title', 'Home')

@section('content')
    {{-- Konten halaman home --}}
    <div id="home" class="row">
        <section class="about-me line col-md-12 padding_30 padbot_45">
            <div id="about-content">
                <p>Berikut adalah daftar aplikasi yang saat ini tersedia sebagai sarana pembantu dalam menjalankan program kerja Asosiasi. Aplikasi-aplikasi ini telah dipilih dengan cermat berdasarkan evaluasi kebutuhan dan tujuan organisasi serta kemampuan teknologi terkini. Dalam pemilihan tersebut, kami memastikan bahwa setiap aplikasi dapat memberikan kontribusi yang signifikan dalam mendukung efisiensi, produktivitas, dan kesinambungan program kerja Asosiasi.</p>
            </div>
            @if((optional($user['registration'])['status_approval']<>'disetujui' && $user['role_id']==3) || count($tagihans) >0)
            <div class="alert alert-danger alert-dismissible" role="alert" style="margin-top: 20px;">
                <i class="fa fa-info-circle mr-2"></i>
                <small class="text-muted">Mohon aktifkan keanggotaan AAIPI Anda untuk mengakses fitur ini</small>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
        </section>
        <section class="services line graybg col-md-12 padding_50 padbot_50">
            <div class="section-title bottom_45"><span></span><h2>Daftar Aplikasi AAIPI SSO</h2></div>
            <div class="row equal">
                <!-- a service -->

                    @if((optional($user['registration'])['status_approval']<>'disetujui' && $user['role_id']==3) || count($tagihans) > 0 )
                    <div class="col-md-4 col-sm-6 col-xs-12 h-100">
                        <a href="#">
                            <div class="service" style="height: 100%;">
                                <div class="icon">
                                    <i class="flaticon-brainstorming"></i>
                                </div>
                                <span class="title">AAIPI Learning Center</span>
                                <p class="little-text">Aplikasi Pelatihan Terintegrasi.</p>
                            </div>
                            </a>
                        </div>
                        <!-- a service -->
                        <div class="col-md-4 col-sm-6 col-xs-12 h-100">
                            <a href="#">
                            <div class="service" style="height: 100%;">
                                <div class="icon">
                                    <i class="flaticon-attach"></i>
                                </div>
                                <span class="title">Kertas Kerja TSE</span>
                                <p class="little-text">Aplikasi Kerja Pintar TSE.</p>
                            </div>
                            </a>
                        </div>
                    @else
                        <div class="col-md-4 col-sm-6 col-xs-12 h-100">
                        <a href="https://dev-lms.aaipi.id/landing/{{$app_token}}" target="_blank">
                            <div class="service" style="height: 100%;">
                                <div class="icon">
                                    <i class="flaticon-brainstorming"></i>
                                </div>
                                <span class="title">AAIPI Learning Center</span>
                                <p class="little-text">Aplikasi Pelatihan Terintegrasi.</p>
                            </div>
                            </a>
                        </div>
                        <!-- a service -->
                        <div class="col-md-4 col-sm-6 col-xs-12 h-100">
                            <a href="https://ts.aaipi.id/auth/sso/{{$app_token}}" target="_blank">
                            <div class="service" style="height: 100%;">
                                <div class="icon">
                                    <i class="flaticon-attach"></i>
                                </div>
                                <span class="title">Kertas Kerja TSE</span>
                                <p class="little-text">Aplikasi Kerja Pintar TSE.</p>
                            </div>
                            </a>
                        </div>
                    @endif

            </div>
        </section>

    </div>
@endsection

@push('scripts')

@endpush
