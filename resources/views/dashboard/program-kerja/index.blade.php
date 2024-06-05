<x-base-layout :title="$title">
    <div class="row layout-top-spacing">
        <div class="col-md-12 layout-spacing">
            <div class="widget widget-table-one">
                <div class="widget-heading">
                    <h5 class="">{{$title}}</h5>

                    <div class="task-action">
                        @can('program-kerja.create')
                        <a href="{{route('program-kerja.create')}}" class="btn btn-primary"><i class="fas fa-plus"></i>
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
                                    <th>NO</th>
                                     <th>Deskripsi</th>
                                     <th>Judul Program</th>
                                    <th>Deskripsi Program</th>
                                    <th>Gambar Program</th>
                                    <th>Status Gambar</th>
                                    <th>Banner Program</th>
                                    <th>Status Banner</th>
                                    <th>Icon Program</th>
                                    <th>Options</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <x-slot name="footerFiles">
        <script>
            $(document).ready(function () {
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
                        data['page'] = page + 1
                        oSettings.jqXHR = $.ajax({
                            url: "{{route('program-kerja.view')}}",
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
                        // {data: 'title_content', width: '100px'},
                        // {
                        //     data: 'title'
                        // },
                        // {data: 'description', width: '100px'},
                        {data: 'title_content'},
                        {data: 'title'},
                        {data: 'description'},
                        // {data: 'image'},
                        {
                            data: null,
                            render: function (data, type, row, meta) {
                                return data.image_url ?
                                    `<img src="${data.image_url}" width="50"/>` : '-'
                            },
                        },
                        {
                            data: 'status_image',
                            render: function (data, type, row, meta) {
                                return data ? '<i class="fas fa-check text-success"></i>' :
                                    '<i class="fas fa-times text-danger"></i>';
                            }
                        },
                        {
                            data: null,
                            render: function (data, type, row, meta) {
                                return data.banner_url ?
                                    `<img src="${data.banner_url}" width="50"/>` : '-'
                            },
                            orderable: false,
                            width: '60px'
                        },
                        {
                            data: 'status_banner',
                            render: function (data, type, row, meta) {
                                return data ? '<i class="fas fa-check text-success"></i>' :
                                    '<i class="fas fa-times text-danger"></i>';
                            }
                        },
                        {
                            data: 'icon'
                        },
                        {
                            data: null,
                            render: function (data, type, row, meta) {
                                var idDropdown = "tableDropdown-" + data.id
                                var linkEdit = "{{route('program-kerja.edit', ':id')}}".replace(
                                    ':id', data.id);
                                var linkDelete = "{{route('program-kerja.delete', ':id')}}"
                                    .replace(':id', data.id);
                                var html =
                                    `
                                        <div class="d-inline-flex">
                                            <button type="button" class="btn btn-light btn-sm dropdown-toggle dropdown-toggle-split" id="` +
                                    idDropdown + `" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-reference="parent">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="` + idDropdown + `">
                                                @can('program-kerja.edit')<a class="dropdown-item" href="${linkEdit}">Edit</a>@endcan
                                                @can('program-kerja.delete')<button class="dropdown-item" onClick="main.confirmDelete('${linkDelete}', '#table-data')">Hapus</button>@endcan
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
                        "sInfo": "Showing page _PAGE_ of _PAGES_",
                        "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                        "sSearchPlaceholder": "Search...",
                        sLengthMenu: "Results :  _MENU_",
                    },
                    stripeClasses: [],
                    lengthMenu: [5, 10, 20, 50],
                    pageLength: 5
                })
            });

        </script>
    </x-slot>
</x-base-layout>
