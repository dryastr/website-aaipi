@extends('member.layouts.master')

@section('title', 'Home')

@section('content')@section('head-extra')
<link rel="stylesheet" href="{{ asset('src/plugins/src/filepond/filepond.min.css') }}">
<link rel="stylesheet" href="{{ asset('src/plugins/src/filepond/FilePondPluginImagePreview.min.css') }}">
<link href="{{ asset('src/plugins/css/light/filepond/custom-filepond.css') }}" rel="stylesheet" type="text/css" />
<style>
    .input-group {
        display: block !important;
    }
</style>
@endsection
<div class="row">
<section class="about-me line col-md-12 padding_30 padbot_45">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <div class="section-title bottom_30"><span></span>
                        <h2>{{ $title }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('member.riwayat-pendidikan.update', $item['id']) }}" method="POST"
                enctype="multipart/form-data" class="row g-3">
                @csrf
                <div class="col-md-6" style="margin-bottom: 2rem">
                    <label class="form-label">Gelar Depan</label>
                    <input type="text" class="form-control" name="gelar_depan"
                        value="{{ $item['gelar_depan'] }}">
                </div>
                <div class="col-md-6" style="margin-bottom: 2rem">
                    <label class="form-label">Gelar Belakang</label>
                    <input type="text" class="form-control" name="gelar_belakang"
                        value="{{ $item['gelar_belakang'] }}">
                        @if ($errors->has('gelar_belakang'))
                        <span
                            style="color: red; font-size: 12px; margin-top: 2px;">{{ 'Gelar belakang wajib diisi' }}</span>
                    @endif
                </div>
                <div class="col-md-6" style="margin-bottom: 2rem">
                    <label class="form-label">Nomor Ijazah</label>
                    <input type="text" class="form-control" name="nomor_ijazah"
                        value="{{ $item['nomor_ijazah'] ?? 'no' }}" minlength="15" maxlength="17">
                        @if ($errors->has('nomor_ijazah'))
                        <span
                            style="color: red; font-size: 12px; margin-top: 2px;">{{ 'Nomor ijazah wajib diisi' }}</span>
                    @endif
                </div>
                <div class="col-md-6" style="margin-bottom: 2rem">
                    <label class="form-label">Tanggal Ijazah</label>
                    <input type="date" class="form-control" name="tanggal_ijazah"
                        value="{{ $item['tanggal_ijazah'] }}">
                        @if ($errors->has('tanggal_ijazah'))
                        <span
                            style="color: red; font-size: 12px; margin-top: 2px;">{{ 'Tanggal ijazah wajib diisi' }}</span>
                    @endif
                </div>
                <div class="row ">
                    <div class="col-md-12" style="margin-bottom: 2rem">
                        <label class="form-label">Dokumen</label>
                        <div class="multiple-file-upload" style="display: block; position: relative;">
                            <input type="file" accept="application/pdf" class="filepond file-upload"
                                name="dokumen" id="product-dokumen" data-allow-reorder="true"
                                data-max-file-size="3MB" data-max-files="5">
                        </div>
                        <div style="margin-top: 7rem">
                            <p>{{ $item['dokumen'] }}</p>
                            <p>masukkan PDF maksimal 3 MB</p>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-md-6" style="margin-bottom: 2rem">
                        <label class="form-label">Dokumen</label>
                        <input type="file" accept="application/pdf" class="form-control" name="dokumen">
                        image, atau pdf maksimal 2 MB
                    </div> -->
                <div class="col-md-12">
                    <div class="input-group" style="margin-bottom: 2rem">
                        <label for="inputEmail4" class="form-label">Strata</label>
                        <div style="display: flex;" class="w-screen">
                            <select name="strata" class="form-select" style="width:100%">
                                <option value="sd/mi" @selected($item['strata'] == 'sd/mi') value="sd/mi">SD/MI</option>
                                <option value="smp/mts" @selected($item['strata'] == 'smp/mts') value="smp/mts">SMP/MTS
                                </option>
                                <option value="sma/smk/ma" @selected($item['strata'] == 'sma/smk/ma') value="sma/smk/ma">
                                    SMA/SMK/MA</option>
                                <option value="di" @selected($item['strata'] == 'di') value="di">D1</option>
                                <option value="dii" @selected($item['strata'] == 'dii') value="dii">D2</option>
                                <option value="diii" @selected($item['strata'] == 'diii') value="diii">D3</option>
                                <option value="si/div" @selected($item['strata'] == 'si/div') value="si/div">S1/DIV</option>
                                <option value="sii" @selected($item['strata'] == 'sii') value="sii">S2</option>
                                <option value="siii" @selected($item['strata'] == 'siii') value="siii">S3</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6" style="margin-bottom: 2rem">
                    <label class="form-label">Perguruan Tinggi</label>
                    <input type="text" class="form-control" name="perguruan_tinggi"
                        value="{{ $item['perguruan_tinggi'] }}" maxlength="40"
                        style="text-transform: uppercase;">
                    @if ($errors->has('perguruan_tinggi'))
                        <span
                            style="color: red; font-size: 12px; margin-top: 2px;">{{ 'Perguruan tinggi wajib diisi' }}</span>
                    @endif
                </div>
                <div class="col-md-6" style="margin-bottom: 2rem">
                    <label class="form-label">Program Studi</label>
                    <input type="text" class="form-control" name="program_studi"
                        value="{{ $item['program_studi'] }}" maxlength="25" style="text-transform: uppercase;">
                    @if ($errors->has('program_studi'))
                        <span
                            style="color: red; font-size: 12px; margin-top: 2px;">{{ 'Program Studi wajib diisi' }}</span>
                    @endif
                </div>
                <div style="padding: 0 15px">
                    <a href="{{ route('member.riwayat-pendidikan.index') }}"
                        class="edit-icon btn btn-danger">Batal</a>
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
<script src="{{ asset('src/plugins/src/filepond/filepond.min.js') }}"></script>
<script src="{{ asset('src/plugins/src/filepond/FilePondPluginFileValidateType.min.js') }}"></script>
<script src="{{ asset('src/plugins/src/filepond/FilePondPluginImageExifOrientation.min.js') }}"></script>
<script src="{{ asset('src/plugins/src/filepond/FilePondPluginImagePreview.min.js') }}"></script>
<script src="{{ asset('src/plugins/src/filepond/FilePondPluginImageCrop.min.js') }}"></script>
<script src="{{ asset('src/plugins/src/filepond/FilePondPluginImageResize.min.js') }}"></script>
<script src="{{ asset('src/plugins/src/filepond/FilePondPluginImageTransform.min.js') }}"></script>
<script src="{{ asset('src/plugins/src/filepond/filepondPluginFileValidateSize.min.js') }}"></script>
<script>
    $(document).ready(function() {

        FilePond.registerPlugin(
            FilePondPluginImagePreview,
            FilePondPluginImageExifOrientation,
            FilePondPluginFileValidateSize,
            FilePondPluginFileValidateType,
            // FilePondPluginImageEdit
        );

        var ecommerce = FilePond.create(document.querySelector('.file-upload'), {
            storeAsFile: true,
            @if ($item['document_url'])
                files: [{
                    // the server file reference
                    source: '{{ $item[
                        '
                                    document_url '
                    ] }}',

                    // set type to limbo to tell FilePond this is a temp file
                    // options: {
                    //     type: 'image/png',
                    // },
                }, ],
            @endif
        });
    });
</script>
@endpush
