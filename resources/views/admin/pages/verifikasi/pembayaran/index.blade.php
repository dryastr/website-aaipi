<x-base-layout :title="$title">
    <div class="row layout-top-spacing">
        <div class="col-md-12 layout-spacing">
            <div class="widget widget-table-one">
                <div class="widget-heading">
                    <h5 class="">{{$title}}</h5>
                    <div class="task-action">

                    </div>
                </div>
                <div class="widget-content">
                    <ul class="nav nav-pills" id="animateLine" role="tablist">
                        @foreach($status as $item)
                        <li class="nav-item" role="presentation">
                            <a href="{{route('verifikasi.pembayaran.index') . '?type=' . $item['value']}}" @class(['nav-link', 'active' => $item['value'] == $type])>
                                {!!$item['icon']!!} {{$item['title']}}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                    <div class="table-responsive">
                        <table id="table-data" class="table table-bordered table-striped dt-table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    @if($type == 'terverifikasi')
                                        <th>Nomor Anggota</th>
                                    @endif
                                    <th>Nama</th>
                                    <th>Jenis Anggota</th>
                                    <th>Tanggal Bayar</th>
                                    @if($type == 'verifikasi-pembayaran') <th>Tindakan</th> @endif
                                    @if($type == 'terverifikasi')
                                        <th>Tanggal Verifikasi</th>
                                    @endif
                                    @if($type == 'ditolak')
                                        <th>Tanggal Ditolak</th>
                                        <th>Alasan Ditolak</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <x-slot name="footerFiles">
        <script>
            $(document).ready(function(){
                $('#table-data').DataTable({
                    processing: true,
                    serverSide: true,
                    info:true,
                    fnServerData: function ( sSource, aoData, fnCallback, oSettings ) {
                        var page = this.api().page.info().page;
                        let data = aoData.reduce((r, i) => {
                            r[i.name] = i.value
                            return r
                        }, {})
                        data['page'] = page + 1
                        oSettings.jqXHR = $.ajax({
                            url: "{{route('verifikasi.pembayaran.view', $type)}}",
                            data: data,
                            success: fnCallback,
                        });
                    },
                    order: [],
                    columns: [
                        {
                            data: null,
                            render: function(data, type, row, meta){
                                return meta.row + 1
                            },
                            visible: true,
                            orderable: false,
                            searchable: false,
                            width: '30px'
                        },
                        @if($type == 'terverifikasi')
                        {
                            data: 'user.nomor_anggota',
                            orderable: false,
                            searchable: false,
                        },
                        @endif
                        {
                            data: 'user.fullname',
                            orderable: false,
                            searchable: false,
                        },
                        {
                            data: 'user.role.name',
                            orderable: false,
                            searchable: false,
                        },
                        {
                            data: 'tanggal_bayar',
                            orderable: false,
                            searchable: false,
                        },
                        @if($type == 'verifikasi-pembayaran')
                        {
                            data: null,
                            render: function(data, type, row, meta){
                                var link = "{{route('verifikasi.pembayaran.show', ':id')}}".replace(':id', data.pid);
                                var html = `<a href="${link}" class="btn btn-success">Detail</a>`;
                                return html
                            },
                            visible: true,
                            orderable: false,
                            searchable: false,
                            width: '60px'
                        }
                        @endif
                        @if($type == 'terverifikasi')
                        {
                            data: 'tanggal_bayar',
                            orderable: false,
                            searchable: false,
                        },
                        @endif
                        @if($type == 'ditolak')
                        {
                            data: 'rejected_at',
                            orderable: false,
                            searchable: false,
                        },
                        {
                            data: 'catatan',
                            orderable: false,
                            searchable: false,
                        },
                        @endif
                    ],
                    dom: "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
                        "<'table-responsive'tr>" +
                        "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
                    oLanguage: {
                        "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
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
