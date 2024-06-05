@extends('member.layouts.master')

@section('title', 'Home')

@section('content')
    <div class="row">
        <section class="about-me line col-md-12 padding_30 padbot_45">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="section-title bottom_30"><span></span><h2>{{ $title }}</h2></div>
                        </div>
                        <div class="col-md-6" style="text-align: right">
                            <!-- Tambahkan tombol kembali -->
                            <a class="edit-icon btn btn-primary" href="{{route('member.riwayat-pekerjaan.create')}}"><i class="fa fa-pencil"></i> Tambah</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if (count($data) > 0)
                    <ul class="list-group list-group-flush">
                        @foreach ($data as $item)
                        <li class="list-group-item">
                            <div class="d-flex list-jabatan">
                                <div class="p-2 w-100">
                                    <div class="d-flex flex-column">
                                        <div class="title">{{$item['nama_perusahaan']}}</div>
                                        <div class="text">
                                            <p>{{$item['jabatan']}}</p>
                                            <p>Tanggal Selesai: {{$item['tanggal_selesai']}}.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-2 flex-shrink-1 action">
                                    <a href="{{route('member.riwayat-pekerjaan.edit', encrypt($item['id']))}}" class="btn btn-success" style="margin-right: 3px"><i class="fa fa-pencil"></i></a>
                                    <a href="{{route('member.riwayat-pekerjaan.delete', $item['id'])}}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    @else
                    <div class="d-flex justify-center">
                        <img src="/assets/img/tidak-ada-data.png" alt="" style="width: 50%; margin: 0 auto;">
                    </div>                                      
                    @endif
                </div>
            </div>
        </section>
    </div>
@endsection

<style>
    .d-flex {
        display: flex !important;
    }

    .flex-column {
        flex-direction: column !important;
    }

    .w-100 {
        width: 100% !important;
    }

    .flex-shrink-1{
        flex-shrink: 1;
    }

    .list-group-flush>.list-group-item {
        border-width: 0 0 1px;
        margin-bottom: 1px;
    }

    .list-jabatan .title {
        font-size: 16px;
        font-weight: 500;
    }

    .list-jabatan .timeline {
        font-size: 12px;
        padding-bottom: 10px;
        display: block;
    }

    .list-jabatan .text {
        color: #989898;
        font-weight: 400;
        line-height: 14px;
        font-size: 14px;
    }

    .list-jabatan .text p {
        line-height: 15px;
    }

    .list-jabatan .action {
        display: flex;
        align-items: flex-start;
    }

</style>

@push('scripts')
<script>

</script>
@endpush
