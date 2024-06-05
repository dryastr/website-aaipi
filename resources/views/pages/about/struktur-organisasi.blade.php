@extends('layouts.master')

@section('content')

<link rel="stylesheet" href="{{asset('src/orgchart/css/jquery.orgchart.css')}}">

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style>
    #chart-container {
        font-family: Arial;
        height: 420px;
        border: 2px dashed #d1d1d1;
        border-radius: 5px;
        overflow: hidden;
        text-align: center;
        position: relative;
        height: 100%;
    }

    .orgchart .node .content,
    .orgchart .node .title {
        white-space: normal;
        height: auto;
        width: auto;
        min-width: 130px;
        padding-left: 10px;
        padding-right: 10px;
    }

    div#page {
        margin-left: 1em;
        margin-right: 1em;
    }

    .carousel-inner {
        background-color: #eee;
        height: auto;
    }

    .buttons {
        position: absolute;
        top: 50%;
        left: 10px;
        transform: translateY(-50%);
        z-index: 99;
    }

    /* .buttons button {
        display: block;
        margin-bottom: 3px;
        outline: none;
    } */

    .btn:hover {
        background-color: #B10A0A;
        border: #B10A0A;
    }

    .btn:focus {
        background-color: #B10A0A;
        border: none;
        outline: none;
        box-shadow: none;
    }

    #chart-container.zoomable {
        cursor: zoom-in;
    }

#chart-container img {
    width: auto;
    height: auto;
    max-height: 100%;
    max-width: 100%;
}

</style>

<main class="main">

    <!-- breadcrumb -->
    <div class="site-breadcrumb" style="background: url('{{ $image_banner }}')">
        <div class="container">
            <h2 class="breadcrumb-title">{{$title_banner}}</h2>
            <ul class="breadcrumb-menu">
                <li><a href="/">Home</a></li>
                <li class="active">Struktur Organisasi</li>
            </ul>
        </div>
    </div>
    <!-- breadcrumb end -->

     <!-- team-area -->
    <!-- @if($item)
        <div class="team-area pt-120 pb-50">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 mx-auto">
                        <div class="site-heading text-center">
                            <span class="site-title-tagline"><i class="far fa-lightbulb-on"></i> Tim
                                Kami</span>
                            <h2 class="site-title">Struktur <span>Organisasi</span></h2>
                        </div>
                    </div>
                </div>
                <div class="row mt-5">
                    <div id="chart-container"></div>
                </div>
            </div>
        </div>
        @else
        <div class="text-center">Tidak Ada Konten</div>
        @endif -->
    <!-- team-area end -->

    @if($item)
    <div class="team-area pt-120 pb-50">
        <!-- <div class="container"> -->
            <div id="page">
                <div class="row">
                    <div class="col-lg-6 mx-auto">
                        <div class="site-heading text-center">
                            <span class="site-title-tagline"><i class="far fa-lightbulb-on"></i> Tim
                                Kami</span>
                            <h2 class="site-title">{{ $item->title }}</h2>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div id="imgDiv">

                            <div class="buttons" style="position: relative;">
                                <button class="zoom-out btn btn-outline-primary"
                                    style="position: absolute; top: 10px; left: 10px;">
                                    <!-- <span class="glyphicon glyphicon-minus"></span> -->
                                    -
                                </button>
                                <button class="zoom-in btn btn-outline-primary"
                                    style="position: absolute; top: 10px; left: 42px;">
                                    <!-- <span class="glyphicon glyphicon-plus"></span> -->
                                    +
                                </button>
                                <button class="reset btn btn-primary"
                                    style="position: absolute; top: 10px; left: 80px;">Reset</button>
                            </div>

                            <div id="chart-container" class="carousel-inner zoomable">
                                <!-- Wrapper for slides -->
                                <div class="carousel-inner" role="listbox">
                                    <div class="item active">
                                        <img id="carousel-image" src="{{ $item['image_url'] }}" class="img-responsive"
                                            alt="Dicom">
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        <!-- </div> -->
    </div>
    @else
    <div class="text-center">Tidak Ada Konten</div>
    @endif

</main>

@if($item)
@section('js')
@parent
<script type="text/javascript" src="{{asset('src/orgchart/js/jquery.orgchart.js')}}"></script>
<script>
    $(document).ready(function () {
    var scale = 2;
    var minScale = 0.5;
    var maxScale = 3;
    var step = 0.1;

    var isDragging = false;
    var startX;
    var startY;
    var translateX = 0;
    var translateY = 0;

    function zoom(scale) {
        $('#carousel-image').css({
            transform: 'scale(' + scale + ') translate(' + translateX + 'px, ' + translateY + 'px)',
            transformOrigin: 'top'
        });
    }

    zoom(2);

    $(".zoom-in").click(function () {
        scale += step;
        if (scale > maxScale) {
            scale = maxScale;
        }
        zoom(scale);
    });

    $(".zoom-out").click(function () {
        scale -= step;
        if (scale < minScale) {
            scale = minScale;
        }
        zoom(scale);
    });

    $(".reset").click(function () {
        scale = 2;
        translateX = 0;
        translateY = 0;
        zoom(scale);
    });

    $('#chart-container').mousedown(function (e) {
        isDragging = true;
        startX = e.clientX;
        startY = e.clientY;
    });

    $('#chart-container').mouseup(function () {
        isDragging = false;
    });

    $('#chart-container').mousemove(function (e) {
        if (isDragging) {
            var newTranslateY = translateY + (e.clientY - startY);
            translateY = newTranslateY;
            zoom(scale);
            startY = e.clientY;
        }
    });

    $('#chart-container').hover(function () {
        $(this).toggleClass('zoomable');
    });

    $('#chart-container').mousemove(function (e) {
        var movementX = e.clientX - startX;
        startX = e.clientX;
        if (isDragging) {
            translateX += movementX;
            zoom(scale);
        }
    });

    // @if($item['content'])
    //     var datascource = {!! json_encode($item['content']) !!};
    // @else
    //     var datascource = {};
    // @endif

    // var oc = $('#chart-container').orgchart({
    //     'data': datascource,
    //     'nodeContent': 'title',
    //     'pan': true,
    //     'zoom': true,
    //     'showControls': true,
    //     'parentNodeSymbol': '',
    //     'includeNodeData': true,
    //     'createNode': function ($node, data) {
    //         // $node.children('.title').html(<p contenteditable="true" class="text-white text-name">${data.name}</p>)
    //         // $node.children('.content').html(`
    //         //     <p contenteditable="true" class="text-content">${data.title}</p>
    //         //     <div class="p-1">
    //         //         <a href="javascript:void(0);" class="text-success btn-add-node"><i class="fa fa-plus-circle"></i></a>
    //         //         ${data.level > 1 ? '<a href="javascript:void(0);" class="text-danger btn-remove-node"><i class="fa fa-minus-circle"></i></a>' : ''}
    //         //     </div>
    //         // `)

    //     },
    // });
    // $('.orgchart').addClass('noncollapsable');
});

</script>
@endsection
@endif
@endsection