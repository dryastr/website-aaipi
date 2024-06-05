<x-base-layout :title="$title">
    <x-slot name="headerFiles">
        <style>
            .table > tbody > tr > td {
                white-space: normal !important;
            }
        </style>
    </x-slot>
    <div class="row layout-top-spacing">
        <div class="col-md-12 layout-spacing">
            <div class="widget widget-table-one">
                <div class="widget-heading">
                    <h5 class="">{{$title}}</h5>

                    <div class="task-action">
                        @can('setting.syarat-pendaftaran.create')
                        <a href="{{route('setting.syarat-pendaftaran.create')}}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah</a>
                        @endcan
                    </div>
                </div>
                <div class="widget-content">
                    <div class="table-responsive">
                        <table id="table-data" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col" width="5%">No</th>
                                    <th scope="col" width="45%">Title</th>
                                    <th scope="col" width="40%">Lable</th>
                                    <th scope="col" width="5%">Type</th>
                                    <th scope="col" width="5%">Aksi</th>
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
            $(document).ready(function(){
                var tableData = $('#table-data > tbody');
                $.ajax({
                    url: '{{route('setting.syarat-pendaftaran.view')}}',
                    beforeSend: function(){
                        tableData.html('<tr><td colspan="5" class="text-center">Loading...</td></tr>')
                    },
                    success: function(res){
                        var data = res.data;
                        var html = '';

                        if(data.length < 1){
                            html += '<tr><td colspan="5" class="text-center">Tidak ada data</td></tr>'
                        }else{
                            data.map((row, index) => {
                                var idDropdown = "tableDropdown-" + row.id
                                var linkAddChild = "{{route('setting.syarat-pendaftaran.create', ':id')}}".replace(':id', row.id);
                                var linkEdit = "{{route('setting.syarat-pendaftaran.edit', ':id')}}".replace(':id', row.id);
                                var linkDelete = "{{route('setting.syarat-pendaftaran.delete', ':id')}}".replace(':id', row.id);
                                var childrens = row.childrens;
                                html += `
                                <tr>
                                    <td class="text-center align-top" rowspan="${childrens.length + 1}">${index + 1}</td>
                                    <td>${row.title}</td>
                                    <td>${row.label || '-'}</td>
                                    <td>${row.type}</td>
                                    <td>
                                        <div class="d-inline-flex">
                                            <button type="button" class="btn btn-light btn-sm dropdown-toggle dropdown-toggle-split" id="`+idDropdown+`" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-reference="parent">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="`+idDropdown+`">
                                                @can('setting.syarat-pendaftaran.create')<a class="dropdown-item" href="${linkAddChild}">Tambah Persyaratan</a>@endcan
                                                @can('setting.syarat-pendaftaran.edit')<a class="dropdown-item" href="${linkEdit}">Edit</a>@endcan
                                                @can('setting.syarat-pendaftaran.delete')<button class="dropdown-item" onClick="main.confirmDelete('${linkDelete}')">Hapus</button>@endcan
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                `;
                                childrens.map((r, i) => {
                                    var idDropdownC = "tableDropdown-" + r.id
                                    var linkEditC = "{{route('setting.syarat-pendaftaran.edit', ':id')}}".replace(':id', r.id);
                                    var linkDeleteC = "{{route('setting.syarat-pendaftaran.delete', ':id')}}".replace(':id', r.id);
                                    html += `
                                    <tr>
                                        <td>
                                            <ul>
                                                <li>${r.title}</li>
                                            </ul>
                                        </td>
                                        <td>${r.label || '-'}</td>
                                        <td>${r.type}</td>
                                        <td>
                                            <div class="d-inline-flex">
                                                <button type="button" class="btn btn-light btn-sm dropdown-toggle dropdown-toggle-split" id="`+idDropdownC+`" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-reference="parent">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="`+idDropdownC+`">
                                                    @can('setting.syarat-pendaftaran.edit')<a class="dropdown-item" href="${linkEditC}">Edit</a>@endcan
                                                    @can('setting.syarat-pendaftaran.delete')<button class="dropdown-item" onClick="main.confirmDelete('${linkDeleteC}')">Hapus</button>@endcan
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                `;
                                })
                            })

                        }

                        tableData.html(html)
                    }
                })
            })
        </script>
    </x-slot>
</x-base-layout>
