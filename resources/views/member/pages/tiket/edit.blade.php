@extends('member.layouts.master')

@section('title', 'Ubah Tiket')
@section('tiket-tab', 'active')

@section('content')
<div class="row layout-top-spacing">
    <div class="col-md-12 layout-spacing">

        <div class="row">
            <div class="col-md-6">
                <div class="section-title bottom_30"><span></span><h2>{{ $title }}</h2></div>
            </div>
            <div class="col-md-6" style="text-align: right">

            </div>
        </div>

        <div class="alert alert-info alert-dismissible" role="alert">
            <i class="fa fa-info-circle mr-2"></i>
            <small class="text-muted">Ubah tiket yang telah Anda buat</small>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li style="padding-left: 10px;">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <div class="card-body">
            <form action="{{ route('tiket.update', $tiket->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group row">
                    <label for="judul" class="col-md-4 col-form-label text-md-right">Judul</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="judul" name="judul" value="{{ $tiket->judul }}" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="deskripsi" class="col-md-4 col-form-label text-md-right">Deskripsi</label>
                    <div class="col-md-6">
                        <textarea class="form-control" id="deskripsi" name="deskripsi" required>{{ $tiket->deskripsi }}</textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="ref_tiket_jenis_id" class="col-md-4 col-form-label text-md-right">Jenis Tiket</label>
                    <div class="col-md-6">
                        <select class="form-control" id="ref_tiket_jenis_id" name="ref_tiket_jenis_id" required>
                            @foreach ($jenisTikets as $jenisTiket)
                                <option value="{{ $jenisTiket->id }}" {{ $tiket->ref_tiket_jenis_id == $jenisTiket->id ? 'selected' : '' }}>
                                    {{ $jenisTiket->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="prioritas" class="col-md-4 col-form-label text-md-right">Prioritas</label>
                    <div class="col-md-6">
                        <select class="form-control" id="prioritas" name="prioritas">
                            <option value="1" {{ $tiket->prioritas == 1 ? 'selected' : '' }}>Tinggi</option>
                            <option value="2" {{ $tiket->prioritas == 2 ? 'selected' : '' }}>Sedang</option>
                            <option value="3" {{ $tiket->prioritas == 3 ? 'selected' : '' }}>Rendah</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="attachment" class="col-md-4 col-form-label text-md-right">Lampiran Bukti Bayar</label>
                    <div class="col-md-6">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="attachment" name="attachment" onchange="previewImage(this)">
                            <label class="custom-file-label" for="attachment">Pilih file...</label>
                        </div>
                        <div class="mt-2">
                            <img id="preview" src="{{ $tiket->attachment ? asset($tiket->attachment) : '#' }}" alt="Image Preview" style="max-width: 100%; max-height: 200px; border: 1px solid #ccc; padding: 5px;">
                            <span id="file-size-info" style="display: none; color: red;"></span>
                        </div>
                        <small class="text-muted mt-2">Image atau PDF maksimal 2 MB</small>
                    </div>
                </div>
                

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <a href="{{ route('member.tiket') }}" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Kembali</a> <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection
