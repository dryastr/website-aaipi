@extends('layouts.master')

@section('content')
<main class="main">

    <!-- breadcrumb -->
    <div class="site-breadcrumb" style="background: url('{{ $image_banner }}')">
        <div class="container">
            <h2 class="breadcrumb-title">{{$title_banner}}</h2>
            <ul class="breadcrumb-menu">
                <li><a href="/">Home</a></li>
                <li class="active">Keanggotaan</li>
            </ul>
        </div>
    </div>
    <!-- breadcrumb end -->


    <!-- team-area -->
    <div class="team-area pt-120 pb-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mx-auto">
                    <div class="site-heading text-center">
                        <span class="site-title-tagline"><i class="fa-solid fa-users"></i> KEANGGOTAAN AAIPI</span>
                        <!-- <h2 class="site-title">ANGGOTA <span>AAIPI</span></h2> -->
                    </div>
                </div>
            </div>
            <!-- <div class="row mt-5">
                @foreach ($data as $row)
                <div class="col-md-6 col-lg-3">
                    <div class="team-item wow fadeInUp" data-wow-delay=".25s">
                        <div class="team-img">
                            <img class="mt-0"
                                src="{{asset($row['avatar_url'] ? $row['avatar_url'] : 'assets/img/user.png')}}"
                                alt="thumb">
                        </div>
                        <div class="team-content me-0">
                            <div class="team-bio">
                                <h5><a href="#">{{$row['fullname']}}</a></h5>
                                <span>{{$row['role']['name']}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>

            @if ($data->hasPages())

            <div class="pagination-area">
                <div aria-label="Page navigation example">
                    <ul class="pagination">

                        @if (!$data->onFirstPage())

                        <li class="page-item">
                            <a class="page-link" href="{{$data->previousPageUrl()}}" aria-label="Previous">
                                <span aria-hidden="true"><i class="far fa-arrow-left"></i></span>
                            </a>
                        </li>

                        @endif

                        @for ($i = 1; $i <= $data->lastPage(); $i++)
                            @if ($i >= $data->currentPage() - 2 && $i <= $data->currentPage() + 2)
                                <li @class(["page-item", "active"=> $data->currentPage() == $i ])>
                                    <a class="page-link" href="{{$data->url($i)}}">{{$i}}</a>
                                </li>
                                @endif

                                @endfor

                                @if (!$data->onLastPage())
                                <li class="page-item">
                                    <a class="page-link" href="{{$data->nextPageUrl()}}" aria-label="Next">
                                        <span aria-hidden="true"><i class="far fa-arrow-right"></i></span>
                                    </a>
                                </li>
                                @endif
                    </ul>
                </div>
            </div>

            @endif -->

            <div class="row">
                <div class="col-12 col-md-6 image-wrapper">
                    <div class="call-content-keanggotaan">
                        <h3>Keuntungan menjadi anggota AAIPI</h3>
                        <div class="d-flex align-items-center justify-content-center">
                            <img src="assets/img/keuntungan-member.png" alt="" style="width: 50%">
                        </div>
                        <p>Berikut adalah beberapa keuntungan menjadi anggota aaipi:</p>
                        <div class="contact-form">
                            <div class="choose-wrapper">
                                <div class="choose-item">
                                    <div class="choose-icon-keanggotaan">
                                        <i class="fa-solid fa-check"></i>
                                    </div>
                                    <div class="choose-item-content">
                                        <p>
                                            Bergabung dengan AAIPI memberi Anda status sebagai anggota resmi,
                                            profesional
                                            yang ekslusif.
                                        </p>
                                    </div>
                                </div>
                                <div class="choose-item">
                                    <div class="choose-icon-keanggotaan">
                                        <i class="fa-solid fa-check"></i>
                                    </div>
                                    <div class="choose-item-content">
                                        <p>
                                            Anda mendapatkan akses gratis ke Learning Management System (LMS) AAIPI
                                            untuk meningkatkan pengetahuan dan keterampilan Anda.
                                        </p>
                                    </div>
                                </div>
                                <div class="choose-item">
                                    <div class="choose-icon-keanggotaan">
                                        <i class="fa-solid fa-check"></i>
                                    </div>
                                    <div class="choose-item-content">
                                        <p>
                                            Anggota AAIPI mendapatkan akses gratis ke berbagai sumber daya Learning
                                            Management System (LMS).
                                        </p>
                                    </div>
                                </div>
                                <div class="choose-item">
                                    <div class="choose-icon-keanggotaan">
                                        <i class="fa-solid fa-check"></i>
                                    </div>
                                    <div class="choose-item-content">
                                        <p>
                                            Anda dapat berkontribusi sebagai penulis konten.
                                        </p>
                                    </div>
                                </div>
                                <div class="choose-item">
                                    <div class="choose-icon-keanggotaan">
                                        <i class="fa-solid fa-check"></i>
                                    </div>
                                    <div class="choose-item-content">
                                        <p>
                                            Bergabung dengan AAIPI memberi Anda akses ke komunitas yang bersemangat
                                            tentang pengembangan profesi dan pertukaran ide.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 image-wrapper">
                    <img src="assets/img/infografis-anggota-biasa.png" alt="" style="height: 100%;">
                </div>
            </div>

            <div class="py-120">
                <div class="hero-section" style="height: 100%">
                    <div class="hero-shape">
                        <div class="hero-shape-1"></div>
                        <div class="hero-shape-2"></div>
                        <div class="hero-shape-3"></div>
                        <div class="hero-shape-4"></div>
                        <div class="hero-shape-5"></div>
                        <div class="hero-shape-6"></div>
                    </div>
                    <div class="call-content-keanggotaan">
                        <div class="row flex-column flex-lg-row">
                            <div class="col-lg-4 order-lg-last">
                                <div class="d-flex justify-content-center align-item-center">
                                    <img src="assets/img/persyaratan-member.png" alt="">
                                </div>
                            </div>
                            <div class="col-lg-8 order-lg-first">
                                <div class="contact-form row">
                                    <div class="">
                                        <div class="jumbotron message-registrasi-luarbiasa fade hide">
                                        </div>
                                        <div class="contact-form-header">
                                            <h2>Daftar Persyaratan Menjadi Anggota AAIPI</h2>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <ol>
                                                    @foreach ($persyaratan as $item)
                                                    <li style="list-style: decimal">
                                                        <div>{{$item['title']}}</div>
                                                        <ul class="ms-3">
                                                            @foreach ($item['childrens'] as $itemc)
                                                            <li style="list-style: disc">{{$itemc['title']}}</li>
                                                            @endforeach
                                                        </ul>
                                                    </li>
                                                    @endforeach
                                                </ol>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="py-12">
                            <div class="row mt-5">
                                <div class="col-lg-4 mb-5">
                                    <div class="counter-box">
                                        <div class="icon-keanggotaan">
                                            <i class="icon-project-management"></i>
                                        </div>
                                        <div>
                                            <span class="counter-keanggotaan" data-count="+"
                                                data-to="{{ $jumlah_user['anggota_biasa'] }}"
                                                data-speed="3000">{{ $jumlah_user['anggota_biasa'] }}</span>
                                            <h6 class="title-keanggotaan">Anggota Biasa </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 mb-5">
                                    <div class="counter-box">
                                        <div class="icon-keanggotaan">
                                            <i class="icon-review"></i>
                                        </div>
                                        <div>
                                            <span class="counter-keanggotaan" data-count="+"
                                                data-to="{{ $jumlah_user['anggota_luar_biasa'] }}"
                                                data-speed="3000">{{ $jumlah_user['anggota_luar_biasa'] }}</span>
                                            <h6 class="title-keanggotaan">Anggota Luar Biasa</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 mb-5">
                                    <div class="counter-box">
                                        <div class="icon-keanggotaan">
                                            <i class="icon-worker-1"></i>
                                        </div>
                                        <div>
                                            <span class="counter-keanggotaan" data-count="+"
                                                data-to="{{ $jumlah_user['anggota_kehormatan'] }}"
                                                data-speed="3000">{{ $jumlah_user['anggota_kehormatan'] }}</span>
                                            <h6 class="title-keanggotaan">Anggota Kehormatan</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- <div class="container mt-5 content-container">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <img src="assets/img/infografis-anggota-biasa.png" alt="" style="height: 100%;">
                    </div>
                </div>
            </div> -->

            <div class="container content-container">
                <div class="row">
                    <div class="col-md-6 image-wrapper">
                        <img src="assets/img/infografis-aaipi.png" alt="" style="height: 100%;">
                    </div>
                    <div class="col-md-6 image-wrapper">
                        <img src="assets/img/infografis-anggota-kehormatan.png" alt="" style="height: 100%;">
                    </div>
                </div>
            </div>

            <!-- <div class="container mt-5 content-container">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <img src="assets/img/infografis-anggota-kehormatan.png" alt="" style="height: 100%;">
                    </div>
                </div>
            </div> -->
        </div>
    </div>


    <!-- team-area end -->

</main>
@endsection
