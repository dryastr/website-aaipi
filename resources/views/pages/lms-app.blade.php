@extends('layouts.master')

@section('content')

<main class="main">

    <!-- breadcrumb -->
    <div class="site-breadcrumb" style="background: url('{{ $image_banner }}')">
        <div class="container">
            <h2 class="breadcrumb-title">{{$title_banner}}</h2>
            <ul class="breadcrumb-menu">
                <li><a href="/">Home</a></li>
                <li class="active">E-LMS AAIPI</li>
            </ul>
        </div>
    </div>
    <!-- breadcrumb end -->


    <!-- about area -->
    @if($item)
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
                            <span class="site-title-tagline"><i class="fa-light fa-rectangle-history"></i> Tentang Kami</span>
                            <h2 class="site-title">
                                {{$item['title']}}
                            </h2>
                            <h2 class="site-title">

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
    <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; margin-top: 20px;">
        <h1 class="text-center">Tidak ada content</h1>
        <img src="assets/img/data-tidak-ada.jpg" alt="" style="height: 100%; width: 50%">
    </div>    
    @endif
    <!-- about area end -->

</main>


@endsection
