@extends('layouts.master')

@section('content')
<!-- breadcrumb -->
<div class="site-breadcrumb" style="background-image: url('{{ asset($bannerSelengkapnya) }}')">
        <div class="container">
        <h2 class="breadcrumb-title">Galeri</h2>
            <ul class="breadcrumb-menu">
                <li><a href="/">Home</a></li>
                <li class="active">Selengkapnya</li>
            </ul>
        </div>
    </div>
    <!-- breadcrumb end -->
<main class="main">

    <!-- team-area -->
    <div class="team-area pt-50 pb-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mx-auto">
                    <div class="site-heading text-center">
                        <span class="site-title-tagline"><i class="far fa-lightbulb-on"></i> Galeri Foto</span>
                        <h2 class="site-title">Galeri Foto <span>AAIPI</span></h2>
                    </div>
                </div>
            </div>
            <div class="mt-5">
                <div class="row filter-box popup-gallery">
                    @foreach ($data as $item)
                    <div class="col-md-4 filter-item">
                        <div class="portfolio-item">
                            <div class="portfolio-img">
                                <img style="height: 300px; object-fit:cover;" src="{{ $item->image_url }}" alt="">
                            </div>
                            <div class="portfolio-content">
                                <a class="popup-img portfolio-link" href="{{ $item->image_url }}"><i class="fal fa-plus"></i></a>
                                <div class="portfolio-info">
                                    <div class="portfolio-title-info">
                                        <a class="popup-img" href="{{ $item->image_url }}">
                                            <h4 class="portfolio-title">{{ $item->title }}</h4>
                                        </a>
                                        <h5 class="portfolio-subtitle">
                                            {{ $item->sub_title }}
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>

            @if ($data->hasPages())

                <div class="pagination-area">
                    <div aria-label="Page navigation example">
                        <ul class="pagination">

                            @if (!$data->onFirstPage())

                            <li class="page-item">
                                <a class="page-link" href="{{$data->previousPageUrl()}}" aria-label="Previous">
                                    <span aria-hidden="true"><i class="far fa-arrow-left"></i></span>
                                </a>
                            </li>

                            @endif

                            @for ($i = 1; $i <= $data->lastPage(); $i++)
                                @if ($i >= $data->currentPage() - 2 && $i <= $data->currentPage() + 2)
                                    <li @class(["page-item", "active" => $data->currentPage() == $i ])>
                                        <a class="page-link" href="{{$data->url($i)}}">{{$i}}</a>
                                    </li>
                                @endif

                            @endfor

                            @if (!$data->onLastPage())
                            <li class="page-item">
                                <a class="page-link" href="{{$data->nextPageUrl()}}" aria-label="Next">
                                    <span aria-hidden="true"><i class="far fa-arrow-right"></i></span>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>

            @endif

        </div>
    </div>
    <!-- team-area end -->

</main>
@endsection
