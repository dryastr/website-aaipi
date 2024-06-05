@extends('member.layouts.master')

@section('title', 'Home')

@section('content')

@section('head-extra')
<link rel="stylesheet" href="{{ asset('src/plugins/src/filepond/filepond.min.css') }}">
<link rel="stylesheet" href="{{ asset('src/plugins/src/filepond/FilePondPluginImagePreview.min.css') }}">
<link href="{{ asset('src/plugins/css/light/filepond/custom-filepond.css') }}" rel="stylesheet" type="text/css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<style>
    .input-group {
        display: block !important;
    }
    

    .select2-container .select2-selection--single {
    box-sizing: border-box;
    cursor: pointer;
    display: block;
    height: 34px;
    user-select: none;
    -webkit-user-select: none;
    
    }

    .select2-container .select2-selection--single .select2-selection__rendered {
    display: block;
    padding-left: 8px;
    padding-right: 20px;
    overflow: hidden;
    text-overflow: inherit;
    white-space: nowrap;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #444;
    line-height: 34px;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 33px;
    position: absolute;
    top: 1px;
    right: 1px;
    width: 20px;
}

.select2-container .select2-selection--single .select2-selection__rendered {
    font-size: 14px; 
    color: #333; 
}


.select2-container--default .select2-selection--single .select2-selection__arrow b {
    border-color: #333 transparent transparent transparent; 
}


.select2-container--default .select2-results__option {
    font-size: 14px; 
    color: #333; 
}


.select2-container--default .select2-selection--single {
    font-size: 14px; 
    color: #333; 
    padding-left: 9px;
}


.select2-container--default .select2-selection--single .select2-selection__placeholder {
    font-size: 14px; 
    color: #999; 
}



</style>
{{-- {{ dd($pangkat['data']) }} --}}
@endsection
    {{-- Konten halaman home --}}
<div class="row">
    <section class="about-me line col-md-12 padding_30 padbot_45">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <div class="section-title bottom_30"><span></span><h2>{{ $title }}</h2></div>
                    </div>
                    <div class="col-md-6" style="text-align: right">
                        <!-- Tambahkan tombol kembali -->
                        {{-- --}}
                    </div>
                </div>
            </div>
            {{-- <div class="card-body">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li style="padding-left: 10px;">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif --}}

                @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                @endif

                <form action="{{ route('member.change-profile.action') }}" method="POST" enctype="multipart/form-data" class="g-3">
                    @csrf
                    <div class="row">
                        <div class="col-md-12" style="margin-bottom: 2rem">
                            <label class="form-label">Foto</label>
                            <div class="multiple-file-upload" style="display: block; position: relative;">
                                <input type="file"
                                    accept="image/png, image/jpeg, image/gif"
                                    class="filepond file-upload"
                                    name="avatar"
                                    id="product-images"
                                    data-allow-reorder="true"
                                    data-max-file-size="3MB"
                                    data-max-files="5">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6" style="margin-bottom: 2rem">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" name="fullname" value="{{ $user['fullname'] }}" maxlength="50" >
                        </div>
                        <div class="col-md-6" style="margin-bottom: 2rem">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" value="{{ $user['email'] }}" maxlength="50" >
                        </div>
                      
                        <div class="col-md-6" style="margin-bottom: 2rem">
                            <label class="form-label">Nomor Handphone</label>
                            <input type="text" class="form-control" name="mobile" value="{{ $user['mobile'] }}" maxlength="13" >
                        </div>
                        <div class="col-md-6" style="margin-bottom: 2rem">
                            <div class="input-group">
                                <label for="inputEmail4" class="form-label">NIP / NRP</label>
                                <div style="display: flex;">
                                        <select name="status_nip_nrp" class="form-control" style="flex-shrink: 1; width: 100px">
                                            <option @if($user['status_nip_nrp'] == 'nip') selected @endif value="nip">NIP</option>
                                            <option @if($user['status_nip_nrp'] == 'nrp') selected @endif value="nrp">NRP</option>
                                        </select>
                                    </select>
                                    <input type="text" name="nip_nrp" class="form-control" placeholder="NIP / NRP" value="{{ $user['nip'] ? $user['nip'] : $user['nrp'] }}" maxlength="18" required>
                                </div>
                                @if($errors->has('nip_nrp'))
                                <span style="color: red; font-size: 12px; margin-top: 2px;">{{ 'NIP /NRP wajib diisi' }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6" style="margin-bottom: 2rem">
                            <label class="form-label">Gelar Depan  (opsional)</label>
                            <input type="text" class="form-control" name="gelar_depan" value="{{ $user['gelar_depan'] }}">
                        </div>
                        <div class="col-md-6" style="margin-bottom: 2rem">
                            <label class="form-label">Gelar Belakang</label>
                            <input type="text" class="form-control" name="gelar_belakang" value="{{ $user['gelar_belakang'] }}">
                            @if($errors->has('gelar_belakang'))
                            <span style="color: red; font-size: 12px; margin-top: 2px;">{{ 'Gelar Belakang wajib diisi' }}</span>
                            @endif
                        </div>
                        <div class="col-md-6" style="margin-bottom: 2rem">
                            <label class="form-label">Provinsi</label>
                            <select name="ref_provinsi_id" id="provinsi" class="form-control">
                                <option value="">-- Pilih Provinsi --</option>
                                @foreach ($provinsi as $item)
                                <option @selected($user['ref_provinsi_id'] == $item['id']) value="{{ $item['id'] }}">{{ $item['nama'] }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('ref_provindi_id'))
                            <span style="color: red;">{{ $errors->first('ref_provindi_id') }}</span>
                            @endif
                        </div>
                        
                        <div class="col-md-6" style="margin-bottom: 2rem">
                            <label class="form-label">Kota / Kabupaten</label>
                            <select name="ref_kota_kab_id" id="kota_kab" class="form-control" disabled>
                                <option value="">-- Pilih Kota / Kabupaten --</option>
                                @foreach ($kotaKab as $item)
                                <option @selected($user['ref_kota_kab_id'] == $item['id']) value="{{ $item['id'] }}">{{ $item['nama'] }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('ref_kota_kab_id'))
                            <span style="color: red;">{{ $errors->first('ref_kota_kab_id') }}</span>
                            @endif
                        </div>
                        
                        <div class="col-md-6" style="margin-bottom: 2rem">
                            <label class="form-label">Instansi</label>
                            <select name="nama_instansi" class="form-control">
                                <option value="">-- Pilih Instansi --</option>
                                @if (is_array($instansi) && isset($instansi['data']) && is_array($instansi['data']))
                                    @foreach ($instansi['data'] as $item)
                                        <option @selected($user['nama_instansi'] == $item['nama_instansi'] ) value="{{ $item['nama_instansi'] }}" data-kode="{{ $item['kode_instansi'] }}">{{ $item['nama_instansi'] }}</option>
                                    @endforeach
                                @endif                            
                            </select>
                            <input type="hidden" name="kode_instansi" id="kode_instansi" value="{{ $user['kode_instansi'] }}">
                            @if($errors->has('nama_instansi'))
                            <span style="color: red;">{{ $errors->first('nama_instansi') }}</span>
                            @endif
                        </div>


                        <div class="col-md-6" style="margin-bottom: 2rem">
                            <label for="nama_unit" id="label_nama_unit">Nama Unit</label>
                            <select name="nama_unit" class="form-control">
                                <option value="">-- Pilih unit --</option>
                                @if (is_array($unitkerja) && isset($unitkerja['data']) && is_array($unitkerja['data']))
                                    @foreach ($unitkerja['data'] as $item)
                                    <option @selected($user['nama_unit'] == $item['nama_unit'] ) value="{{ $item['nama_unit'] }}" data-kode="{{ $item['kode_unit_kerja'] }}">{{ $item['nama_unit'] }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <input type="hidden" name="kode_unit_kerja" id="kode_unit_kerja" value="{{ $user['kode_unit_kerja'] }}">
                            @if($errors->has('nama_unit'))
                            <span style="color: red;">{{ $errors->first('nama_unit') }}</span>
                            @endif
                        </div>

                        <div class="col-md-6" style="margin-bottom: 2rem">
                            <label class="form-label">Pangkat</label>
                            <select name="nama_pangkat" class="form-control">
                                <option value="">-- Pilih pangkat --</option>
                                @if (!empty($pangkat['data']))
                                    @foreach ($pangkat['data'] as $item)
                                        <option @selected($user['nama_pangkat'] == $item['nama_pangkat'] ) value="{{ $item['nama_pangkat'] }}">{{ $item['nama_pangkat'] }}</option>
                                    @endforeach
                                @else
                                    <option value="">Data pangkat tidak tersedia</option>
                                @endif
                            </select>
                            @if($errors->has('nama_pangkat'))
                                <span style="color: red;">{{ $errors->first('nama_pangkat') }}</span>
                            @endif
                        </div>

                        <div class="col-md-6" style="margin-bottom: 2rem">
                            <label class="form-label">Kelompok Jabatan</label>
                            <select name="kelompok_jabatan" class="form-control">
                                <option value="">-- Pilih jabatan --</option>
                                @if (is_array($jabatan) && isset($jabatan['data']) && is_array($jabatan['data']))
                                    @foreach ($jabatan['data'] as $item)
                                    <option @selected($user['kelompok_jabatan'] == $item['kelompok_jabatan'] ) value="{{ $item['kelompok_jabatan'] }}" data-kode="{{ $item['kode_jabatan'] }}">{{ $item['deskripsi_kelompok_jabatan'] }} ({{$item['kelompok_jabatan']}})</option>
                                    @endforeach
                                @endif
                            </select>
                            <input type="hidden" name="kode_jabatan" id="kode_jabatan" value="{{ $user['kode_jabatan'] }}">
                            @if($errors->has('kelompok_jabatan'))
                            <span style="color: red;">{{ $errors->first('kelompok_jabatan') }}</span>
                            @endif
                        </div>
                        
                        <div class="col-md-6" style="margin-bottom: 2rem">
                            <label class="form-label">Nama Jenjang Jabatan</label>
                            <select name="nama_jenjang_jabatan" class="form-control">
                                <option value="">-- Pilih jabatan --</option>
                                @if (is_array($jenjang) && isset($jenjang['data']) && is_array($jenjang['data']))
                                    @foreach ($jenjang['data'] as $item)
                                    <option @selected($user['nama_jenjang_jabatan'] == $item['nama_jenjang_jabatan'] ) value="{{ $item['nama_jenjang_jabatan'] }}" data-kode="{{ $item['kode_jenjang_jabatan'] }}">{{ $item['nama_jenjang_jabatan'] }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <input type="hidden" name="kode_jenjang_jabatan" id="kode_jenjang_jabatan" value="{{ $user['kode_jenjang_jabatan'] }}">
                            @if($errors->has('nama_jenjang_jabatan'))
                            <span style="color: red;">{{ $errors->first('nama_jenjang_jabatan') }}</span>
                            @endif
                        </div>
                            
                    </div>
                    <div class="" style="margin-bottom: 2rem">
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
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


   $('select[name="ref_provinsi_id"]').on('change', function() {
        var selectedProvinsi = $(this).val();
        var kotaKabSelect = $('select[name="ref_kota_kab_id"]');
        
       
        if (!selectedProvinsi || selectedProvinsi === '') {
            kotaKabSelect.prop('disabled', true);
            kotaKabSelect.val('').trigger('change'); 
        } else {
            kotaKabSelect.prop('disabled', false);
        }

        
    });

    
    $('select[name="nama_instansi"]').select2({
        placeholder: "-- Pilih Instansi --",
        allowClear: true 
    });

    $('select[name="nama_pangkat"]').select2({
        placeholder: "-- Pilih pangkat --",
        allowClear: true 
    });

    $('select[name="kelompok_jabatan"]').select2({
        placeholder: "-- Pilih kelompok jabatan --",
        allowClear: true 
    });

    $('select[name="nama_jenjang_jabatan"]').select2({
        placeholder: "-- Pilih kelompok jabatan --",
        allowClear: true 
    });

    // $('select[name="nama_unit"]').select2({
    //     placeholder: "-- Pilih unit --",
    //     allowClear: true 
    // });


    
    
   
    $('select[name="nama_instansi"]').on('change', function() {
        var selectedOption = $(this).find('option:selected');
        var kodeInstansi = selectedOption.data('kode');
        $('#kode_instansi').val(kodeInstansi);
    });

   
    $('select[name="kelompok_jabatan"]').on('change', function() {
        var selectedOption = $(this).find('option:selected');
        var kodeJabatan = selectedOption.data('kode');
        $('#kode_jabatan').val(kodeJabatan);
    });

   
    $('select[name="nama_jenjang_jabatan"]').on('change', function() {
        var selectedOption = $(this).find('option:selected');
        var kodeJenjangJabatan = selectedOption.data('kode');
        $('#kode_jenjang_jabatan').val(kodeJenjangJabatan);
    });

    // $('select[name="nama_unit"]').on('change', function() {
    // var selectedOption = $(this).find('option:selected');
    // var kodeUnitKerja = selectedOption.data('kode'); 
    // $('#kode_unit_kerja').val(kodeUnitKerja); 
  
});

    


document.addEventListener('DOMContentLoaded', function () {
    var selectKelompokJabatan = document.querySelector('select[name="kelompok_jabatan"]');
    var selectNamaJenjangJabatan = document.querySelector('select[name="nama_jenjang_jabatan"]');
    var selectInstansi = document.querySelector('select[name="nama_instansi"]');
    var inputKodeJabatan = document.getElementById('kode_jabatan');
    var inputKodeJenjangJabatan = document.getElementById('kode_jenjang_jabatan');
    var inputKodeInstansi = document.getElementById('kode_instansi');
    var provinsiSelect = document.getElementById('provinsi');
    var kotaKabSelect = document.getElementById('kota_kab');


    


    selectInstansi.addEventListener('change', function () {
        var kodeInstansi = selectInstansi.options[selectInstansi.selectedIndex].getAttribute('data-kode');
        inputKodeInstansi.value = kodeInstansi;
    });

    selectKelompokJabatan.addEventListener('change', function () {
        var kodeJabatan = selectKelompokJabatan.options[selectKelompokJabatan.selectedIndex].getAttribute('data-kode');
        inputKodeJabatan.value = kodeJabatan;
    });

    selectNamaJenjangJabatan.addEventListener('change', function () {
        var kodeJenjangJabatan = selectNamaJenjangJabatan.options[selectNamaJenjangJabatan.selectedIndex].getAttribute('data-kode');
        inputKodeJenjangJabatan.value = kodeJenjangJabatan;
    });
});

$(document).ready(function(){
    FilePond.registerPlugin(
        FilePondPluginImagePreview,
        FilePondPluginImageExifOrientation,
        FilePondPluginFileValidateSize,
        FilePondPluginFileValidateType,
        // FilePondPluginImageEdit
    );

    

    var ecommerce = FilePond.create(document.querySelector('.file-upload'), {
        storeAsFile: true,
        @if($user['avatar_url'])
        files: [
            { 
                source: '{{$user['avatar_url']}}',
            },
        ],
        @endif
    });

    var optionsProvinsi = $('select[name="ref_provinsi_id"]');
    var optionKotaKab = $('select[name="ref_kota_kab_id"]');

    optionsProvinsi.on('change', function(e){
        var value = e.target.value;
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            method: 'POST',
            url: "{{route('member.change-profile.kotaKab')}}",
            processData: false,
            contentType: 'contentType: "application/json"',
            data: JSON.stringify({
                '_token': csrfToken,
                'ref_provinsi_id': value
            }),
            beforeSend: function(){
                optionKotaKab.attr('disabled', true);
                optionKotaKab.html('');
            },
            success: function(res){
                optionKotaKab.attr('disabled', false);
                var html = res.reduce((r, i) => {
                    r += `<option value="${i.id}">${i.nama}</option>`
                    return r;
                }, '');

                optionKotaKab.html(html);
            },
            error: function(e){
                optionKotaKab.attr('disabled', false);
            }
        });
    })

    $('select[name="nama_instansi"]').on('change', function() {
        var selectedOption = $(this).find('option:selected');
        var kodeInstansi = selectedOption.data('kode');
        $('#kode_instansi').val(kodeInstansi);

        
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            method: 'POST',
            url: "{{ route('member.change-profile.getDataFromUNIT') }}",
            data: {
                '_token': csrfToken,
                'kode_instansi': kodeInstansi,
                'type': 'unit' 
            },
            beforeSend: function() {
                
            },
            success: function(response) {
                
                $('select[name="nama_unit"]').empty(); 
            $.each(response.data, function(index, unit) {
               
                var option = $('<option></option>').attr('value', unit.nama_unit).text(unit.nama_unit).data('kode', unit.kode_unit_kerja);
              
                $('select[name="nama_unit"]').append(option);
            });

           
            var firstOption = $('select[name="nama_unit"] option:first');
            var firstKodeUnitKerja = firstOption.data('kode');
            $('#kode_unit_kerja').val(firstKodeUnitKerja);
        },
            error: function(xhr, status, error) {
              
            }
        });
    });

    

    

   
});
</script>
@endpush
