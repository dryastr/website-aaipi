@extends('layouts.master')

@section('content')
<main class="main">

<!-- breadcrumb -->
<!-- <div class="site-breadcrumb" style="background: url(assets/img/breadcrumb/01.jpg)">
    <div class="container">
        <h2 class="breadcrumb-title">Blog Single</h2>
        <ul class="breadcrumb-menu">
            <li><a href="index.html">Home</a></li>
            <li class="active">Blog Single</li>
        </ul>
    </div>
</div> -->
<!-- breadcrumb end -->


<!-- blog single area -->
<div class="blog-single-area pb-120">
    <div class="container">
        <div class="row">
            <div class="">
                <div class="blog-single-wrapper">
                    <div class="blog-single-content">
                        <div class="blog-thumb-img">

                            <img src="{{ $kerja->image_url }}"  alt="thumb">

                        </div>
                        <div class="blog-info">
                            {{-- <div class="blog-meta">
                                <div class="blog-meta-left">
                                    <ul>
                                        <li><i class="far fa-user"></i><a href="#">Jean R Gunter</a></li>
                                        <li><i class="far fa-comments"></i>3.2k Comments</li>
                                        <li><i class="far fa-thumbs-up"></i>1.4k Like</li>
                                    </ul>
                                </div>
                                <div class="blog-meta-right">
                                     <a href="#" class="share-btn"><i class="far fa-share-alt"></i>Share</a>
                                </div>
                            </div> --}}
                            <div class="blog-details">
                                <h3 class="blog-details-title mb-20">{{ $kerja->title }}</h3>
                                <p class="mb-10">
                                    {!!$kerja['description']!!}
                                </p>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- blog single area end -->
</main>
@endsection
