@extends('member.layouts.master')

@section('title', 'Tagihan dan Pembayaran')
@section('tagihan-tab', 'active')

@section('content')
    <div class="row layout-top-spacing">
        <div class="col-md-12 layout-spacing">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title bottom_30"><span></span>
                        <h2>{{ $title }}</h2>
                    </div>
                </div>
            </div>

         
            @if (count($tagihans) > 0)
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <i class="fa fa-exclamation-circle mr-2"></i>
                    <small class="text-muted">Daftar tagihan yang belum dibayar</small>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true"></span>
                    </button>
                  
                    @foreach ($tagihans as $tagihan)
                        <div class="alert alert-danger m-3 align-content-lg-center">

                            {{ ucwords($tagihan->jenis_keanggotaan) }} - {{ $tagihan->tahun }} (Biaya:
                            {{ $tagihan->biaya_rupiah }})

                          
                            <div class="pull-right">
                                <a href="{{ route('tagihan.create', ['tagihan_id' => $tagihan->id]) }}"
                                    class="btn btn-success"><i class="fa fa-money"></i> Bayar</a>
                            </div>
                        </div>
                    @endforeach
                  
                </div>
            @endif


            @if ($message = Session::get('sukses'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <p>{{ $message }}</p>
                </div>
            @endif

            <div class="table-responsive">
                <table id="table-pembayaran" class="table table-bordered table-striped dt-table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th width="30%">Tagihan</th>
                            <th>Nominal</th>
                            <th>Status</th>
                            <th>Alasan</th>
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
            $('#table-pembayaran').DataTable({
                "searching": true, 
                "responsive": true,
                "processing": true,
                "searching": true,
                "paging": true,
                "language": {
                    processing: '<span style="font-size:22px"><i class="fa fa-spinner fa-spin fa-fw"></i> Loading..</span>',
                    search : '',
                    searchPlaceholder: "Cari Pembayaran"
                },
                "serverSide": true,
                "ajax": "/member/tagihan/datatables",
                "info": true,
                "order": [],
                "dom": "frtip",
                "pageLength": 10,
                "aLengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                "columns": [
                {
                    data: "no",
                    name: "no",
                    width: "5%"
                },
                {
                    data: "tagihan",
                    name: "tagihan",
                    width: "10%"
                },
                {
                    data: "nominal",
                    name: "nominal",
                    width: "10%"
                },
                {
                    data: "status",
                    name: "status",
                    width: "10%"
                },
                {
                    data: "alasan",
                    name: "alasan",
                    width: "10%"
                },
                {
                    data: "aksi",
                    name: "aksi",
                    width: "10%",
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
                {
                    "width": "",
                    "targets": 5,
                    "className": "dt-center"
                },
            ]
            });

            $('#table-pembayaran').on('click', '.btn-delete', function() {
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
                            deleteTagihan(paymentId);
                        }
                    });
                });

                function deleteTagihan(id){
                    axios.delete('/member/tagihan/' + id)
                        .then(function(response){
                            Swal.fire({
                                title: "Terhapus!",
                                text: "Data tagihan berhasil terhapus!",
                                icon: "success"
                            });
                            $('#table-pembayaran').DataTable().ajax.reload(null, false);
                        })
                        .catch(function(response){
                            console.log("terjadi kesalahan saat menghapus data " , error);
                        });
                }

            });
    </script>
@endpush
