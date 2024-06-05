@extends('layouts.master')

@section('content')

<main class="main">

    <!-- breadcrumb -->
    <div class="site-breadcrumb" style="background: url('{{ $image_banner }}')">
        <div class="container">
            <h2 class="breadcrumb-title">{{$title_banner}}</h2>
            <ul class="breadcrumb-menu">
                <li><a href="/">Home</a></li>
                <li class="active">Telaah Sejawat</li>
            </ul>
        </div>
    </div>
    <!-- breadcrumb end -->


<!-- about area -->
@if ($item)
<div class="about-area py-120">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="about-left wow fadeInLeft" data-wow-delay=".25s">
                    <div class="about-img">
                        <img src=" {{ $item['image_url'] ? $item['image_url'] : asset('assets/img/team/01.jpg')}}" alt="">
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-right wow fadeInRight" data-wow-delay=".25s">
                    <div class="site-heading mb-3">
                        <span class="site-title-tagline"><i class="far fa-lightbulb-on"></i> Tentang Kami</span>
                        <h2 class="site-title">
                            {{$item['title']}}
                        </h2>
                    </div>
                    <p class="about-text">
                        {!!$item['content']!!}
                    </p>
                    @if ($link_app)
                        <a href="{{$link_app['content']}}" target="_blank" class="theme-btn mt-4">
                            {{$link_app['title']}} <i class="fas fa-arrow-right-long"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="container mt-50 mb-50">
    <div class="row">
        <div class="col-md-12">
            <div style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
                <h1 class="text-center">Tidak ada content</h1>
                <img src="assets/img/data-tidak-ada.jpg" alt="" style="height: 100%; width: 50%">
            </div>            
        </div>
    </div>
</div>
@endif
<!-- about area end -->


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
                        <span class="counter" data-count="+" data-to="{{$jumlah_user['anggota_biasa']}}"
                            data-speed="3000">{{$jumlah_user['anggota_biasa']}}</span>
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
                        <span class="counter" data-count="+" data-to="{{$jumlah_user['anggota_luar_biasa']}}"
                            data-speed="3000">{{$jumlah_user['anggota_luar_biasa']}}</span>
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
                        <span class="counter" data-count="+" data-to="{{$jumlah_user['anggota_kehormatan']}}"
                            data-speed="3000">{{$jumlah_user['anggota_kehormatan']}}</span>
                        <h6 class="title">+ Anggota Kehormatan</h6>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- counter area end -->



</main>

@endsection
