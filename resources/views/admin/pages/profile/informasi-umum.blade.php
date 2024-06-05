@extends('admin.pages.profile.index')

@push('headerFile')
<link rel="stylesheet" href="{{asset('src/plugins/src/filepond/filepond.min.css')}}">
<link rel="stylesheet" href="{{asset('src/plugins/src/filepond/FilePondPluginImagePreview.min.css')}}">
<link href="{{asset('src/plugins/css/light/filepond/custom-filepond.css')}}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
<div class="row">
    <div class="col-lg-12">
        <form id="form-profile">
            <div class="row">
                <div class="col-xl-3 col-lg-12 col-md-4">
                    <div class="card">
                        <div class="profile-image my-4">
                            <div class="img-uploader-content">
                                <input type="file" class="filepond" name="avatar"
                                    accept="image/png, image/jpeg, image/gif" />
                            </div>
                            <h5 class="text-center mt-3">Profile Keanggotaan</h5>
                            <p class="text-center mt-2 fw-bold">{{ $user->fullname }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-12 col-md-8 mt-md-0 mt-4">
                    <div class="card">
                        <div class="form mx-3 my-2">
                            <div class="row">
                                <!-- <div class="col-md-6"> -->
                                @isset($item['registration'])
                                <div class="form-group border-bottom rounded-0">
                                    <div class="row g-2">
                                        <div class="col-md-4">
                                            <label class=" fw-bold fs-6" style="padding: 0.75rem 1.25rem">NIP</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control border-0" name="nip"
                                                value="{{$item['registration']['nip']}}">
                                            <div id="feedback-nip" class=""></div>
                                        </div>
                                    </div>
                                </div>
                                @endisset
                                <div class="form-group border-bottom rounded-0">
                                    <div class="row g-2">
                                        <div class="col-md-4">
                                            <label class=" fw-bold fs-6" style="padding: 0.75rem 1.25rem">Nama</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control border-0" name="fullname"
                                                value="{{$item['fullname']}}">
                                            <div id="feedback-fullname" class=""></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group border-bottom rounded-0">
                                    <div class="row g-2">
                                        <div class="col-md-4">
                                            <label class=" fw-bold fs-6" style="padding: 0.75rem 1.25rem">Email</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="email" class="form-control border-0" name="email"
                                                value="{{$item['email']}}">
                                            <div id="feedback-email" class=""></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group border-bottom rounded-0">
                                    <div class="row g-2">
                                        <div class="col-md-4">
                                            <label class=" fw-bold fs-6" style="padding: 0.75rem 1.25rem">Nomor
                                                Handphone</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control border-0" name="mobile"
                                                value="{{$item['mobile']}}">
                                            <div id="feedback-mobile" class=""></div>
                                        </div>
                                    </div>
                                </div>
                                @isset($item['registration'])
                                <div class="form-group border-bottom rounded-0">
                                    <div class="row g-2">
                                        <div class="col-md-4">
                                            <label class=" fw-bold fs-6" style="padding: 0.75rem 1.25rem">Nama
                                                Instans</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control border-0" name="nama_instansi"
                                                value="{{$item['registration']['nama_instansi']}}">
                                            <div id="feedback-nama_instansi" class=""></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group border-bottom rounded-0">
                                    <div class="row g-2">
                                        <div class="col-md-4">
                                            <label class=" fw-bold fs-6"
                                                style="padding: 0.75rem 1.25rem">Jabatan</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control border-0" name="jabatan"
                                                value="{{$item['registration']['jabatan']}}">
                                            <div id="feedback-jabatan" class=""></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group border-bottom rounded-0">
                                    <div class="row g-2">
                                        <div class="col-md-4">
                                            <label class=" fw-bold fs-6" style="padding: 0.75rem 1.25rem">Alamat</label>
                                        </div>
                                        <div class="col-md-8">
                                            <textarea class="form-control border-0"
                                                name="alamat">{{$item['registration']['alamat']}}</textarea>
                                            <div id="feedback-alamat" class=""></div>
                                        </div>
                                    </div>
                                </div>
                                @endisset
                                <!-- </div> -->
                                <div class="col-md-12 my-3">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success btn-submit">Simpan
                                            Perubahan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('footerFile')
<script src="{{asset('src/plugins/src/filepond/filepond.min.js')}}"></script>
<script src="{{asset('src/plugins/src/filepond/FilePondPluginFileValidateType.min.js')}}"></script>
<script src="{{asset('src/plugins/src/filepond/FilePondPluginImageExifOrientation.min.js')}}"></script>
<script src="{{asset('src/plugins/src/filepond/FilePondPluginImagePreview.min.js')}}"></script>
<script src="{{asset('src/plugins/src/filepond/FilePondPluginImageCrop.min.js')}}"></script>
<script src="{{asset('src/plugins/src/filepond/FilePondPluginImageResize.min.js')}}"></script>
<script src="{{asset('src/plugins/src/filepond/FilePondPluginImageTransform.min.js')}}"></script>
<script src="{{asset('src/plugins/src/filepond/filepondPluginFileValidateSize.min.js')}}"></script>
<script>
    FilePond.registerPlugin(
        FilePondPluginFileValidateType,
        FilePondPluginImageExifOrientation,
        FilePondPluginImagePreview,
        FilePondPluginImageCrop,
        FilePondPluginImageResize,
        FilePondPluginImageTransform,
        //   FilePondPluginImageEdit
    );

    FilePond.create(document.querySelector('.filepond'), {
        imagePreviewHeight: 170,
        imageCropAspectRatio: '1:1',
        imageResizeTargetWidth: 200,
        imageResizeTargetHeight: 200,
        stylePanelLayout: 'compact circle',
        styleLoadIndicatorPosition: 'center bottom',
        styleProgressIndicatorPosition: 'right bottom',
        styleButtonRemoveItemPosition: 'left bottom',
        styleButtonProcessItemPosition: 'right bottom',
        storeAsFile: true,
        @if($item -> avatar)
        files: [{
            // the server file reference
            source: '{{asset($item->avatar_url)}}',

            // set type to limbo to tell FilePond this is a temp file
            // options: {
            //     type: 'image/png',
            // },
        }, ],
        @endif
    });


    $(document).ready(function () {
        var form = $('#form-profile');
        var btn = $('.btn-submit');

        form.on('submit', function (e) {
            e.preventDefault();
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var formData = new FormData(form[0]);
            formData.append('_token', csrfToken)
            $.ajax({
                type: 'POST',
                enctype: 'multipart/form-data',
                url: "{{route('profile.change-profile')}}",
                processData: false,
                contentType: false,
                data: formData,
                beforeSend: function () {
                    if ($(`.form-control`).hasClass('is-invalid')) {
                        $(`.form-control`).removeClass('is-invalid')
                    }
                    btn.html(
                        '<div class="spinner-border text-white me-2 align-self-center loader-sm "></div> Loading'
                    ).attr('disabled', true)
                },
                success: function (res) {
                    main.notification(res.message, NOTIFICATION_COLOR.SUCCESS)
                    btn.html('Simpan Perubahan').attr('disabled', false)
                    window.location.href = "{{route('profile.index')}}";
                },
                error: function (res) {
                    var response = res.responseJSON;
                    btn.html('Simpan Perubahan').attr('disabled', false)
                    main.notification(response.message, NOTIFICATION_COLOR.DANGER)
                    console.log(res.responseJSON.errors)
                    if (typeof res.responseJSON.errors === 'object') {
                        Object.keys(response.errors).map((i) => {
                            var message = response.errors[i];
                            $(`input[name="${i}"]`).addClass('is-invalid')
                            $(`textarea[name="${i}"]`).addClass('is-invalid')
                            $(`#feedback-${i}`).addClass('invalid-feedback').html(
                                message)
                        })
                    }
                },
            });
        })

    })

</script>
@endpush
