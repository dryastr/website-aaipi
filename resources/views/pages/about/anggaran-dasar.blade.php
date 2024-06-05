@extends('layouts.master')

@section('content')
<main class="main">

        <!-- breadcrumb -->
        <div class="site-breadcrumb" style="background: url('{{ $image_banner }}')">
            <div class="container">
                <h2 class="breadcrumb-title">{{$title_banner}}</h2>
                <ul class="breadcrumb-menu">
                    <li><a href="/">Home</a></li>
                    <li class="active">Anggaran Dasar</li>
                </ul>
            </div>
        </div>
        <!-- breadcrumb end -->


        <!-- portfolio-area -->
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
                            </div>
                            <p class="about-text">
                                {!!$item['content']!!}
                            </p>
                        </div>
                    </div>
                    <div class="col-md-12 mt-5">
                        <h4>Daftar anggaran</h4>
                        <ul>
                            @foreach ($file_anggaran as $row)
                            <li style="list-style: disc; list-style-position:inside"><a href="{{$row['image_url']}}" target="_blank">{{$row['title']}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @else
            <div class="text-center">
                Tidak ada data
            </div>
        @endif
        <!-- portfolio-area end -->

    </main>
@endsection
