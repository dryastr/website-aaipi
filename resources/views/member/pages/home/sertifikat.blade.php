<section class="services line graybg col-md-12 padding_50 padbot_50">
    <div class="section-title bottom_45"><span></span><h2>Sertifikat Saya</h2></div>
    <div class="row equal">
        <!-- a service -->
        @if($user['role_id']==2 && isset($sertifikat))
            @foreach($sertifikat['data'] as $sertifikat)
            <div class="col-md-4 col-sm-6 col-xs-12 h-100">
                <div class="service" style="height: 100%;">
                    <div class="icon">
                        <i class="flaticon-attach"></i>
                    </div>
                    <span class="title">{{$sertifikat['nama_kompetensi']}}</span>
                    <p class="little-text">{{$sertifikat['nama_diklat']}}</p>
                </div>
            </div>
            @endforeach
        @endif
        <!-- a service -->
        <div class="col-md-4 col-sm-6 col-xs-12 h-100">
            <a href="https://dev-lms.aaipi.id" targer="_blank">
                <div class="service justify-content-center row" style="border: 3px dashed #CCC; height: 100%;">
                    <div class="icon plus" style="text-align: center; padding: 30px;">
                        <i class="fa fa-plus"></i>
                    </div>
                </div>
            </a>
        </div>
    </div>
</section>
