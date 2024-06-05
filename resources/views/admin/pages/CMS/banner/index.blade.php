<x-base-layout :title="$title">
    <x-slot name="headerFiles">
        <link rel="stylesheet" href="{{asset('src/plugins/src/filepond/filepond.min.css')}}">
        <link rel="stylesheet" href="{{asset('src/plugins/src/filepond/FilePondPluginImagePreview.min.css')}}">
        <link href="{{asset('src/plugins/css/light/filepond/custom-filepond.css')}}" rel="stylesheet" type="text/css" />

        <link rel="stylesheet" href="{{asset('src/assets/css/light/apps/blog-create.css')}}">
        <script src="{{asset('assets/ckeditor/ckeditor.js')}}"></script>
    </x-slot>

    <div class="mb-4 layout-spacing layout-top-spacing">
        <div class="widget">
            <div class="contact-area py-120">
                <div class="container">
                    <ul class="nav nav-pills justify-content-center mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-1-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-1" type="button" role="tab" aria-controls="pills-1"
                                aria-selected="true">Beranda</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-1-tab" data-bs-toggle="pill" data-bs-target="#pills-2"
                                type="button" role="tab" aria-controls="pills-1" aria-selected="true">Tentang
                                Kami</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-3-tab" data-bs-toggle="pill" data-bs-target="#pills-3"
                                type="button" role="tab" aria-controls="pills-3"
                                aria-selected="false">Publikasi</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-4-tab" data-bs-toggle="pill" data-bs-target="#pills-4"
                                type="button" role="tab" aria-controls="pills-4"
                                aria-selected="false">Keanggotaan</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-5-tab" data-bs-toggle="pill" data-bs-target="#pills-5"
                                type="button" role="tab" aria-controls="pills-5" aria-selected="false">Aplikasi</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-6-tab" data-bs-toggle="pill" data-bs-target="#pills-6"
                                type="button" role="tab" aria-controls="pills-6" aria-selected="false">Kontak</button>
                        </li>
                    </ul>

                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-1" role="tabpanel"
                            aria-labelledby="pills-1-tab">
                            <div class="row layout-top-spacing">
                                <div class="widget-heading">
                                    <div class="task-action d-flex justify-content-end">
                                        @can('CMS.banner.create')
                                        <a href="{{route('CMS.banner.create')}}" class="btn btn-primary"><i
                                                class="fas fa-plus"></i>
                                            Tambah</a>
                                        @endcan
                                    </div>
                                </div>
                                <div class="widget-content">
                                    <div class="table-responsive">
                                        <table id="table-data" class="table table-bordered table-striped dt-table-hover"
                                            style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Judul</th>
                                                    <th>URL</th>
                                                    <th>Gambar</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <form id="form-data-1" method="POST" class="row">
                                @include('admin.pages.CMS.banner.home')
                                <div class="col-xxl-2 col-sm-2 col-2">
                                    <button class="btn btn-primary btn-kirim w-100">Simpan</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="pills-2" role="tabpanel" aria-labelledby="pills-2-tab">
                            <form id="form-data-2" method="POST" class="row">
                                @include('admin.pages.CMS.banner.about')
                                <div class="col-xxl-2 col-sm-2 col-2">
                                    <button class="btn btn-primary btn-kirim w-100">Simpan</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="pills-3" role="tabpanel" aria-labelledby="pills-3-tab">
                            <form id="form-data-3" method="POST" class="row">
                                @include('admin.pages.CMS.banner.publikasi')
                                <div class="col-xxl-2 col-sm-2 col-2">
                                    <button class="btn btn-primary btn-kirim w-100">Simpan</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="pills-4" role="tabpanel" aria-labelledby="pills-4-tab">
                            <form id="form-data-4" method="POST" class="row">
                                @include('admin.pages.CMS.banner.keanggotaan')
                                <div class="col-xxl-2 col-sm-2 col-2">
                                    <button class="btn btn-primary btn-kirim w-100">Simpan</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="pills-5" role="tabpanel" aria-labelledby="pills-5-tab">
                            <form id="form-data-5" method="POST" class="row">
                                @include('admin.pages.CMS.banner.aplikasi')
                                <div class="col-xxl-2 col-sm-2 col-2">
                                    <button class="btn btn-primary btn-kirim w-100">Simpan</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="pills-6" role="tabpanel" aria-labelledby="pills-6-tab">
                            <form id="form-data-6" method="POST" class="row">
                                @include('admin.pages.CMS.banner.kontak')
                                <div class="col-xxl-2 col-sm-2 col-2">
                                    <button class="btn btn-primary btn-kirim w-100">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @php
    $berandaKontak = $banners->where('kode', strtoupper('beranda_kontak'));
    $berandaKursus = $banners->where('kode', strtoupper('beranda_kursus'));
    $sejarahSingkat = $banners->where('kode', strtoupper('sejarah_singkat'));
    $visiDanMisi = $banners->where('kode', strtoupper('visi_dan_misi'));
    $strukturOrganisasi = $banners->where('kode', strtoupper('struktur_organisasi'));
    $programKerja = $banners->where('kode', strtoupper('program_kerja'));
    $anggaranDasar = $banners->where('kode', strtoupper('anggaran_dasar'));
    $publikasi = $banners->where('kode', strtoupper('publikasi'));
    $keanggotaan = $banners->where('kode', strtoupper('keanggotaan'));
    $elmsAaipi = $banners->where('kode', strtoupper('elms_aaipi'));
    $telaahSejawat = $banners->where('kode', strtoupper('telaah_sejawat'));
    $kontak = $banners->where('kode', strtoupper('kontak'));
    @endphp


    <x-slot name="footerFiles">
        <script src="{{asset('src/plugins/src/filepond/filepond.min.js')}}"></script>
        <script src="{{asset('src/plugins/src/filepond/FilePondPluginFileValidateType.min.js')}}"></script>
        <script src="{{asset('src/plugins/src/filepond/FilePondPluginImageExifOrientation.min.js')}}"></script>
        <script src="{{asset('src/plugins/src/filepond/FilePondPluginImagePreview.min.js')}}"></script>
        <script src="{{asset('src/plugins/src/filepond/FilePondPluginImageCrop.min.js')}}"></script>
        <script src="{{asset('src/plugins/src/filepond/FilePondPluginImageResize.min.js')}}"></script>
        <script src="{{asset('src/plugins/src/filepond/FilePondPluginImageTransform.min.js')}}"></script>
        <script src="{{asset('src/plugins/src/filepond/filepondPluginFileValidateSize.min.js')}}"></script>

        <script>
            $(document).ready(function () {
                FilePond.registerPlugin(
                    FilePondPluginImagePreview,
                    FilePondPluginImageExifOrientation,
                    FilePondPluginFileValidateSize,
                    FilePondPluginFileValidateType
                );

                var filePondBerandaKontak = FilePond.create(document.getElementById('beranda_kontak'), {
                    storeAsFile: true,
                    files: [
                        @foreach($berandaKontak as $banner) {
                            source: '{{$banner->image_url}}',
                        },
                        @endforeach
                    ],
                });

                var filePondBerandaKursus = FilePond.create(document.getElementById('beranda_kursus'), {
                    storeAsFile: true,
                    files: [
                        @foreach($berandaKursus as $banner) {
                            source: '{{$banner->image_url}}',
                        },
                        @endforeach
                    ],
                });

                var filePondSejarahSingkat = FilePond.create(document.getElementById('sejarah_singkat'), {
                    storeAsFile: true,
                    files: [
                        @foreach($sejarahSingkat as $banner) {
                            source: '{{$banner->image_url}}',
                        },
                        @endforeach
                    ],
                });

                var filePondVisiDanMisi = FilePond.create(document.getElementById('visi_dan_misi'), {
                    storeAsFile: true,
                    files: [
                        @foreach($visiDanMisi as $banner) {
                            source: '{{$banner->image_url}}',
                        },
                        @endforeach
                    ],
                });

                var filePondStrukturOrganisasi = FilePond.create(document.getElementById(
                    'struktur_organisasi'), {
                    storeAsFile: true,
                    files: [
                        @foreach($strukturOrganisasi as $banner) {
                            source: '{{$banner->image_url}}',
                        },
                        @endforeach
                    ],
                });

                var filePondProgramKerja = FilePond.create(document.getElementById('program_kerja'), {
                    storeAsFile: true,
                    files: [
                        @foreach($programKerja as $banner) {
                            source: '{{$banner->image_url}}',
                        },
                        @endforeach
                    ],
                });

                var filePondAnggaranDasar = FilePond.create(document.getElementById('anggaran_dasar'), {
                    storeAsFile: true,
                    files: [
                        @foreach($anggaranDasar as $banner) {
                            source: '{{$banner->image_url}}',
                        },
                        @endforeach
                    ],
                });

                var filePondPublikasi = FilePond.create(document.getElementById('publikasi'), {
                    storeAsFile: true,
                    files: [
                        @foreach($publikasi as $banner) {
                            source: '{{$banner->image_url}}',
                        },
                        @endforeach
                    ],
                });

                var filePondKeanggotaan = FilePond.create(document.getElementById('keanggotaan'), {
                    storeAsFile: true,
                    files: [
                        @foreach($keanggotaan as $banner) {
                            source: '{{$banner->image_url}}',
                        },
                        @endforeach
                    ],
                });

                var filePondElmsAaipi = FilePond.create(document.getElementById('elms_aaipi'), {
                    storeAsFile: true,
                    files: [
                        @foreach($elmsAaipi as $banner) {
                            source: '{{$banner->image_url}}',
                        },
                        @endforeach
                    ],
                });

                var filePondTelaahSejawat = FilePond.create(document.getElementById('telaah_sejawat'), {
                    storeAsFile: true,
                    files: [
                        @foreach($telaahSejawat as $banner) {
                            source: '{{$banner->image_url}}',
                        },
                        @endforeach
                    ],
                });

                var filePondKontak = FilePond.create(document.getElementById('kontak'), {
                    storeAsFile: true,
                    files: [
                        @foreach($kontak as $banner) {
                            source: '{{$banner->image_url}}',
                        },
                        @endforeach
                    ],
                });
            });


            var form = $('#form-data');
            var btnSubmit = $('.btn-kirim');
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            // btnSubmit.on('click', function (e) {
            //     e.preventDefault();
            //     form.submit();
            // });

            btnSubmit.on('click', function (e) {
                e.preventDefault();
                var activeForm = $('.tab-pane.fade.show.active form');
                activeForm.submit();
            });

            $('.tab-content form').on('submit', function (e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                formData.append('_token', csrfToken);

                var fileInputs = form.find('input[type="file"]');
                fileInputs.each(function () {
                    var fieldName = $(this).attr('name');
                    var file = $(this).prop('files')[0];
                    if (file) {
                        formData.append(fieldName, file);
                    }
                });

                $.ajax({
                    type: 'POST',
                    enctype: 'multipart/form-data',
                    url: "{{ route('CMS.banner.actions') }}",
                    processData: false,
                    contentType: false,
                    data: formData,
                    beforeSend: function () {
                        btnSubmit.html(
                            '<div class="spinner-border text-white me-2 align-self-center loader-sm "></div> Loading'
                        ).attr('disabled', true);
                        $('.invalid-feedback').removeClass('invalid-feedback d-block')
                            .html('');
                    },
                    success: function (res) {
                        main.notification(res.message, NOTIFICATION_COLOR.SUCCESS);
                        var activeTab = $('#pills-tab .nav-link.active').attr('id');
                        var targetTabId = activeTab.replace('-tab', '');
                        var targetTab = $('#pills-' + targetTabId);

                        targetTab.addClass('show active').siblings().removeClass(
                            'show active');
                        window.location.href = "{{ route('CMS.banner.index') }}";
                        btnSubmit.html('Simpan').attr('disabled', false);
                    },
                    error: function (res) {
                        var response = res.responseJSON;
                        btnSubmit.html('Simpan').attr('disabled', false);
                        main.notification(response.message, NOTIFICATION_COLOR.DANGER);
                        if (typeof res.responseJSON.errors === 'object') {
                            Object.keys(response.errors).map((i) => {
                                var message = response.errors[i];
                                $(`#feedback-${i}`).addClass(
                                    'invalid-feedback d-block').html(
                                    message);
                            });
                        }
                    },
                    done: function () {}
                });
            });

            $('#table-data').DataTable({
                processing: true,
                serverSide: true,
                info: true,
                fnServerData: function (sSource, aoData, fnCallback, oSettings) {
                    var page = this.api().page.info().page;
                    let data = aoData.reduce((r, i) => {
                        r[i.name] = i.value
                        return r
                    }, {})
                    data['page'] = page + 1;

                    // Menambahkan kriteria pencarian untuk kode 'beranda_slider'
                    data['kode'] = 'beranda_slider';

                    oSettings.jqXHR = $.ajax({
                        url: "{{route('CMS.banner.view')}}",
                        data: data,
                        success: fnCallback,
                    });
                },
                order: [],
                columns: [{
                        data: null,
                        render: function (data, type, row, meta) {
                            return meta.row + 1
                        },
                        visible: true,
                        orderable: false,
                        searchable: false,
                        width: '30px'
                    },
                    {
                        data: 'title'
                    },
                    {
                        data: 'link',
                        render: function (data, type, row, meta) {
                            return data ? data : '-';
                        },
                    },
                    {
                        data: null,
                        render: function (data, type, row, meta) {
                            return data.image_url ?
                                `<img src="${data.image_url}" width="50"/>` : '-'
                        },
                    },
                    {
                        data: null,
                        render: function (data, type, row, meta) {
                            var idDropdown = "tableDropdown-" + data.id
                            var linkEdit = "{{route('CMS.banner.edit', ':id')}}".replace(
                                ':id',
                                data.id);
                            var linkDelete = "{{route('CMS.banner.delete', ':id')}}"
                                .replace(
                                    ':id', data.id);
                            var html = `
                                        <div class="d-inline-flex">
                                            <button type="button" class="btn btn-light btn-sm dropdown-toggle dropdown-toggle-split" id="+idDropdown+" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-reference="parent">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="+idDropdown+">
                                                @can('CMS.banner.edit')<a class="dropdown-item" href="${linkEdit}">Edit</a>@endcan
                                                @can('CMS.banner.delete')<button class="dropdown-item" onClick="main.confirmDelete('${linkDelete}', '#table-data')">Hapus</button>@endcan
                                            </div>
                                        </div>
                                        `;
                            return html
                        },
                        visible: true,
                        orderable: false,
                        searchable: false,
                        width: '60px'
                    }
                ],
                dom: "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
                    "<'table-responsive'tr>" +
                    "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
                oLanguage: {
                    "oPaginate": {
                        "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                        "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                    },
                    "sInfo": "Showing page PAGE of PAGES",
                    "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                    "sSearchPlaceholder": "Search...",
                },
                stripeClasses: [],
                lengthMenu: [5, 10, 20, 50],
                pageLength: 5
            })

        </script>
    </x-slot>



</x-base-layout>
