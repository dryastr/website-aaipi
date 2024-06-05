@extends('layouts.master')

@section('content')
    <main class="main">
            <!-- breadcrumb -->
    <div class="site-breadcrumb" style="background: url('{{ $image_banner }}')">
        <div class="container">
            <h2 class="breadcrumb-title">{{$title_banner}}</h2>
            <ul class="breadcrumb-menu">
                <li><a href="/">Home</a></li>
                <li class="active">Produk</li>
            </ul>
        </div>
    </div>
    <!-- breadcrumb end -->

        @foreach ($data as $item)
            <section id="{{ $item->id }}" class="breadcrumb-section d-none">
                <div style="padding: 100px 50px">
                    <div class="container">
                        <h1 class="breadcrumb-title" style="text-decoration: underline;">{{ $item->title }}</h1>

                        <div class="mt-4">
                            <p class="breadcrumb-title">{!! $item->desc !!}</p>

                        </div>
                    </div>
                </div>
            </section>
        @endforeach

    </main>

@endsection

@section('js')
    <script>

        function updateSectionVisibility() {
            var currentUrl = window.location.href;
            var breadcrumbSections = document.querySelectorAll('.breadcrumb-section');

            breadcrumbSections.forEach(function(section) {
                section.classList.add('d-none');
            });

            for (var i = 0; i < breadcrumbSections.length; i++) {
                var section = breadcrumbSections[i];
                if (currentUrl.endsWith('#' + section.id)) { 
                    section.classList.remove('d-none');
                    break;
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            updateSectionVisibility();

            var submenuItems = document.querySelectorAll('.dropdown-item');
            submenuItems.forEach(function(item) {
                item.addEventListener('click', function(event) {
                    submenuItems.forEach(function(submenuItem) {
                        submenuItem.classList.remove('active');
                    });
                    event.target.classList.add('active');
                    updateSectionVisibility();
                });
            });

            window.addEventListener('popstate', function() {
                updateSectionVisibility();
            });
        });
    </script>
@endsection
