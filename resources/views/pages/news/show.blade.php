@extends('layouts.master')

@section('content')
<main class="main">

        <!-- breadcrumb -->
        <div class="site-breadcrumb" style="background: url(assets/img/breadcrumb/01.jpg)">
            <div class="container">
                <h2 class="breadcrumb-title">Berita</h2>
                <ul class="breadcrumb-menu">
                    <li><a href="{{route('home')}}">Beranda</a></li>
                    <li><a href="{{route('publikasi.index')}}">Publikasi</a></li>
                    <li class="active">Berita</li>
                </ul>
            </div>
        </div>
        <!-- breadcrumb end -->


        <!-- blog single area -->
        <div class="blog-single-area pt-120 pb-120">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="blog-single-wrapper">
                            <div class="blog-single-content">
                                <div class="blog-thumb-img">
                                    <img src="{{$item['image_url']}}" width="100%" alt="thumb">
                                </div>
                                <div class="blog-info">
                                    <div class="blog-meta">
                                        <div class="blog-meta-left">
                                            <ul>
                                                <li><i class="far fa-user"></i><a href="#">{{$item['created_by_name']}}</a></li>
                                                @auth
                                                <li ><i class="far fa-comments"></i><span class="news-comment-top">0 Comments</span></li>
                                                @endauth
												{{-- <li><i class="far fa-thumbs-up"></i>1.4k Like</li> --}}
                                            </ul>
                                        </div>
                                        <div class="blog-meta-right">
                                             {{-- <a href="#" class="share-btn"><i class="far fa-share-alt"></i>Share</a> --}}
                                        </div>
                                    </div>
                                    <div class="blog-details">
                                        <h3 class="blog-details-title mb-20">{{$item['title']}}</h3>

                                        <div class="mb-10">
                                            {!!$item['content']!!}
                                        </div>

                                        <hr>
										<div class="blog-details-tags pb-20">
                                            {{-- {{dd($item->toArray())}} --}}
											<h5>Tags : </h5>
											<ul>
                                                @foreach ($item['list_tags'] as $tag)
												<li><a href="#">{{$tag}}</a></li>
                                                @endforeach
											</ul>
										</div>
                                    </div>

                                </div>
                                @auth
                                @include('pages.news.comment')
                                @endauth
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <aside class="sidebar">
                            <!-- search-->
                            <div class="widget search">
                                <h5 class="widget-title">Search</h5>
                                <form class="search-form" action="{{route('publikasi.index')}}">
                                    <input type="text" class="form-control" placeholder="Search Here...">
                                    <button type="submit"><i class="far fa-search"></i></button>
                                </form>
                            </div>
                            <!-- category -->
                            <div class="widget category">
                                <h5 class="widget-title">Category</h5>
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
