<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@php
    if(Auth::check()){
        if(Auth::user()->is_admin){
            abort(404);
        }
    }
@endphp
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>AAIPI - @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/logo/favicon-package/android-chrome-512x512.png') }}">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('src/member/css/bootstrap.css') }}"/>
    <link rel="stylesheet" href="{{ asset('src/member/css/reset.css') }}"/>
    <link rel="stylesheet" href="{{ asset('src/member/cubeportfolio/css/cubeportfolio.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('src/member/css/owl.theme.css') }}"/>
    <link rel="stylesheet" href="{{ asset('src/member/css/owl.carousel.css') }}"/>
    <link rel="stylesheet" href="{{ asset('src/member/css/style.css') }}"/>
    <link rel="stylesheet" href="{{ asset('src/member/css/colors/red.css') }}" id="color"/>

    <link rel="stylesheet" type="text/css" href="{{asset('src/plugins/src/table/datatable/datatables.css')}}">
    {{-- <link rel="stylesheet" type="text/css" href="{{asset('src/plugins/css/light/table/datatable/dt-global_style.css')}}"> --}}
    <link rel="stylesheet" type="text/css" href="{{asset('src/plugins/css/light/table/datatable/custom_dt_miscellaneous.css')}}">


    <!-- Google Web fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,900" rel="stylesheet">

    <!-- Font Icons -->
    <link rel="stylesheet" href="{{ asset('src/member/icon-fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('src/member/icon-fonts/web-design/flaticon.css') }}" />

    @yield('head-extra')
</head>
<body>
    <div id="preloader">
        <div class="spinner"></div>
    </div>

     <!-- Wrapper -->
     <div class="wrapper top_60 container">
        <div class="row">
            <div class="col-lg-3 col-md-4" style="padding: 0">
                @include('member.components.profile')
            </div>


            <div id="ajax-tab-container" class="col-lg-9 col-md-8 tab-container">

                <header class="col-md-12" style="padding: 0">
                    <nav style="margin-bottom: 10px;">
                        <div class="row">
                            <!-- navigation bar -->
                            <div class="col-md-8 col-sm-8 col-xs-4">
                                <ul class="tabs">
                                    @if(optional($user['registration'])['status_approval']=='disetujui'  || $user['role_id']==2 || $user['role_id']==4)
                                        <li class="tab @yield('home-tab')">
                                            <a class="home-btn" href="{{ route('dashboard.view') }}" style="display: flex; align-items: center; justify-content: center;"><i class="fa fa-home" aria-hidden="true"></i></a>
                                        </li>
                                        <li class="tab @yield('resume-tab')"><a href="{{ route('member.resume') }}">PROFIL</a></li>
                                        <li class="tab @yield('pembelian-tab')"><a href="{{ route('member.pembelian') }}">PELATIHAN</a></li>
                                        <li class="tab @yield('tagihan-tab')"><a href="{{ route('member.tagihan') }}">KEANGGOTAAN</a></li>
                                        <li class="tab @yield('tiket-tab')"><a href="{{ route('member.tiket') }}">BANTUAN</a></li>
                                        <li class="tab @yield('app-tab')"><a href="{{ route('member.app') }}">APP</a></li>
                                    @else
                                    <li class="tab @yield('home-tab')">
                                        <a class="home-btn" href="#"><i class="fa fa-home" aria-hidden="true"></i></a>
                                    </li>
                                    <li class="tab @yield('resume-tab')"><a  href="#">PROFIL</a></li>
                                    <li class="tab @yield('pembelian-tab')"><a  href="#">PELATIHAN</a></li>
                                    <li class="tab @yield('tagihan-tab')"><a  href="#">KEANGGOTAAN</a></li>
                                    <li class="tab @yield('tiket-tab')"><a  href="#">BANTUAN</a></li>
                                    <li class="tab @yield('app-tab')"><a  href="#">APP</a></li>
                                    @endif
                                </ul>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-8 dynamic">
                                @if(optional($user['registration'])['status_approval']=='dalam-antrian' && $user['role_id']==3)
                                <button class="pull-right site-btn icon hidden-xs">Verifikasi Keanggotaan <i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                                @else
                                <button class="pull-right site-btn icon hidden-xs">Due for Renewal <span class="badge badge-light">{{$renewal ?? 0}} days</span> <i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                                @endif
                                <div class="hamburger pull-right hidden-lg hidden-md"><i class="fa fa-bars" aria-hidden="true"></i></div>
                                <div class="hidden-md social-icons pull-right">
                                    <a class="fb" href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                    <a class="tw" href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                                    <a class="ins" href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                                    <a class="dr" href="#"><i class="fa fa-dribbble" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                    </nav>
                </header>

                <!-- Page Content
                ================================================== -->
                <div class="col-md-12" style="padding: 0">
                    <div id="content" class="panel-container">
                        @yield('content')

                    </div>

                    <footer>
                        <div class="footer col-md-12 top_30 bottom_30">
                            <div class="name col-md-4 hidden-md hidden-sm hidden-xs">AAIPI</div>
                            <div class="copyright col-lg-8 col-md-12">© 2023 All rights reserved. Produced by <a href="https://qeraton.com">PT. Qeraton Artha Technologies</a> </div>
                        </div>
                    </footer>

                </div>


            </div>
        </div><!-- row end -->
    </div> <!-- Wrapper - End -->

    <!-- Javascripts -->
    <script src="{{ asset('src/member/js/jquery-2.1.4.min.js') }}"></script>
    <script src="{{asset('src/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.6.7/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Bootstrap JS -->
    {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script> --}}
    <script src="{{asset('src/plugins/src/table/datatable/datatables.js')}}"></script>
    <script src="{{asset('src/plugins/src/table/datatable/custom_miscellaneous.js')}}"></script>
    <script src="{{ asset('src/member/cubeportfolio/js/jquery.cubeportfolio.min.js') }}"></script>
    {{-- <script src="{{ asset('src/member/js/bootstrap.min.js') }}"></script> --}}
    <script src="{{ asset('src/member/js/jquery.easytabs.min.js') }}"></script>
    <script src="{{ asset('src/member/js/owl.carousel.min.js') }}"></script>

    <script src="{{ asset('src/member/js/main.js') }}"></script>
    <!-- for color alternatives -->
    <script src="{{ asset('src/member/js/jquery.cookie-1.4.1.min.js') }}"></script>
    {{-- <script src="{{ asset('src/member/js/Demo.js') }}"></script> --}}
    <script src="{{ asset('src/plugins/src/apex/apexcharts.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('src/member/css/Demo.min.css')}}" />

    {{-- @yield('scripts') --}}

    @stack('scripts')
</body>
</html>
