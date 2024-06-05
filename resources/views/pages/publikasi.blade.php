@extends('layouts.master')

@section('content')
<main class="main">

        <!-- breadcrumb -->
        <div class="site-breadcrumb" style="background: url('{{ $image_banner }}')">
            <div class="container">
                <h2 class="breadcrumb-title">{{$title_banner}}</h2>
                <ul class="breadcrumb-menu">
                    <li><a href="/">Home</a></li>
                    <li class="active">Publikasi</li>
                </ul>
            </div>
        </div>
        <!-- breadcrumb end -->


        <!-- blog single area -->
        <div class="blog-single-area pt-120 pb-120">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        @if(count($data) > 0)
                        @foreach ($data as $item)
                        <div class="blog-single-wrapper">
                            <div class="blog-single-content">
                                <div class="blog-info">
                                    <div class="row blog-details">
                                        <div class="col-md-3 blog-thumb-img">
                                            <img src="{{$item['image_url']}}" alt="Thumb">
                                        </div>

                                        <div class="col-md-9">
                                            <h3 class="blog-details-title mb-20">
                                                <a style="font-size: 25px" href="{{route('news.show', $item['slug'])}}">{{$item['title']}}</a>
                                            </h3>
                                            <div class="blog-meta">
                                                <div class="blog-meta-left">
                                                    <ul>
                                                        <li><i class="far fa-user"></i><a href="#">{{$item['created_by_name']}}</a></li>
                                                        {{-- <li><i class="far fa-comments"></i>3.2k Comments</li> --}}
                                                        <li><i class="fal fa-calendar-alt"></i>{{$item['publish_date']}}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="mb-10">
                                                <p>{{strip_tags($item['sort_content'])}}</p>
                                            </div>
                                            <div class="blog-details-tags pb-20 pt-10">
                                                <h5>Tags : </h5>
                                                <ul>
                                                    @foreach ($item['list_tags'] as $tag)
                                                    <li><a href="#">{{$tag}}</a></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <a href="{{route('news.show', $item['slug'])}}" class="theme-btn mt-4">Selengkapnya<i class="fas fa-arrow-right-long" ></i></a>
                                        </div>

                                        <hr>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <div>
                            <h1 class="text-center">Data tidak ada</h1>
                            <img src="assets/img/data-tidak-ada.jpg" alt="" style="height: 100%;">
                        </div>
                        @endif

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
                    <div class="col-lg-4">
                        <aside class="sidebar">
                            <!-- search-->
                            <div class="widget search">
                                <h5 class="widget-title">Search</h5>
                                <form class="search-form">
                                    <input type="text" name="search" class="form-control" placeholder="Search Here..." value="{{request()->query('search')}}">
                                    <button type="submit"><i class="far fa-search"></i></button>
                                </form>
                            </div>
                            <!-- category -->
                            <div class="widget category">
                                <h5 class="widget-title">ARCHIVES</h5>
                                <div class="category-list">
                                    @foreach ($list_archives as $item)
                                    <a href="{{route('publikasi.index', ['tahun' => $item['tahun'], 'bulan' => $item['bulan']])}}">
                                        <i class="far fa-arrow-right"></i>{{$item['nama_bulan'] . ' ' . $item['tahun']}}<span>({{$item['jumlah']}})</span>
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                            <!-- recent post -->
                            <div class="widget recent-post">
                                <h5 class="widget-title">Recent Post</h5>
                                @foreach ($recent_post as $row)
                                <div class="recent-post-single">
                                    <div class="recent-post-img">
                                        <img src="{{$row['image_url']}}" alt="thumb">
                                    </div>
                                    <div class="recent-post-bio">
                                        <h6><a href="{{route('news.show', $row['slug'])}}">{{$row['title']}}</a></h6>
                                        <span><i class="far fa-clock"></i>{{$row['publish_date']}}</span>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                        </aside>
                    </div>
                </div>
            </div>
        </div>
        <!-- blog single area end -->

    </main>

@endsection
