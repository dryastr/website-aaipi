<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>AAIPI - {{ $title }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/logo/favicon-package/android-chrome-512x512.png') }}">

    <link href="{{asset('layouts/modern-light-menu/css/light/loader.css')}}" rel="stylesheet" type="text/css" />
    <script src="{{asset('layouts/modern-light-menu/loader.js')}}"></script>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="{{asset('src/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('layouts/modern-light-menu/css/light/plugins.css')}}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    @isset($headerFiles)
    {{$headerFiles}}
    @endisset
    <link rel="stylesheet" type="text/css" href="{{asset('src/assets/css/light/elements/alert.css')}}">
    <link href="{{asset('src/plugins/src/notification/snackbar/snackbar.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('src/plugins/src/sweetalerts2/sweetalerts2.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('src/plugins/css/light/sweetalerts2/custom-sweetalert.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('src/plugins/css/light/notification/snackbar/custom-snackbar.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('src/plugins/css/light/loaders/custom-loader.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{asset('src/plugins/src/font-icons/fontawesome-free-5.15.4-web/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('src/plugins/src/font-icons/fontawesome-free-5.15.4-web/css/fontawesome.min.css')}}">
    <link href="{{asset('src/assets/css/light/scrollspyNav.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('src/assets/css/light/components/font-icons.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('src/assets/css/light/components/tabs.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{asset('src/plugins/src/table/datatable/datatables.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('src/plugins/css/light/table/datatable/dt-global_style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('src/plugins/css/light/table/datatable/custom_dt_miscellaneous.css')}}">
    <link href="{{asset('src/assets/css/light/components/list-group.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{asset('src/assets/css/light/widgets/modules-widgets.css')}}">
    <style>
        #sidebar ul.menu-categories ul.submenu > li ul.sub-submenu > li.active a {
            color: #D21A26;
        }
    </style>
    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->
</head>

<body @class([
    'layout-boxed' => $isAuth,
    'form' => !$isAuth
]) layout="layout-boxed">
    <!-- BEGIN LOADER -->
    <div id="load_screen">
        <div class="loader">
            <div class="loader-content">
                <div class="spinner-grow align-self-center"></div>
            </div>
        </div>
    </div>
    <!--  END LOADER -->

    @if($isAuth)

    <!--  BEGIN NAVBAR  -->
    <x-navbar :user="$user"/>
    <!--  END NAVBAR  -->

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container " id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN SIDEBAR  -->
        <x-sidebar :user="$user"/>
        <!--  END SIDEBAR  -->

        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">
                <div class="middle-content container-xxl p-0">
                    @if(!$user['is_admin'])
                    @isset($notification_keanggotaan)
                        @if ($notification_keanggotaan['status'] == 'belum-aktif')
                        <div class="alert alert-arrow-right alert-icon-right alert-light-danger alert-dismissible fade show mb-4 mt-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12" y2="16"></line></svg>
                            Aktifkan Keanggotaan Anda Sekarang! Jangan lewatkan manfaat eksklusif yang tersedia hanya untuk anggota. <a href="{{route('profile.aktifasi-keanggotaan')}}" class="">Aktifkan Sekarang</a>
                        </div>
                        @endif
                        @if ($notification_keanggotaan['status'] == 'mendekati-kadaluwarsa')
                        <div class="alert alert-arrow-right alert-icon-right alert-light-warning alert-dismissible fade show mb-4 mt-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12" y2="16"></line></svg>
                            Perpanjang Keanggotaan Anda! Masa berlaku keanggotaan Anda akan berakhir dalam {{$notification_keanggotaan['sisa']}} hari. <a href="{{route('profile.aktifasi-keanggotaan')}}" class="">Perbaharui Sekarang</a>
                        </div>
                        @endif
                        @if ($notification_keanggotaan['status'] == 'kadaluwarsa')
                        <div class="alert alert-arrow-right alert-icon-right alert-light-danger alert-dismissible fade show mb-4 mt-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12" y2="16"></line></svg>
                            Keanggotaan Anda Telah Kedaluwarsa. Kami merindukan Anda! <a href="{{route('profile.aktifasi-keanggotaan')}}" class="">Perbaharui Sekarang</a>
                        </div>
                        @endif
                        @if ($notification_keanggotaan['status'] == 'masa-tenggang')
                        <div class="alert alert-arrow-right alert-icon-right alert-light-success alert-dismissible fade show mb-4 mt-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12" y2="16"></line></svg>
                            Masa Tenggang Keanggotaan Anda Aktif. Masih ada waktu untuk memperbaharui! <a href="{{route('profile.aktifasi-keanggotaan')}}" class="">Perbaharui Sekarang</a>
                        </div>
                        @endif
                    @endisset
                    @endif
                    <!-- BREADCRUMB -->
                    {{-- <div class="page-meta">
                        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Components</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Font Icons</li>
                            </ol>
                        </nav>
                    </div> --}}
                    <!-- /BREADCRUMB -->
                    {{$slot}}
                </div>
            </div>
        </div>
    </div>
    @else
    {{$slot}}
    @endif
    <!--  END MAIN CONTAINER  -->

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="{{asset('src/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/js/jquery-3.6.0.min.js')}}"></script>
    <script src="{{asset('src/plugins/src/notification/snackbar/snackbar.min.js')}}"></script>
    <script src="{{asset('src/plugins/src/table/datatable/datatables.js')}}"></script>
    <script src="{{asset('src/plugins/src/table/datatable/custom_miscellaneous.js')}}"></script>
    <script src="{{asset('src/plugins/src/sweetalerts2/sweetalerts2.min.js')}}"></script>
    {{-- <script src="{{asset('src/assets/js/components/notification/custom-snackbar.js')}}"></script> --}}
    @if($isAuth)
    <script src="{{asset('src/plugins/src/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
    <script src="{{asset('src/plugins/src/mousetrap/mousetrap.min.js')}}"></script>
    <script src="{{asset('src/plugins/src/waves/waves.min.js')}}"></script>
    <script src="{{asset('layouts/modern-light-menu/app.js')}}"></script>
    @endif

    {{-- <script src="{{asset('src/assets/js/scrollspyNav.js')}}"></script> --}}
    <script src="{{asset('src/plugins/src/font-icons/feather/feather.min.js')}}"></script>
    <script>
        feather.replace();
        function BASE_URL(url = '/') {
            let char = url ? url[0] : '/';
            let prefix = `/panel${char === '/' ? '' : '/' + url}`
            return "{{url('')}}" + prefix;
        }
        const CURRENT_URL = "{{url()->current()}}";
    </script>

    <script src="{{asset('src/main.js')}}"></script>

    @isset($footerFiles)
    {{$footerFiles}}
    @endisset

    <!-- END GLOBAL MANDATORY SCRIPTS -->
</body>
</html>
