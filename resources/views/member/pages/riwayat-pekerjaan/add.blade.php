@extends('member.layouts.master')

@section('title', 'Home')

@section('content')
@section('head-extra')
    <link rel="stylesheet" href="{{ asset('src/plugins/src/filepond/filepond.min.css') }}">
    <link rel="stylesheet" href="{{ asset('src/plugins/src/filepond/FilePondPluginImagePreview.min.css') }}">
    <link href="{{ asset('src/plugins/css/light/filepond/custom-filepond.css') }}" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="{{ asset('src/assets/css/light/apps/blog-create.css') }}">
    <script src="{{ asset('assets/ckeditor/ckeditor.js') }}"></script>
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
                {{-- @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li style="padding-left: 10px;">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif --}}

                <form action="{{ route('member.riwayat-pekerjaan.store') }}" method="POST"
                    enctype="multipart/form-data" class="row g-3">
                    @csrf
                    <div class="col-md-6" style="margin-bottom: 2rem">
                        <label class="form-label">Nama Intansi/Perusahaan</label>
                        <input type="text" class="form-control" name="nama_perusahaan" maxlength="50">
                        @if ($errors->has('nama_perusahaan'))
                            <span
                                style="color: red; font-size: 12px; margin-top: 2px;">{{ 'Nama perusahaan wajib diisi' }}</span>
                        @endif
                    </div>
                    <div class="col-md-6" style="margin-bottom: 2rem">
                        <label class="form-label">Jabatan</label>
                        <input type="text" class="form-control" name="jabatan" maxlength="40">
                        @if ($errors->has('jabatan'))
                            <span
                                style="color: red; font-size: 12px; margin-top: 2px;">{{ 'Jabatan wajib diisi' }}</span>
                        @endif
                    </div>
                    <div class="col-md-6" style="margin-bottom: 2rem">
                        <label class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" name="tanggal_mulai">
                        @if ($errors->has('tanggal_mulai'))
                            <span
                                style="color: red; font-size: 12px; margin-top: 2px;">{{ 'Tanggal mulai wajib diisi' }}</span>
                        @endif
                    </div>
                    <div class="col-md-6" style="margin-bottom: 2rem">
                        <label class="form-label">Tanggal Selesai</label>
                        <input type="date" class="form-control" name="tanggal_selesai">
                        @if ($errors->has('tanggal_selesai'))
                            <span
                                style="color: red; font-size: 12px; margin-top: 2px;">{{ 'Tanggal selesai wajib diisi' }}</span>
                        @endif
                    </div>
                    <div class="col-sm-12" style="margin-bottom: 2rem">
                        <label>Deskripsi</label>
                        <textarea id="editor-deskripsi" name="deskripsi"></textarea>
                        <div id="feedback-deskripsi" class=""></div>
                    </div>
                    <!-- <div class="col-md-12" style="margin-bottom: 2rem">
                            <label class="form-label">Deskripsi</label>
                            <textarea type="text" class="form-control" name="nama_jenjang_jabatan"></textarea>
                        </div> -->
                    <!-- Tambahkan tombol kembali -->
                    <div style="padding: 0 15px">
                        <a href="{{ route('member.riwayat-pekerjaan.index') }}"
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

        var textContent = CKEDITOR.replace('editor-deskripsi', {
            toolbar: [{
                    name: 'styles',
                    items: ['Bold', 'Italic', 'Underline', 'Format']
                },
                {
                    name: 'paragraph',
                    items: ['NumberedList', 'BulletedList', 'Blockquote', 'JustifyLeft',
                        'JustifyCenter', 'JustifyRight', 'JustifyBlock'
                    ]
                },
                {
                    name: 'basicstyles',
                    items: ['Font', 'FontSize']
                }
            ],
            removeButtons: 'Save,NewPage,ExportPdf,Preview,Print,Smiley,Iframe,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Find,SelectAll,Scayt,Replace,Language,PasteFromWord',
        });


        // var ecommerce = FilePond.create(document.querySelector('.file-upload'), {

        //     storeAsFile: true,
        // });

        form.on('submit', function(e) {
            e.preventDefault();

            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var formData = new FormData(form[0]); // Gunakan FormData untuk menangani file input

            formData.append('_token', csrfToken);
            formData.append('deskripsi', CKEDITOR.instances['editor-deskripsi'].getData());

            $.ajax({
                type: 'POST',
                url: "{{ route('member.riwayat-pekerjaan.store') }}",
                dataType: 'json',
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    btn.html(
                            '<div class="spinner-border text-white me-2 align-self-center loader-sm "></div> Loading'
                        )
                        .attr('disabled', true);
                },
                success: function(res) {
                    main.notification(res.message, NOTIFICATION_COLOR.SUCCESS);
                    window.location.href = "{{ route('member.riwayat-pekerjaan.index') }}";
                },
                error: function(res) {
                    var response = res.responseJSON;
                    btn.html('Simpan').attr('disabled', false);
                    main.notification(response.message, NOTIFICATION_COLOR.DANGER);

                    if (typeof response.errors === 'object') {
                        Object.keys(response.errors).map(function(i) {
                            var message = response.errors[i];
                            $('#feedback-' + i).addClass('invalid-feedback')
                                .html(message);
                        });
                    }

                    form.addClass('was-validated');
                },
                complete: function() {
                    // Handle completion if needed
                }
            });
        });
    });
</script>
@endpush
