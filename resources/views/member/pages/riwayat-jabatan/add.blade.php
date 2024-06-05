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
                            <a href="{{route('member.riwayat-jabatan.index')}}" class="edit-icon btn btn-danger">Batal</a>
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

                    <form action="{{ route('member.riwayat-jabatan.store') }}" method="POST" enctype="multipart/form-data" class="row g-3">
                        @csrf
                        <div class="col-md-12">
                            <div class="input-group" style="margin-bottom: 2rem">
                                <label for="inputEmail4" class="form-label">NIP / NRP</label>
                                <div style="display: flex;">
                                    <select name="status_nip_nrp" class="form-select" style="flex-shrink: 1">
                                        <option value="nip">NIP</option>
                                        <option value="nrp">NRP</option>
                                    </select>

                                    <input type="text" name="nip_nrp" class="form-control" placeholder="NIP / NRP">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" style="margin-bottom: 2rem">
                            <label class="form-label">Kode Jenjang Jabatan</label>
                            <input type="text" class="form-control" name="kode_jenjang_jabatan">
                        </div>
                        <div class="col-md-6" style="margin-bottom: 2rem">
                            <label class="form-label">Kode Jabatan</label>
                            <input type="text" class="form-control" name="kode_jabatan">
                        </div>
                        <div class="col-md-6" style="margin-bottom: 2rem">
                            <label class="form-label">Nama Jenjang Jabatan</label>
                            <input type="text" class="form-control" name="nama_jenjang_jabatan">
                        </div>
                        <div class="col-md-6" style="margin-bottom: 2rem">
                            <label class="form-label">Level Jenjang Jabatan</label>
                            <input type="number" class="form-control" name="level_jenjang_jabatan">
                        </div>
                        <div class="col-md-6" style="margin-bottom: 2rem">
                            <label class="form-label">Nomor SK</label>
                            <input type="text" class="form-control" name="nomor_sk">
                        </div>
                        <div class="col-md-6" style="margin-bottom: 2rem">
                            <label class="form-label">Tanggal SK</label>
                            <input type="date" class="form-control" name="tanggal_sk">
                        </div>
                        <div class="col-md-6" style="margin-bottom: 2rem">
                            <label class="form-label">TMT Jabatan</label>
                            <input type="date" class="form-control" name="tmt_jabatan">
                        </div>
                        <div class="col-md-6" style="margin-bottom: 2rem">
                            <label class="form-label">Dokumen</label>
                            <input type="file" accept="application/pdf" class="form-control" name="dokumen">
                            image, atau pdf maksimal 2 MB
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
