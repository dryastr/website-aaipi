@extends('layouts.master')

@section('content')
<main class="main">
    <!-- breadcrumb -->
    <div class="site-breadcrumb" style="background: url('{{ $image_banner }}')">
        <div class="container">
            <h2 class="breadcrumb-title">{{$title_banner}}</h2>
            <ul class="breadcrumb-menu">
                <li><a href="/">Home</a></li>
                <li class="active">Komite Telaah Sejawat</li>
            </ul>
        </div>
    </div>
    <!-- breadcrumb end -->


    <!-- about area -->
   
    <!-- about area end -->
</main>

@endsection
