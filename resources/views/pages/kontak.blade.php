@extends('layouts.master')

@section('content')

<main class="main">

<!-- breadcrumb -->
<div class="site-breadcrumb" style="background: url('{{ $image_banner }}')">
{{-- <div class="site-breadcrumb" style="background: url(assets/img/breadcrumb/01.jpg)"> --}}
    <div class="container">
        <h2 class="breadcrumb-title">{{$title_banner}}</h2>
        <ul class="breadcrumb-menu">
            <li><a href="index.html">Home</a></li>
            <li class="active">Kontak</li>
        </ul>
    </div>
</div>
<!-- breadcrumb end -->


<!-- contact area -->
<div class="contact-area py-120">
    <div class="container">
        <div class="contact-content">
            <div class="row">
                @if($alamatKantor)
                <div class="col-md-3">
                    <div class="contact-info">
                        <div class="contact-info-icon">
                            <i class="far fa-location-dot"></i>
                        </div>
                        <div class="contact-info-content">
                            <h5>{{$alamatKantor['title']}}</h5>
                            <p>{{$alamatKantor['content']}}</p>
                        </div>
                    </div>
                </div>
                @endif

                @if($hubungiKami)
                <div class="col-md-3">
                    <div class="contact-info">
                        <div class="contact-info-icon">
                            <i class="fal fa-phone-volume"></i>
                        </div>
                        <div class="contact-info-content">
                            <h5>{{$hubungiKami['title']}}</h5>
                            <p>{{$hubungiKami['content']}}</p>
                        </div>
                    </div>
                </div>
                @endif

                @if($emailKami)
                <div class="col-md-3">
                    <div class="contact-info">
                        <div class="contact-info-icon">
                            <i class="fal fa-envelopes"></i>
                        </div>
                        <div class="contact-info-content">
                            <h5>{{$emailKami['title']}}</h5>
                            <p>{{$emailKami['content']}}</p>
                        </div>
                    </div>
                </div>
                @endif

                @if($jamKerja)
                <div class="col-md-3">
                    <div class="contact-info">
                        <div class="contact-info-icon">
                            <i class="fal fa-alarm-clock"></i>
                        </div>
                        <div class="contact-info-content">
                            <h5>{{$jamKerja['title']}}</h5>
                            <p>{{$jamKerja['content']}}</p>
                        </div>
                    </div>
                </div>
                @endif

            </div>
        </div>

        @if($data)
        <div class="contact-wrapper">
            <div class="row">
                <div class="col-lg-5">
                    <div class="contact-img">
                        {{-- <img src="assets/img/contact/evos.ph" alt=""> --}}
                        <img src="{{ $data['image_url'] ? $data['image_url'] : asset('assets/img/team/01.jpg')}}" alt="Gambar Program Kerja" style="height: 650px">
                    </div>
                </div>
                <div class="col-lg-7 align-self-center">
                    <div class="contact-form">
                        <div class="contact-form-header">
                            <h2>{{ $data['title']}}</h2>
                            <p>{!!$data['content']!!}</p>
                            {{-- <p> consectetur adipisicing elit. Iste pariatur ullam ut, sapiente doloremque debitis, quo in iure illo fuga quod ipsum quisquam adipisci delectus? Quam et aliquam eius tenetur.</p> --}}
                        </div>
                        <form method="post" action="/electrow/assets/php/contact.php" id="contact-form">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="name"
                                            placeholder="Nama" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="email" class="form-control" name="email"
                                            placeholder="Email" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="subject"
                                    placeholder="subjek" required>
                            </div>
                            <div class="form-group">
                                <textarea name="message" cols="30" rows="5" class="form-control"
                                    placeholder="Pesan"></textarea>
                            </div>
                            <button type="submit" class="theme-btn">Kirim
                                Pesan <i class="far fa-paper-plane"></i></button>
                            <div class="col-md-12 mt-3">
                                <div class="form-messege text-success"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="text-center">Tidak Ada Data</div>
        @endif
    </div>
</div>
<!-- end contact area -->

<!-- map -->
<div class="contact-map">
    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d5513.128235585037!2d106.86338936005251!3d-6.195881712286157!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f45e3ea485ed%3A0x88df67baf969f29f!2sAAIPI!5e0!3m2!1sen!2sid!4v1708000945692!5m2!1sen!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</div>

</main>

@endsection
