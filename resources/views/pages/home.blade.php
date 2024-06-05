@extends('layouts.master')

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.2.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.4.1/css/swiper.css">
<link rel="stylesheet" href="/assets/css/style.css">
<style>
    .feature-item {
        height: 250px;
        border-radius: 10;
        border: none;
        box-shadow: none;
        margin-bottom: 50px;
        width: 280px;
        color: #333333;
    }

    @keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}
</style>

@section('content')

    <main class="main">
        <!-- hero slider -->
        <div class="hero-section">
            <div class="hero-shape">
                <div class="hero-shape-1"></div>
                <div class="hero-shape-2"></div>
                <div class="hero-shape-3"></div>
                <div class="hero-shape-4"></div>
                <div class="hero-shape-5"></div>
                <div class="hero-shape-6"></div>
            </div>
            <div class="hero-slider owl-carousel owl-theme">
                @if (count($sliderBanner) > 0)
                    @foreach ($sliderBanner as $banner)
                        @if ($banner->type == 'standar')
                            <div class="hero-single"
                                style="background-image: url('{{ asset($banner->image_url) }}');  height: 600px;">
                                <div class="container">
                                    <div class="row align-items-center">
                                        <div class="col-md-12 col-lg-7">
                                            <div class="hero-content">
                                                <!-- <h6 class="hero-sub-title" data-animation="fadeInDown" data-delay=".25s">
                                                                        <i class="far fa-lightbulb-on"></i>Focus Group Discussion
                                                                    </h6> -->
                                                <h1 class="hero-title" data-animation="fadeInRight" data-delay=".50s">
                                                    {{ $banner->title }}
                                                </h1>
                                                <p data-animation="fadeInLeft" data-delay=".75s">
                                                    {!! strlen($banner->desc) > 350 ? substr($banner->desc, 0, 350) . '...' : $banner->desc !!}
                                                </p>
                                                @if ($banner->link)
                                                    <div class="hero-btn" data-animation="fadeInUp" data-delay="1s">
                                                        <a href="{{ $banner->link }}"
                                                            class="theme-btn theme-btn2">Selengkapnya<i
                                                                class="fas fa-arrow-right-long"></i></a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="hero-single hero-single-custom"
                                style="background-color: {{ $banner->color }};  height: 600px;">
                                <div class="container" style="height: 60rem">
                                    <div class="row align-items-center" style="height: 60rem">
                                        <div class="col-md-12">
                                            <div class="hero-content">
                                                <div class="card-banner">
                                                    <div class="d-flex align-items-center">
                                                        <div class="author-group col-md-6">
                                                            <div class="d-flex align-items-center justify-content-center">
                                                                <div class="image-banner-card">
                                                                    <img class="img-cover"
                                                                        src="{{ asset($banner->image_url) }}"
                                                                        alt="{{ $banner->title }}"
                                                                        style="border: none; height: -webkit-fill-available"
                                                                        data-animation="fadeInUp" data-delay=".55s">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="quote-group col-md-6">
                                                            <div class="quote-banner m-0" data-animation="fadeInUp"
                                                                data-delay=".75s">
                                                                <div class="d-flex flex-column">
                                                                    <div class="quote-card-left">
                                                                        <i class="fas fa-quote-left"></i>
                                                                    </div>
                                                                    <div data-animation="fadeInUp" data-delay=".75s">
                                                                        <p class="quote-desc" class="m-0">
                                                                            {!! strlen($banner->desc) > 350 ? substr($banner->desc, 0, 350) . '...' : $banner->desc !!}
                                                                        </p>
                                                                    </div>
                                                                    <span class="quote-author"data-animation="fadeInUp"
                                                                        data-delay=".85s">{{ $banner->title }}</span>
                                                                    <div class="quote-card-right">
                                                                        <i class="fas fa-quote-right"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @else
                    <div class="hero-single"
                        style="background-image: url('assets/img/slider/slider-3.jpg'); background-repeat: no-repeat; height: 20%;">
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-md-12 col-lg-7">
                                    <div class="hero-content">
                                        <!-- <h6 class="hero-sub-title" data-animation="fadeInDown" data-delay=".25s">
                                                    <i class="far fa-lightbulb-on"></i>Tidak ada banner
                                                </h6> -->
                                    </div>
                                    <div class="row g-0">
                                        <div class=" col-4">
                                            <p>Banner perlu ditambahkan</p>
                                        </div>
                                        <div class="col-8"><a href="{{ route('login') }}" target="_BLANK"
                                                class="text-light">Login untuk menambahkan</a>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <!-- hero slider end -->

        @if ($item_sejarah)
            <div class="about-area py-120">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <div class="about-left wow fadeInLeft" data-wow-delay=".25s">
                                <div class="about-img">
                                    <img src=" {{ $item_sejarah['image_url'] ? $item_sejarah['image_url'] : asset('assets/img/team/01.jpg') }}"
                                        alt="">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="about-right wow fadeInRight" data-wow-delay=".25s">
                                <div class="site-heading mb-3">
                                    <span class="site-title-tagline"><i class="far fa-lightbulb-on"></i> TENTANG
                                        KAMI</span>
                                    <h2 class="site-title">
                                        {{ $item_sejarah['title'] }}
                                    </h2>
                                </div>
                                <div class="about-item-content">
                                    {!! substr($item_sejarah['content'], 0, 500) !!} ...
                                    </p>

                                    <div class="about-content">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="about-item">
                                                    <div class="about-item-icon">
                                                        <i class="icon-power-plant"></i>
                                                    </div>
                                                    <div class="about-item-content">
                                                        <h5>Visi dan Misi</h5>
                                                        @if ($visimisi)
                                                            {!! $visimisi['content'] !!}
                                                        @else
                                                            <p>Silahkan isi Visi</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('about.visiDanMisi') }}" class="theme-btn mt-4">Selengkapnya<i
                                        class="fas fa-arrow-right-long"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            &nbsp;
        </div>

        <!-- feature area -->
        <div class="feature-area ft-bg py-120">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 mx-auto">
                        <div class="site-heading text-center">
                            <span class="site-title-tagline"><i class="far fa-lightbulb-on"></i> Produk dan layanan
                            </span>
                            <h2 class="site-title text-white">PRODUK <span>AAIPI</span></h2>
                        </div>
                    </div>
                </div>
                <div class="feature-wrapper">
                    <div class="row">
                        @if (count($fungsiUnitKerja) > 0)
                            @foreach ($fungsiUnitKerja as $item)
                                <div class="col-md-6 col-lg-3">
                                    <a href="{{ route('produk') . '#' . $item->id }}" class="feature-item wow fadeInUp"
                                        data-wow-delay=".25s">
                                        <div class="row align-items-center">
                                            <div class="col-4">
                                                <span class="count">0{{ $loop->iteration }}</span>
                                            </div>
                                            <div class="col-8">
                                                <h4 class="feature-title">{{ $item->title }}</h4>
                                            </div>
                                        </div>
                                        <p>{!! strlen(strip_tags($item->desc)) > 64
                                            ? substr(strip_tags($item->desc), 0, 64) . '...'
                                            : strip_tags($item->desc) !!}</p>
                                        <div class="mt-5">
                                            <h4 class="mb-2 fs-3 text-danger">Selengkapnya?</h4>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        @else
                            <div class="col-md-6 col-lg-3">
                                <div class="feature-item wow fadeInUp" data-wow-delay=".25s">
                                    <span class="count"></span>
                                    <div class="feature-icon">
                                        <i class="fa-sharp fa-light fa-empty-set"></i>
                                    </div>
                                    <h4 class="feature-title">Isi Fungsi dan Unit Kerja</h4>
                                    <a href="{{ route('login') }}" style="text-decoration: underline; color: blue">Login
                                        untuk
                                        menambahkan</a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- feature area end -->

        <!-- service-area -->
        <div class="service-area bg py-120">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 mx-auto">
                        <div class="site-heading text-center">
                            <span class="site-title-tagline"><i class="far fa-lightbulb-on"></i> PROGRAM KERJA</span>
                            <h2 class="site-title text-black">PROGRAM KERJA <span>AAIPI</span></h2>
                        </div>
                    </div>
                </div>



                <div class="row">
                    @foreach ($programkerja as $item)
                        <div class="col-md-6 col-lg-3">
                            <div class="service-item wow fadeInDown" data-wow-delay=".25s">
                                <div class="service-img">
                                    <img src="{{ $item->image_url }}" alt="Gambar Program Kerja"
                                        style="height: 200px; width: 100%">
                                    <div class="service-icon">
                                        <i class="icon-shield-1"></i>
                                    </div>
                                </div>
                                <div class="service-content">
                                    <h3 class="service-title">
                                        <a
                                            href="{{ route('home.prokerselengkapnya', $item->id) }}">{{ $item->title }}</a>
                                    </h3>
                                    <p class="service-text">
                                        {!! strlen(strip_tags($item->description)) > 100
                                            ? substr(strip_tags($item->description), 0, 100) . '...'
                                            : strip_tags($item->description) !!}
                                    </p>
                                    <div class="service-arrow">
                                        <a href="{{ route('home.prokerselengkapnya', $item->id) }}">Selengkapnya<i
                                                class="fas fa-arrow-right-long"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
        <!-- service-area -->


        <!-- counter area -->
        <div class="counter-area pt-50 pb-50">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="counter-box">
                            <div class="icon">
                                <i class="icon-project-management"></i>
                            </div>
                            <div>
                                <span class="counter" data-count="+" data-to="{{ $jumlah_user['anggota_biasa'] }}"
                                    data-speed="3000">{{ $jumlah_user['anggota_biasa'] }}</span>
                                <h6 class="title">+ Anggota Biasa </h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="counter-box">
                            <div class="icon">
                                <i class="icon-review"></i>
                            </div>
                            <div>
                                <span class="counter" data-count="+" data-to="{{ $jumlah_user['anggota_luar_biasa'] }}"
                                    data-speed="3000">{{ $jumlah_user['anggota_luar_biasa'] }}</span>
                                <h6 class="title">+ Anggota Luar Biasa</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="counter-box">
                            <div class="icon">
                                <i class="icon-worker-1"></i>
                            </div>
                            <div>
                                <span class="counter" data-count="+" data-to="{{ $jumlah_user['anggota_kehormatan'] }}"
                                    data-speed="3000">{{ $jumlah_user['anggota_kehormatan'] }}</span>
                                <h6 class="title">+ Anggota Kehormatan</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- counter area end -->


        <!-- portfolio-area -->
        <div class="portfolio-area py-120">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 d-lg-flex align-items-end justify-content-between mb-10">
                        <div class="site-heading mb-0">
                            <span class="site-title-tagline"><i class="far fa-lightbulb-on"></i> Galeri Foto</span>
                            <h2 class="site-title">Galeri Foto <span>AAIPI</span></h2>
                        </div>
                        <div class="filter-control">
                            <ul class="filter-btn">
                                <li class="active" data-filter="*">Semua</li>
                                @foreach ($category as $item)
                                    <li data-filter="{{ $item->id }}">{{ $item->title }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-10">
                    <div>
                        <span id="locationCode"></span><span id="dateCode"></span>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
                <div class="swiper-container overflow-hidden">
                    <div id="sliderGallery" class="swiper-wrapper"></div>
                </div>
                <div class="d-flex swiper-group-paginate">
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
        </div>
        <!-- portfolio-area end -->


        <!-- call-area -->
        <div class="call-area" style="background-image: url('{{ asset($sliderKontak) }}')">
            <div class="container">
                <div class="row align-items-stretch">
                    <div class="col-md-5 ms-lg-auto d-flex align-items-stretch">
                        <div class="call-content d-flex flex-column justify-content-between" style="width: 100%;">
                            <span><i class="far fa-lightbulb-on"></i> Layanan Kontak</span>
                            <h1>Butuh Bantuan Dengan Layanan Terbaik</h1>
                            <p>Selamat datang di portal layanan pemerintahan kami! Kami berkomitmen untuk
                                memberikan layanan
                                terbaik kepada masyarakat. Temukan informasi lengkap dan solusi terbaik di sini.
                            </p>
                            <div class="emergency-call">
                                <div class="emergency-call-icon"><i class="icon-telephone1"></i></div>
                                @if ($alamat)
                                    <div class="emergency-call-info">
                                        <h5 class="">{{ $alamat->title }}</h5>
                                        <h4 class="text-dark">{{ $alamat->content }}</h4>
                                    </div>
                                @else
                                    <div class="emergency-call-info">
                                        <h5 class="">Tidak ada konten</h5>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7 ms-lg-auto d-flex align-items-stretch">
                        <div class="call-content d-flex flex-column justify-content-between" style="width: 100%;">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d5513.128235585037!2d106.86338936005251!3d-6.195881712286157!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f45e3ea485ed%3A0x88df67baf969f29f!2sAAIPI!5e0!3m2!1sen!2sid!4v1708000945692!5m2!1sen!2sid"
                                style="border:0; width: 100%; height: 100%;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- faq area -->
        <div class="faq-area py-120">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="faq-right wow fadeInLeft" data-wow-delay=".25s">
                            <div class="site-heading mb-3">
                                <span class="site-title-tagline justify-content-start"><i class="far fa-lightbulb-on"></i>
                                    Forum Tanya Jawab</span>
                                <h2 class="site-title my-3">Pertanyaan umum <span>yang sering
                                        diajukan</span></h2>
                            </div>
                            <p class="mb-3">FAQ (Frequently Asked Questions) Asosiasi Auditor Intern Pemerintah
                                Indonesia (AAIPI) adalah sumber informasi penting bagi para profesional yang
                                terlibat dalam audit intern pemerintah di Indonesia.</p>
                            <div class="faq-img">
                                <img src="assets/img/faq/01.jpg" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="accordion wow fadeInUp" data-wow-delay=".25s" id="accordionExample">
                            @foreach ($pertanyaan as $key => $item)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading{{ $key }}">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse{{ $key }}" aria-expanded="true"
                                            aria-controls="collapse{{ $key }}">
                                            <span><i class="far fa-question"></i></span> {{ $item->pertanyaan }}
                                        </button>
                                    </h2>
                                    <div id="collapse{{ $key }}" class="accordion-collapse collapse"
                                        aria-labelledby="heading{{ $key }}" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            {{ $item->jawaban }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- faq area end -->

        <!-- team-area -->
        <!--<div class="team-area pt-120 pb-20">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6 mx-auto">
                                <div class="site-heading text-center">
                                    <span class="site-title-tagline"><i class="far fa-lightbulb-on"></i> Tim
                                        Kami</span>
                                    <h2 class="site-title">Dewan <span>Eksekutif</span></h2>
                                </div>
                            </div>
                        </div>-->
        <!--<div class="row mt-5">
                            @if (count($strukturOrganisasi) > 0)
    @foreach ($strukturOrganisasi as $item)
    <div class="col-md-6 col-lg-3">
                                <div class="team-item wow fadeInUp" data-wow-delay=".25s">
                                    <div class="team-img">
                                        <img src="{{ $item->image_url }}" alt="thumb">
                                    </div>
                                    <div class="team-content">
                                        <div class="team-bio">
                                            <h5><a href="team.html">{{ $item->jabatan }}</a></h5>
                                            <span>{{ $item->desc_jabatan }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
    @endforeach
@else
    <div class="text-center">
                                <h5 class="mb-4">Struktur Organisasi belum ditambahkan</h5>
                                <a href="{{ route('login') }}" target="_blank" class="theme-btn py-2 px-4">Login
                                    untuk menambahkan</a>
                            </div>
    @endif
                        </div>
                    </div>
                </div>
                </div>-->
        <!-- team-area end
                </div>
                </div>
                </div>-->
        <!-- cta-area -->
        <div class="cta-area pt-100">
            <div class="container">
                <div class="cta-wrapper wow fadeInUp" data-wow-delay=".25s">
                    <div class="row align-items-center">
                        <div class="col-lg-7 mx-auto">
                            <div class="cta-content">
                                <h1>menjadi anggota luar biasa</h1>
                                <p>Silahkan hubungi kami untuk menjadi anggota luar biasa dari Asosiasi Audit
                                    Internal Pemerintah Indonesia (AAIPI). </p>
                                <div class="cta-btn">
                                    <a href="{{ route('memberArea.index') }}" class="theme-btn">Hubungi Kami Sekarang<i
                                            class="fas fa-arrow-right-long"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- cta-area end -->

        <div class="cta-area pt-100">
            <div class="container">

            </div>
        </div>


        <div id="myModal" class="modal-home-banner">
            <div id="modalContent" class="modal-content-banner">
                <div id="imgBanner" class="img-banner-card">
                    <span class="close-banner" style="text-shadow: none"><i class="fi fi-rr-cross-circle"></i></span>
                    <a id="bannerLink" href="#">
                        <img class="img-cover img-banner" src="" alt="Banner Iklan">
                    </a>
                </div>
            </div>
        </div>


        {{-- {{ dd($adBanner['image']) }} --}}

        <!-- testimonial area -->
        @if ($sliderKursus)
            <div class="testimonial-area ts-bg py-120"
                style="background-image: url('{{ asset($sliderKursus->image_url) }}')">
            @else
                <div class="testimonial-area ts-bg py-120" style="background-image: url('assets/img/testimonial/bg.jpg')">
        @endif
        @if (isset($apiData['data']))
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 mx-auto">
                        <div class="site-heading text-center">
                            <span class="site-title-tagline"><i class="far fa-lightbulb-on"></i>
                                E-LMS</span>
                            <h2 class="site-title text-white">KURSUS <span>TERBARU</span></h2>
                        </div>
                    </div>
                </div>
                <div class="testimonial-slider owl-carousel owl-theme">
                    @isset($apiData['data'])
                        @foreach ($apiData['data'] as $item)
                            <div class="testimonial-single">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="testimonial-rate">
                                            @if ($item['rate'] >= 5)
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            @elseif ($item['rate'] >= 4)
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="far fa-star"></i>
                                            @elseif ($item['rate'] >= 3)
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                            @elseif ($item['rate'] >= 2)
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                            @elseif ($item['rate'] >= 1)
                                                <i class="fas fa-star"></i>
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-4 text-right">
                                        <span class="testimonial-quote-icon">{{ number_format($item['duration'] / 60, 1) }}
                                            JP</span>
                                    </div>
                                </div>
                                <div class="testimonial-quote">
                                    <a href="{{ $item['link'] }}" target="_BLANK">
                                        <p>{{ $item['title'] }}</p>
                                    </a>
                                </div>
                                <div class="row" style="margin-top: 40px">
                                    <div class="col-md-8">
                                        <div class="testimonial-content">
                                            <div class="testimonial-author-img">
                                                @if ($item['teacher'])
                                                    <img src="{{ $item['teacher']['avatar'] }}" alt="Teacher Avatar">
                                                @else
                                                    <img src="default-avatar.jpg" alt="Default Avatar">
                                                @endif
                                            </div>
                                            <div class="testimonial-author-info">
                                                @if ($item['teacher'])
                                                    <h4>{{ $item['teacher']['full_name'] }}</h4>
                                                @else
                                                    <h4>Teacher Name Not Available</h4>
                                                @endif
                                                <p>Kontributor</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endisset
                </div>
            </div>
        @else
            <div class="text-center fs-2 text-secondary">No Internet Connection</div>
        @endif
        </div>
        <!-- testimonial area end -->

        <!-- quote area -->
        <div class="quote-area pb-120">
            <div class="container">
                <div class="quote-wrapper">
                    <!-- <div class="row align-items-center">
                                                        <div class="col-lg-5">
                                                            <div class="quote-img">
                                                                <img src="assets/img/quote/01.jpg" alt="">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-7">
                                                            <div class="quote-content">
                                                                <div class="quote-header">
                                                                    <h6><i class="far fa-lightbulb-on"></i> Get Free Quote</h6>
                                                                    <h2>Do You Have Any Questions?</h2>
                                                                </div>
                                                                <form action="#">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <input type="text" name="name" class="form-control"
                                                                                    placeholder="Your Name">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <input type="email" name="email" class="form-control"
                                                                                    placeholder="Email Address">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <input type="text" name="subject" class="form-control" placeholder="Subject">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <select class="form-select" name="service">
                                                                                    <option value="">Choose Service</option>
                                                                                    <option value="1">Electrical Services</option>
                                                                                    <option value="2">Electrical Panels</option>
                                                                                    <option value="3">Security System</option>
                                                                                    <option value="4">Surge Protection</option>
                                                                                    <option value="5">Air Conditioning</option>
                                                                                    <option value="6">Indoor Lighting</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <textarea name="message" class="form-control" placeholder="Type Message" rows="4"></textarea>
                                                                    </div>
                                                                    <button class="theme-btn">Submit Now<i class="fas fa-arrow-right-long"></i></button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>-->
                </div>
            </div>
        </div>
        <!-- quote area end -->



        <!-- blog area -->
        <div class="blog-area pb-120">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 mx-auto">
                        <div class="site-heading text-center">
                            <span class="site-title-tagline"><i class="far fa-lightbulb-on"></i>
                                Berita</span>
                            <h2 class="site-title">BERITA TERBARU & <span>BLOG</span></h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach ($berita as $item)
                        <div class="col-md-6 col-lg-4">
                            <div class="blog-item wow fadeInUp" data-wow-delay=".25s">
                                <div class="blog-item-img">
                                    <img src="{{ $item['image_url'] }}" alt="Thumb">
                                    <div class="blog-date"><i class="fal fa-calendar-alt"></i>
                                        {{ $item['publish_date'] }}</div>
                                </div>
                                <div class="blog-item-info">
                                    <div class="blog-item-meta">
                                        <ul>
                                            <li><a href="#"><i class="far fa-user-circle"></i>
                                                    {{ $item['created_by_name'] }}</a></li>
                                            <li><a href="#"><i class="far fa-comments"></i> BPKP</a></li>
                                        </ul>
                                    </div>
                                    <h4 class="blog-title">
                                        <a href="{{ route('news.show', $item['slug']) }}">{{ $item['title'] }}</a>
                                    </h4>
                                    <p>{{ strip_tags($item['sort_content']) }}</p>
                                    <a class="theme-btn" href="{{ route('news.show', $item['slug']) }}">Selengkapnya<i
                                            class="fas fa-arrow-right-long"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach


                </div>
            </div>
            <!-- blog area end -->

            <!-- partner area -->
            <div class="partner-area bg pt-50 pb-50">
                <div class="container">
                    <div class="partner-wrapper partner-slider owl-carousel owl-theme">
                        {{-- <img src="assets/img/partner/01.png" alt="thumb">
                        <img src="assets/img/partner/02.png" alt="thumb">
                        <img src="assets/img/partner/03.png" alt="thumb">
                        <img src="assets/img/partner/04.png" alt="thumb">
                        <img src="assets/img/partner/05.png" alt="thumb">
                        <img src="assets/img/partner/06.png" alt="thumb"> --}}
                        @foreach ($sponsor as $item)
                            <a href="{{ $item['link'] }}" target="_blank">
                                <img src="{{ $item['image_url'] }}" alt="thumb"
                                    style="max-height: 80px; height: 80px">
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- partner area end -->
    </main>
@endsection

@section('js')
    @parent
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.6.8/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.4.1/js/swiper.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>
    <script>
            $(document).ready(function () {

function initializeSwiper() {
    new Swiper('.swiper-container', {
        slidesPerView: getSlidesPerView(),
        slidesPerGroup: getSlidesPerGroup(),
        slidesPerColumn: getSlidesPerColumn(),
        spaceBetween: 30,
        slidesPerColumnFill: 'column',
        loop: false,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        breakpoints: {
            0: { slidesPerView: 1 },
            768: { slidesPerView: 2 },
            1170: { slidesPerView: 3 }
        }
    });
}

function getSlidesPerView() {
    if ($(window).width() < 700) {
        return 1;
    } else if ($(window).width() < 900) {
        return 2;
    } else {
        return 3;
    }
}

function getSlidesPerGroup() {
    if ($(window).width() < 900) {
        return 1;
    } else {
        return 2;
    }
}

function getSlidesPerColumn() {
    if ($(window).width() < 700) {
        return 1;
    } else {
        return 2;
    }
}

$(window).on('load', initializeIsotope);
});
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var myCarousel = new bootstrap.Carousel(document.getElementById('carouselExampleDark'), {
                interval: false 
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var modal = document.getElementById("myModal");
            var closeButton = document.querySelector(".close-banner");
            var bannerLink = document.getElementById("bannerLink");

            var adBanners = @json($adBanners);
            var currentBannerIndex = 0;
            var closedBanners = [];

            function setBannerClosedCookie(index) {
                document.cookie = "bannerClosed_" + index + "=true; path=/";
            }

            function isBannerClosed(index) {
                var cookieName = "bannerClosed_" + index;
                var cookies = document.cookie.split(';');
                for (var i = 0; i < cookies.length; i++) {
                    var cookie = cookies[i].trim();
                    if (cookie.startsWith(cookieName + "=")) {
                        return true;
                    }
                }
                return false;
            }

            function checkAndDisplayBanner() {
                while (currentBannerIndex < adBanners.length && isBannerClosed(currentBannerIndex)) {
                    currentBannerIndex++;
                }
                if (currentBannerIndex < adBanners.length) {
                    modal.style.display = "block";
                    displayCurrentBanner();
                } else {
                    modal.style.display = "none";
                    setBannerClosedCookie(currentBannerIndex);
                }
            }

            function displayCurrentBanner() {
                var currentBanner = adBanners[currentBannerIndex];
                bannerLink.href = currentBanner['url'];
                document.querySelector(".img-banner").src = currentBanner['image'];
            }

            checkAndDisplayBanner();

            closeButton.onclick = function() {
                closedBanners.push(currentBannerIndex);
                setBannerClosedCookie(currentBannerIndex);
                currentBannerIndex++;
                checkAndDisplayBanner();
            }

            modal.onclick = function(event) {
                if (event.target == modal) {
                    closedBanners.push(currentBannerIndex);
                    setBannerClosedCookie(currentBannerIndex);
                    currentBannerIndex++;
                    checkAndDisplayBanner();
                }
            }
        });
    </script>
@endsection
