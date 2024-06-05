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
                        
                            <img src="{{ asset(Storage::url($banners->image))}}"  alt="thumb">
                        
                        </div>
                        <div class="blog-info">
                            <div class="blog-meta">
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
                            </div>
                            <div class="blog-details">
                                <h3 class="blog-details-title mb-20">{{ $banners->title }}</h3>
                                <p class="mb-10">
                                    {{ $banners->desc }}
                                </p>
                                <blockquote class="blockqoute">
                                    It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution.
                                    <h6 class="blockqoute-author">Mark Crawford</h6>
                                </blockquote>
                            </div>
                            <!-- <div class="blog-author">
                                <div class="blog-author-img">
                                    <img src="assets/img/blog/author.jpg" alt="">
                                </div>
                                <div class="author-info">
                                    <h6>Author</h6>
                                    <h3 class="author-name">Agnes F. Natale</h3>
                                    <p>It is a long established fact that a reader will be distracted by the abcd readable content of a page when looking at its layout  that more less.</p>
                                    <div class="author-social">
                                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                                        <a href="#"><i class="fab fa-twitter"></i></a>
                                        <a href="#"><i class="fab fa-instagram"></i></a>
                                        <a href="#"><i class="fab fa-whatsapp"></i></a>
                                        <a href="#"><i class="fab fa-youtube"></i></a>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                        <!-- <div class="blog-comments">
                            <h3>Comments (20)</h3>
                            <div class="blog-comments-wrapper">
                                <div class="blog-comments-single">
                                    <img src="assets/img/blog/com-1.jpg" alt="thumb">
                                    <div class="blog-comments-content">
                                        <h5>Kecia A. Parada</h5>
                                        <span><i class="far fa-clock"></i> May 24, 2023</span>
                                        <p>There are many variations of passages the majority have suffered in some injected humour or randomised words which don't look even slightly believable.</p>
                                        <a href="#"><i class="far fa-reply"></i> Reply</a>
                                    </div>
                                </div>
                                <div class="blog-comments-single blog-comments-reply">
                                    <img src="assets/img/blog/com-2.jpg" alt="thumb">
                                    <div class="blog-comments-content">
                                        <h5>Thomas A. Lindsey</h5>
                                        <span><i class="far fa-clock"></i> May 24, 2023</span>
                                        <p>There are many variations of passages the majority have suffered in some injected humour or randomised words which don't look even slightly believable.</p>
                                        <a href="#"><i class="far fa-reply"></i> Reply</a>
                                    </div>
                                </div>
                                <div class="blog-comments-single">
                                    <img src="assets/img/blog/com-3.jpg" alt="thumb">
                                    <div class="blog-comments-content">
                                        <h5>Mary R. Lujan</h5>
                                        <span><i class="far fa-clock"></i> May 24, 2023</span>
                                        <p>There are many variations of passages the majority have suffered in some injected humour or randomised words which don't look even slightly believable.</p>
                                        <a href="#"><i class="far fa-reply"></i> Reply</a>
                                    </div>
                                </div>
                            </div>
                            <div class="blog-comments-form">
                                <h3>Leave A Comment</h3>
                                <form action="#">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="Your Name*">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="email" class="form-control" placeholder="Your Email*">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <textarea class="form-control" rows="5" placeholder="Your Comment*"></textarea>
                                            </div>
                                            <button type="submit" class="theme-btn">Post Comment <i class="far fa-paper-plane"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- blog single area end -->
</main>
@endsection
