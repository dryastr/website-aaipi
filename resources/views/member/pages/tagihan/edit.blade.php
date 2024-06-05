@extends('member.layouts.master')

@section('title', 'Edit Pembayaran Keanggotaan')
@section('tagihan-tab', 'active')

@section('content')
    <div class="row layout-top-spacing">
        <div class="col-md-12 layout-spacing">
            <div class="row">
                <div class="col-md-6">
                    <div class="section-title bottom_30"><span></span><h2>{{ $title }}</h2></div>
                </div>
                <div class="col-md-6" style="text-align: right">
                    <!-- Tambahkan tombol kembali -->

                </div>
            </div>

            <!-- Tambahkan subjudul dengan icon alert info -->
            <div class="alert alert-info alert-dismissible" role="alert">
                <i class="fa fa-info-circle mr-2"></i>
                <small class="text-muted">Isi formulir di bawah untuk mengedit pembayaran keanggotaan</small>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true"></span>
                </button>
            </div>

            {{-- Menampilkan pesan error jika validasi tidak berhasil --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li style="padding-left: 10px;">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Menampilkan pesan berhasil --}}
            {{-- @if(session()->has('success'))
            <div class="alert alert-success text-center">
                 {{ session()->get('success') }}
            </div>
        @endif --}}
        

            <div class="card-body">
                <form action="{{ route('tagihan.update', $pembayaranKeanggotaan->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group row">
                        <label for="nominal_bayar" class="col-md-4 col-form-label text-md-right">Nominal Pembayaran</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="nominal_bayar" name="nominal_bayar" value="{{ $pembayaranKeanggotaan->nominal_bayar }}" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="catatan" class="col-md-4 col-form-label text-md-right">Catatan</label>
                        <div class="col-md-6">
                            <textarea class="form-control" id="catatan" name="catatan" rows="3">{{ $pembayaranKeanggotaan->catatan }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="attachment" class="col-md-4 col-form-label text-md-right">Attachment</label>
                        <div class="col-md-6">
                            <input type="file" class="form-control-file" id="attachment" name="attachment">
                            @if($pembayaranKeanggotaan->attachment)
                                @if(strpos($pembayaranKeanggotaan->attachment->extension, 'pdf') !== false)
                                   
                                    <embed src="{{ $pembayaranKeanggotaan->attachment->file_url }}" type="application/pdf" width="100%" height="600px">
                                @else
                                    
                                    <img src="{{ $pembayaranKeanggotaan->attachment->file_url }}" alt="{{ $pembayaranKeanggotaan->attachment->name }}" style="max-width: 100%; height: auto;">
                                @endif
                                <p class="mt-2">Attachment Saat Ini: 
                                    <a href="{{ $pembayaranKeanggotaan->attachment->file_url }}" target="_blank">{{ $pembayaranKeanggotaan->attachment->name }}</a>
                                    <br>
                                    <a class="btn btn-primary" href="{{ $pembayaranKeanggotaan->attachment->file_url }}" target="_blank">Buka</a>
                                </p>
                            @else
                                <p class="text-muted mt-2">Tidak ada attachment</p>
                            @endif
                        </div>
                    </div>
                    
                    
                    
                    
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <a href="{{ route('member.tagihan') }}" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Kembali</a> <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
