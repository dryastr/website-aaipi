@extends('member.layouts.master')

@section('title', 'Home')

@section('content')

    {{-- Konten halaman home --}}
    <div id="home" class="row">
        @if($user['role_id']==3)
            @if($user['registration']['status_approval']=='dalam-antrian')
            <div class="col-md-12">
                <div class="alert alert-info alert-dismissible" role="alert">
                    <i class="fa fa-info-circle mr-2"></i>
                    <small class="text-muted">Keanggotaan Anda masih dalam tahap verifikasi Admin, silakan <a href="{{ route("member.change-profile.index") }}" class="site-btn icon">melengkapi profil</a> untuk mempermudah Admin melakukan verifikasi</small>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            @elseif($user['registration']['status_approval']=='ditolak')
            <div class="col-md-12">
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <i class="fa fa-info-circle mr-2"></i>
                    <small class="text-muted">Keanggotaan Anda DITOLAK oleh admin</small>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            @endif
        @else

        {{-- Bagian About Me --}}
        @include('member.pages.home.about')

        {{-- Bagian Services --}}
        @include('member.pages.home.sertifikat')

        {{-- Bagian Skills --}}
        @include('member.pages.home.jamPelajaran')
        @endif
    </div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
      var donutOptions = {
        chart: {
          type: 'donut',
        },
        series: [0, 100],
        labels: ['0 JP','60 dari 60 JP'],
        colors: ['#4CAF50','#CCC'],
      };

      var donutChart = new ApexCharts(document.querySelector("#jpChart"), donutOptions);
      donutChart.render();
    });
  </script>
@endpush
