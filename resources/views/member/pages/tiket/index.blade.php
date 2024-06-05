@extends('member.layouts.master')

@section('title', 'Daftar Tiket')
@section('tiket-tab', 'active')

@section('content')
    <div class="row layout-top-spacing">
        <div class="col-md-12 layout-spacing">
            <div class="row">
                <div class="col-md-6">
                    <div class="section-title bottom_30"><span></span>
                        <h2>{{ $title }}</h2>
                    </div>
                </div>
                <div class="col-md-6" style="text-align: right">
                    <!-- Tambahkan tombol tambah dengan gaya merah -->
                    <a href="{{ route('tiket.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</a>
                </div>
            </div>

            <div class="table-responsive">
                <table id="table-data" class="table table-bordered table-striped dt-table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th width="40%">Judul</th>
                            <th>Prioritas</th>
                            <th>Attachment</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#table-data').DataTable({
                "searching": true,
                "responsive": true,
                "processing": true,
                "searching": true,
                "paging": true,
                "language": {
                    processing: '<span style="font-size:22px"><i class="fa fa-spinner fa-spin fa-fw"></i> Loading..</span>',
                    search: '',
                    searchPlaceholder: "Cari Pembayaran"
                },
                "serverSide": true,
                "ajax": "/member/tiket/datatables",
                "info": true,
                "order": [],
                "dom": "frtip",
                "pageLength": 10,
                "aLengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                "columns": [{
                        data: "no",
                        name: "no",
                        width: "5%"
                    },
                    {
                        data: "judul",
                        name: "judul",
                        width: "10%"
                    },
                    {
                        data: "prioritas",
                        name: "prioritas",
                        width: "5%"
                    },
                    {
                        data: "attachment",
                        name: "attachment",
                        width: "5%",
                        render: function(data, type, row) {
                            return '<img src="' + data +
                                '" alt="Attachment" class="img-thumbnail" style="max-width: 100px; max-height: 100px;">';
                        }
                    },
                    {
                        data: "aksi",
                        name: "aksi",
                        width: "20%",
                    }
                ],
                "columnDefs": [{
                        "width": "",
                        "targets": 0,
                        "className": "dt-center"
                    },
                    {
                        "width": "",
                        "targets": 1,
                        "className": "dt-center"
                    },
                    {
                        "width": "",
                        "targets": 2,
                        "className": "dt-center"
                    },
                    {
                        "width": "",
                        "targets": 3,
                        "className": "dt-center"
                    },
                    {
                        "width": "",
                        "targets": 4,
                        "className": "dt-center"
                    },
                ]
            });

            $('#table-data').on('click', '.btn-delete', function() {
                var paymentId = $(this).data('payment-id');


                // delete
                Swal.fire({
                    title: "Anda yakin?",
                    text: "Data yang sudah terhapus tidak bisa dikembalikan!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    cancelButtonText: "Kembali",
                    confirmButtonText: "Hapus!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteTiket(paymentId);
                    }
                });
            });

            function deleteTiket(id) {
                axios.delete('/member/tiket/' + id)
                    .then(function(response) {
                        Swal.fire({
                            title: "Terhapus!",
                            text: "Data tagihan berhasil terhapus!",
                            icon: "success"
                        });
                        $('#table-data').DataTable().ajax.reload(null, false);
                    })
                    .catch(function(response) {
                        console.log("terjadi kesalahan saat menghapus data ", error);
                    });
            }

        });
    </script>
@endpush
