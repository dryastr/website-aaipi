@extends('member.layouts.master')

@section('title', 'Buat Pembayaran Keanggotaan')
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
                <small class="text-muted">Isi formulir di bawah untuk membuat pembayaran keanggotaan</small>
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
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <div class="card-body">
                <form action="{{ route('tagihan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group row">
                        <label for="tagihan_id" class="col-md-4 col-form-label text-md-right">Tagihan Keanggotaan</label>
                        <input type="hidden" name="tagihan_id" id="tagihan_id" value="{{ request('tagihan_id') }}">
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="tagihan" name="tagihan" readonly value="{{ $biayaKeanggotaan->biaya ?? '' }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="nominal_bayar" class="col-md-4 col-form-label text-md-right">Nominal Pembayaran</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="nominal_bayar" name="nominal_bayar" value="{{ $biayaKeanggotaan->biaya ?? '' }}" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="catatan" class="col-md-4 col-form-label text-md-right">Catatan</label>
                        <div class="col-md-6">
                            <textarea class="form-control" id="catatan" name="catatan" rows="3"></textarea>
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
                                <img id="preview" src="#" alt="Image Preview" style="display: none; max-width: 100%; max-height: 200px; border: 1px solid #ccc; padding: 5px;">
                                <span id="file-size-info" style="display: none; color: red;"></span>
                            </div>
                            <small class="text-muted mt-2">Image atau PDF maksimal 2 MB</small>
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

    <script>
        function previewImage(input) {
            var preview = document.getElementById('preview');
            var fileSizeInfo = document.getElementById('file-size-info');
            var customFileLabel = document.querySelector('.custom-file-label');

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };

                reader.readAsDataURL(input.files[0]);

                // Display file size information
                var fileSize = input.files[0].size / 1024 / 1024; // in MB
                fileSizeInfo.textContent = 'File size: ' + fileSize.toFixed(2) + ' MB';

                if (fileSize > 2) {
                    fileSizeInfo.style.display = 'block';
                    preview.style.display = 'none';
                    customFileLabel.innerHTML = 'Pilih file...';
                } else {
                    fileSizeInfo.style.display = 'none';
                    customFileLabel.innerHTML = input.files[0].name;
                }
            }
        }
    </script>


@endsection
