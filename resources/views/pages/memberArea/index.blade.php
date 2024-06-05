@extends('layouts.master')

@section('content')
    <main class="main">

        <!-- breadcrumb -->
        <div>
            <div class="site-breadcrumb" style="background: url(assets/img/breadcrumb/01.jpg)">
                <div class="container">
                    <h2 class="breadcrumb-title">Member Area</h2>
                    <ul class="breadcrumb-menu">
                        <li><a href="{{ route('home') }}">Beranda</a></li>
                        <li class="active">Member Area</li>
                    </ul>
                </div>
                <p id="login"></p>
            </div>
        </div>
        <!-- breadcrumb end -->


        <!-- Member area -->
        <div id="member-area">
            <div class="contact-area py-120" id="ok">
                <div class="container" id="test">
                    <ul class="nav nav-pills justify-content-center  mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-1-tab" data-bs-toggle="pill" data-bs-target="#pills-1"
                                type="button" role="tab" aria-controls="pills-1" aria-selected="true">Login
                                Anggota</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-1-tab" data-bs-toggle="pill" data-bs-target="#pills-2"
                                type="button" role="tab" aria-controls="pills-1" aria-selected="true">Aktivasi
                                Keanggotaan</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-2-tab" data-bs-toggle="pill" data-bs-target="#pills-3"
                                type="button" role="tab" aria-controls="pills-2" aria-selected="false">Daftar Anggota
                                Luar Biasa</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-1" role="tabpanel" aria-labelledby="pills-1-tab">
                            @include('pages.memberArea.login')

                        </div>
                        <div class="tab-pane fade show" id="pills-2" role="tabpanel" aria-labelledby="pills-2-tab">
                            @include('pages.memberArea.aktifasi')

                        </div>
                        <div class="tab-pane fade" id="pills-3" role="tabpanel" aria-labelledby="pills-3-tab">
                            @include('pages.memberArea.anggota-luarbiasa')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end Registrasi area -->

    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var memberAreaElement = document.getElementById('login');
            if (memberAreaElement) {
                memberAreaElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    </script>
@endsection
