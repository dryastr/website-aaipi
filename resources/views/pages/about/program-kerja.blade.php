@extends('layouts.master')

@section('content')
<main class="main">

    <!-- breadcrumb -->
    <div class="site-breadcrumb" style="background: url('{{ $image_banner }}')">
        <div class="container">
            <h2 class="breadcrumb-title">{{$title_banner}}</h2>
            <ul class="breadcrumb-menu">
                <li><a href="/">Home</a></li>
                <li class="active">Program Kerja</li>
            </ul>
        </div>
    </div>
    <!-- breadcrumb end -->


    <!-- choose-area -->
    <div class="choose-area bg">
        <div class="container">
            @if($item)
            <div class="row">
                <div class="col-lg-6">
                    <div class="choose-img wow fadeInLeft" data-wow-delay=".25s">

                        <div class="about-left">
                            <img src="{{ $item['image_url'] ? $item['image_url'] : asset('assets/img/team/01.jpg')}}" alt="">
                            <div class="linear-color"></div>
                        </div>

                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="choose-content wow fadeInUp" data-wow-delay=".25s">
                        <div class="site-heading mb-3">
                            <span class="site-title-tagline"><i class="fa-regular fa-user"></i>Tentang Kami</span>
                            <h2 class="site-title">
                               {{ $item['title'] }}
                            </h2>
                        </div>
                        <p>{!! $item['content'] !!}</p>

                        @forelse ($proker as $prokers)
                        <div class="choose-wrapper">
                            <div class="choose-item">
                                <div class="choose-icon" style="width: 20px; height: 20px"></div>
                                <div class="choose-item-content">
                                    <h4>{{ $prokers->title }}</h4>
                                    <p>{!! strlen(strip_tags($prokers->description)) > 70 ? substr(strip_tags($prokers->description), 0, 70) . '...' : strip_tags($prokers->description) !!}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="choose-wrapper">
                            <div class="choose-item">
                                <div class="choose-item-content">
                                    <h4>Tambahkan judul deskripsi</h4>
                                    <p><a href="{{ route('login') }}"
                                            style="text-decoration: underline; color: blue">Login</a></p>
                                </div>
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    <!-- choose-area end -->

</main>
@endsection
