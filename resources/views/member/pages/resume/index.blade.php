@extends('member.layouts.master')

@section('title', 'Home')
@section('resume-tab', 'active')

@section('content')
    {{-- Konten halaman home --}}
    <div id="resume">
        <!-- Resume Section -->
        <div class="row">
            <section class="education">
            <div class="section-title top_30 bottom_30"><span></span><h2>Resume</h2></div>

            <div class="alert alert-info alert-dismissible" role="alert">
                <i class="fa fa-info-circle mr-2"></i>
                <small class="text-muted">Pelatihan yang anda pilih</small>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true"></span>
                </button>
            </div>

         @if($user['role_id']==2)
            @if(isset($pangkatJabatan))
            <div class="alert alert-info alert-dismissible" role="alert">
                <i class="fa fa-info-circle mr-2"></i>
                <small class="text-muted">Interopability riwayat pangkat dan jabatan</small>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="row">
                    <!-- Jabatan History -->
                    <div class="education-history col-md-6 padding_15 padbot_30">

                        <ul class="timeline col-md-12 top_30">
                            <li><i class="fa fa-graduation-cap" aria-hidden="true"></i><h2 class="timeline-title">Riwayat Jabatan</h2></li>
                            <!-- a work -->
                            <ul>
                                @if(isset($pangkatJabatan['data']['jenjang_jabatan']))
                                    <li>
                                        <h3 class="line-title">{{ $pangkatJabatan['data']['jenjang_jabatan']['nama_jenjang_jabatan'] }}</h3>
                                        <span>{{ \Carbon\Carbon::parse($pangkatJabatan['data']['jabatan']['tanggal_sk_jabatan'])->format('d F Y') }}</span>
                                        <p class="little-text">SK: {{ $pangkatJabatan['data']['jabatan']['nomor_sk_jabatan'] }}</p>
                                    </li>
                                @endif
                            </ul>
                        </ul>

                    </div>

                    <!-- Pangkat History -->
                    <div class="working-history col-md-6 padding_15 padbot_30">
                        <ul class="timeline col-md-12 top_30">
                            <li><i class="fa fa-suitcase" aria-hidden="true"></i><h2 class="timeline-title">Riwayat Pangkat</h2></li>
                            <!-- a work -->

                            @if(isset($pangkatJabatan['data']['pangkat']) && $pangkatJabatan['data']['pangkat'] !== null)
                            <li>
                                <h3 class="line-title">{{$pangkatJabatan['data']['pangkat']['nama_pangkat']}}</h3>
                                <span>{{ \Carbon\Carbon::parse($pangkatJabatan['data']['pangkat']['tmt_pangkat'])->format('d F Y') }}</span>
                                <p class="little-text">SK: {{$pangkatJabatan['data']['pangkat']['nomor_sk_pangkat']}} </p>
                            </li>
                           @endif

                        </ul>
                    </div>

                </div>
                @else
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <i class="fa fa-info-circle mr-2"></i>
                    <small class="text-muted">Sistem interop data pegawai APIP masih dalam proes non teknis</small>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
            @endif
            </section>
        </div>

        <div class="row">
            <section class="education">
            <div class="section-title top_30 bottom_30"><span></span><h2>Pelatihan Saya</h2></div>

            <div class="row equal">
                <!-- a service -->
                @if($user['role_id']==2 && isset($pelatihan))
                @if(count($pelatihan['data'])>0)
                    @foreach($pelatihan['data'] as $pelatihan)
                    <div class="col-md-4 col-sm-6 col-xs-12 h-100">
                        <div class="service" style="height: 100%;">
                            <div class="icon">
                                <i class="flaticon-attach"></i>
                            </div>
                            <span class="title">{{$pelatihan['nama_kompetensi']}}</span>
                            <p class="little-text">{{$pelatihan['nama_diklat']}}</p>

                            @if($pelatihan['valid'] == 1)
                                {{-- <span class="badge badge-success">Valid</span> --}}
                                {{-- Or use an icon --}}
                                <i class="fa fa-check"></i>
                            @else
                                {{-- <span class="badge badge-danger">Tidak Valid</span> --}}
                                {{-- Or use an icon --}}
                                <i class="fa fa-times"></i>
                            @endif

                        </div>
                    </div>
                    @endforeach
                @else
                <div class="col-md-4 col-sm-6 col-xs-12 h-100">
                    <a href="https://dev-lms.aaipi.id" targer="_blank">
                        <div class="service justify-content-center row" style="border: 3px dashed #CCC; height: 100%;">
                            <div class="icon plus" style="text-align: center; padding: 30px;">
                                <i class="fa fa-plus"></i>
                            </div>
                        </div>
                    </a>
                </div>
                @endif
                @else
                    <div class="col-md-4 col-sm-6 col-xs-12 h-100">
                        <a href="https://dev-lms.aaipi.id" targer="_blank">
                            <div class="service justify-content-center row" style="border: 3px dashed #CCC; height: 100%;">
                                <div class="icon plus" style="text-align: center; padding: 30px;">
                                    <i class="fa fa-plus"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                <!-- a service -->

            </div>

            {{-- <div class="row d-flex justify-content-center">
                <div class="col-md-12 col-12" style="text-align: center !important;">
                    <img src="{{ asset('src/member/images/404_sertifikat.png') }}" alt="404 Pelatihan" class="img-fluid mx-auto d-block">
                </div>
            </div> --}}

            </section>
        </div>
    </div>
@endsection
