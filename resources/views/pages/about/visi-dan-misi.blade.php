@extends('layouts.master')

@section('content')
<main class="main">
    <!-- breadcrumb -->
    <div class="site-breadcrumb" style="background: url('{{ $image_banner }}')">
        <div class="container">
            <h2 class="breadcrumb-title">{{$title_banner}}</h2>
            <ul class="breadcrumb-menu">
                <li><a href="/">Home</a></li>
                <li class="active">Visi Misi</li>
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
                    <div class="contact-form">
                        <div class="site-heading mb-3">
                            <span class="site-title-tagline"><i class="fa-light fa-rectangle-history"></i> Tentang Kami</span>
                            <h2 class="site-title">
                                {{$item['title']}}
                            </h2>
                        </div>
                        <div class="contact-form-header">
                            <p>
                                {!!$item['content']!!}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="text-center">Tidak Ada Data</div>
    @endif
    <!-- about area end -->
</main>

@endsection
