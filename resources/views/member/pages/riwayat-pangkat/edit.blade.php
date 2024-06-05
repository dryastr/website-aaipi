@extends('member.layouts.master')

@section('title', 'Home')

@section('content')
    {{-- Konten halaman home --}}
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
                            <a href="{{route('member.riwayat-pangkat.index')}}" class="edit-icon btn btn-danger">Batal</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li style="padding-left: 10px;">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('member.riwayat-pangkat.update', $item['id']) }}" method="POST" enctype="multipart/form-data" class="row g-3">
                        @csrf
                        <div class="col-md-6" style="margin-bottom: 2rem">
                            <label class="form-label">Jabatan</label>
                            <select name="jabatan_id" class="form-control">
                                @foreach ($dataJabatan as $i)
                                <option @selected($item['jabatan_id'] == $i['id']) value="{{$i['id']}}">{{$i['nama_jenjang_jabatan']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6" style="margin-bottom: 2rem">
                            <label class="form-label">Nama Pangkat</label>
                            <input type="text" class="form-control" name="nama_pangkat" value="{{$item['nama_pangkat']}}">
                        </div>
                        <div class="col-md-6" style="margin-bottom: 2rem">
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection

<style>
    .input-group {
        display: block !important;
    }
</style>

@push('scripts')
<script>

</script>
@endpush
