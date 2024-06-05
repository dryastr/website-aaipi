<!DOCTYPE html>
<html lang="en">

<head>
    <!-- meta tags -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- title -->
    <!-- {{-- <title>AAIPI - {!! $title !!}</title> --}} -->
    <title>AAIPI</title>

    <!-- favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('android-chrome-512x512.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <!-- css -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/all-fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/icomoon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
    <link href="{{asset('src/plugins/css/light/notification/snackbar/custom-snackbar.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

</head>

<body>

    <!-- preloader -->
    <div class="preloader">
        <div class="loader-ripple">
            <div></div>
            <div></div>
        </div>
    </div>
    <!-- preloader end -->


    <!-- header area -->
    <header class="header">

        <!-- top header -->
        <div class="header-top">
            <div class="container">
                <div class="header-top-wrapper">
                    <div class="header-top-left">
                        <div class="header-top-contact">
                            <ul>
                                @if($web_kontak_alamat)
                                <li><a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($web_kontak_alamat->content) }}"
                                        target="_blank"><i
                                            class="far fa-location-dot"></i> {{ strlen($web_kontak_alamat->content) > 30 ? substr($web_kontak_alamat->content, 0, 30) . '' : $web_kontak_alamat->content }}</a>
                                </li>
                                @endif
                                @if ($web_kontak_email)
                                <li><a href="mailto:{{$web_kontak_email->content}}"><i class="far fa-envelopes"></i>
                                        {{$web_kontak_email->content}}</a></li>
                                @endif
                                @if ($web_kontak_contact)
                                <li>
                                    <p style="color: white"><i class="far fa-phone-volume"></i>
                                        {{$web_kontak_contact->content}}</p>
                                    @endif
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="header-top-right">
                        <div class="header-top-social">
                            <span>Follow Us: </span>
                            @foreach ($icons as $icon)
                            <a href="{{ $icon->content }}" target="_BLANK"><i class="{{ $icon->icon }}"></i></a>
                            @endforeach
                            <!-- <a href="#"><i class="fab fa-facebook"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-linkedin"></i></a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="main-navigation">
            <nav class="navbar navbar-expand-lg">
                <div class="container position-relative" style="max-width: 1310px;">
                    <a class="navbar-brand" href="{{ route('home') }}">
                        <img src="/assets/img/logo/aaip-logo.png" alt="logo">
                    </a>
                    <div class="mobile-menu-right">
                        <div class="search-btn">
                            <button type="button" class="nav-right-link"><i class="far fa-search"></i></button>
                        </div>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#main_nav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-mobile-icon"><i class="far fa-bars"></i></span>
                        </button>
                    </div>
                    <div class="collapse navbar-collapse" id="main_nav">
                        <ul class="navbar-nav ms-3">
                            <li class="nav-item dropdown">
                                <a class="nav-link {{ Request::routeIs('home') ? 'active' : '' }}"
                                    href="{{ route('home') }}">Beranda</a>
                                <!-- <ul class="dropdown-menu fade-down">
                                    <li><a class="dropdown-item" href="index.html">Home Page 01</a></li>

                                    <li><a class="dropdown-item" href="index-2.html">Home Page 02</a></li>
                                    <li><a class="dropdown-item" href="index-3.html">Home Page 03</a></li>
                                </ul> -->
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle {{ Request::routeIs('about.history', 'about.visiDanMisi', 'about.strukturOrganisasi', 'about.programKerja', 'about.anggarandasar') ? 'active' : '' }}"
                                    href="#" data-bs-toggle="dropdown">Tentang Kami</a>
                                <ul class="dropdown-menu fade-down">
                                    <li><a class="dropdown-item {{ Request::routeIs('about.history') ? 'active' : '' }}"
                                            href="{{ route('about.history') }}">Sejarah Singkat</a></li>
                                    <li><a class="dropdown-item {{ Request::routeIs('about.visiDanMisi') ? 'active' : '' }}"
                                            href="{{ route('about.visiDanMisi') }}">Visi dan Misi</a></li>
                                    <li><a class="dropdown-item {{ Request::routeIs('about.strukturOrganisasi') ? 'active' : '' }}"
                                            href="{{ route('about.strukturOrganisasi') }}">Struktur Organisasi</a></li>
                                    <li><a class="dropdown-item {{ Request::routeIs('about.programKerja') ? 'active' : '' }}"
                                            href="{{ route('about.programKerja') }}">Program Kerja</a></li>
                                    <li><a class="dropdown-item {{ Request::routeIs('about.anggarandasar') ? 'active' : '' }}"
                                            href="{{ route('about.anggaranDasar') }}">Anggaran Dasar</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link {{ Request::routeIs('publikasi.index') ? 'active' : '' }}"
                                    href="{{ route('publikasi.index') }}">Publikasi</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link {{ Request::routeIs('keanggotaan.index') ? 'active' : '' }} "
                                    href="{{ route('keanggotaan.index') }}">Keanggotaan</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle {{ Route::is('test') ? 'active' : '' }}" href="#" data-bs-toggle="dropdown">Produk</a>
                                <ul class="dropdown-menu fade-down" style="width: 270px">
                                    @foreach (submenus() as $item)
                                    <li><a class="dropdown-item {{ Request::is('produk') && request()->segment(2) == $item->id ? 'active' : '' }}" href="{{ route('produk') . '#' . $item->id}}">{{ $item->title }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                            <!-- <li class="nav-item dropdown">
                                <a class="nav-link {{ Request::routeIs('lmsApp.show') ? 'active' : '' }}"
                                    href="{{ route('lmsApp.show') }}">E-LMS AAIPI</a>
                            </li>
                            <li class="nav-item"><a
                                    class="nav-link {{ Request::routeIs('sejawatApp.index') ? 'active' : '' }}"
                                    href="{{ route('sejawatApp.index') }}">Telaah
                                    Sejawat</a>
                            </li> -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle {{ Request::routeIs('lmsApp.show', 'sejawatApp.index' ) ? 'active' : '' }}"
                                    href="#" data-bs-toggle="dropdown">Aplikasi</a>
                                <ul class="dropdown-menu fade-down">
                                    <li><a class="dropdown-item {{ Request::routeIs('lmsApp.show') ? 'active' : '' }}"
                                            href="{{ route('lmsApp.show') }}">E-LMS AAIPI</a>
                                    </li>
                                    <li><a class="dropdown-item {{ Request::routeIs('sejawatApp.index') ? 'active' : '' }}"
                                            href="{{ route('sejawatApp.index') }}">Telaah
                                            Sejawat (SINTESA)</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item"><a
                                    class="nav-link {{ Request::routeIs('kontak.index') ? 'active' : '' }}"
                                    href="{{ route('kontak.index') }}">Kontak</a></li>
                        </ul>
                        <div class="nav-right" style="margin:20px">
                            <div class="search-btn">
                                <button type="button" class="nav-right-link"><i class="far fa-search"></i></button>
                            </div>
                            <div class="nav-right-btn mt-2">
                                <a href="{{ route('memberArea.index') }}" style="margin:-15px"
                                    class="theme-btn">Member Area<i class="fas fa-arrow-right-long"></i></a>
                            </div>
                        </div>
                    </div>
                    <!-- search area -->
                    <div class="search-area">
                        <form action="#">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Type Keyword...">
                                <button type="submit" class="search-icon-btn"><i class="far fa-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <!-- search area end -->
                </div>
            </nav>
        </div>
    </header>
    <!-- header area end -->


    @yield('content')


    <!-- footer area -->
    <footer class="footer-area">
        <div class="footer-widget">
            <div class="container">
                <div class="row footer-widget-wrapper pt-100 pb-70">
                    <div class="col-md-6 col-lg-4">
                        <div class="footer-widget-box about-us">
                            <a href="index.html" class="footer-logo">
                                <img src="/assets/img/logo/logo-light.png" style="width: 180px" alt="logo">
                            </a>
                            <p class="mb-3">
                            Asosiasi Auditor Intern Pemerintah Indonesia (AAIPI) didirikan pada tahun 1970 dengan tujuan menyatukan para auditor intern pemerintah di Indonesia dalam upaya meningkatkan profesionalisme,...
                            </p>
                            <ul class="footer-contact">
                                @if ($web_kontak_contact)
                                <li><p style="margin-bottom: 0"><i
                                            class="far fa-phone"></i>{{ $web_kontak_contact->content }}</p></li>
                                @endif
                                @if($web_kontak_alamat)
                                <li><a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($web_kontak_alamat->content) }}"
                                        target="_blank"><i
                                            class="far fa-location-dot"></i>{{$web_kontak_alamat->content}}</a></li>
                                @endif
                                @if ($web_kontak_email)
                                <li><a href="mailto:{{$web_kontak_email->content}}"><i class="far fa-envelopes"></i>
                                        {{$web_kontak_email->content}}</a></li>
                                @endif
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-2">
                        <div class="footer-widget-box list">
                            <h4 class="footer-widget-title">Tautan Langsung</h4>
                            <ul class="footer-list">
                                <li><a href="{{ route('about.history') }}"><i class="fas fa-caret-right"></i> Sejarah
                                        Singkat</a></li>
                                <li><a href="{{ route('about.visiDanMisi') }}"><i class="fas fa-caret-right"></i> Visi &
                                        Misi</a></li>
                                <li><a href="{{ route('about.strukturOrganisasi') }}"><i class="fas fa-caret-right"></i>
                                        Struktur Organisasi</a></li>
                                <li><a href="{{ route('publikasi.index') }}"><i class="fas fa-caret-right"></i>
                                        Publikasi</a></li>
                                <li><a href="{{ route('keanggotaan.index') }}"><i class="fas fa-caret-right"></i>
                                        Keanggotaan</a></li>
                                <li><a href="{{ route('kontak.index') }}"><i class="fas fa-caret-right"></i> Kontak
                                        Kami</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="footer-widget-box list">
                            <h4 class="footer-widget-title">Aplikasi</h4>
                            <ul class="footer-list">
                                <li><a href="{{ route('lmsApp.show') }}"><i class="fas fa-caret-right"></i> E-LMS</a>
                                </li>
                                <li><a href="{{ route('sejawatApp.index') }}/"><i class="fas fa-caret-right"></i> Telaah
                                        Sejawat</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <img src="assets/img/footer.png" alt="" style="height: 80%;">
                        <!-- {{-- <div class="footer-widget-box list">
                            <h4 class="footer-widget-title">Buletin</h4>
                            <div class="footer-newsletter">
                                <p>Berlangganan Buletin Kami Untuk Mendapatkan Pembaruan dan Berita Terkini</p>
                                <div class="subscribe-form">
                                    <form action="#">
                                        <input type="email" class="form-control" placeholder="Your Email">
                                        <button class="theme-btn" type="submit">
                                            Menjadi Anggota AAIPI <i class="far fa-paper-plane"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div> --}} -->
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 align-self-center">
                        <p class="copyright-text">
                            &copy; Copyright <span id="date"></span> <a href="#"> AAIPI </a> All Rights Reserved. Powered by <a href="https://qeraton.com/" target="_blank">PT. Qeraton Artha Technologies</a>
                        </p>
                    </div>
                    <div class="col-md-4 align-self-center">
                        <ul class="footer-social">
                            <li>
                                @foreach ($icons as $icon)
                                <a href="{{ $icon->link }}" target="_BLANK"><i class="{{ $icon->sosmed_icon }}"></i></a>
                                @endforeach
                            </li>
                            <!-- <li><a href="#" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Facebook" ><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                            <li><a href="#"><i class="fab fa-youtube"></i></a></li> -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- footer area end -->




    <!-- scroll-top -->
    <a href="#" id="scroll-top"><i class="far fa-arrow-up-from-arc"></i></a>
    <!-- scroll-top end -->


    <!-- js -->
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/modernizr.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{asset('src/plugins/src/notification/snackbar/snackbar.min.js')}}"></script>
    <script src="{{ asset('assets/js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.appear.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/js/counter-up.js') }}"></script>
    <script src="{{ asset('assets/js/wow.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    @yield('js')
</body>

</html>
