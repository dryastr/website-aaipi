<x-base-layout :title="$title">
    <div class="row layout-top-spacing">
        <div class="col-md-12 layout-spacing">
            <div class="widget widget-table-one">
                <div class="widget-heading">
                    <h5 class="">{{$title}}</h5>
                </div>
                <div class="widget-content">
                    <form id="form-data" method="POST" novalidate>
                        <div class="row mb-4">
                                <div class="form-group col-md-6">
                                    <label for="kode">KODE</label>
                                    <input type="text" class="form-control" name="kode"  required>
                                    <div id="feedback-tahun" class=""></div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="form-group col-md-6">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" name="title"  required>
                                    <div id="feedback-tahun" class=""></div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="form-group col-md-6">
                                    <label for="date">Tanggal</label>
                                    <input type="date" class="form-control" name="date"  required>
                                    <div id="feedback-tahun" class=""></div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="form-group col-md-6">
                                    <label for="location">Lokasi</label>
                                    <input type="text" class="form-control" name="location"  required>
                                    <div id="feedback-tahun" class=""></div>
                                </div>
                            </div>

                        <a href="{{route('setting.category-on-galeri.index')}}" class="btn btn-danger">Kembali</a>
                        <button type="submit" class="btn btn-primary btn-submit">Simpan</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <x-slot name="footerFiles">
        <script>
            $(document).ready(function(){
                var btn = $('.btn-submit');
                var form = $('#form-data')
                form.on('submit', function(e){
                    e.preventDefault();
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    var formData = form.serializeArray();
                    formData.push({name: '_token', value: csrfToken})
                    $.ajax({
                        type: 'POST',
                        url: "{{route('setting.category-on-galeri.store')}}",
                        dataType: 'json',
                        data: formData,
                        beforeSend: function(){
                            btn.html('<div class="spinner-border text-white me-2 align-self-center loader-sm "></div> Loading').attr('disabled', true)
                        },
                        success: function(res){
                            main.notification(res.message, NOTIFICATION_COLOR.SUCCESS)
                            window.location.href = "{{route('setting.category-on-galeri.index')}}";
                        },
                        error: function(res){
                            var response = res.responseJSON;
                            btn.html('Simpan').attr('disabled', false)
                            main.notification(response.message, NOTIFICATION_COLOR.DANGER)
                            if(typeof res.responseJSON.errors === 'object'){
                                Object.keys(response.errors).map((i) => {
                                    var message = response.errors[i];
                                    $(`#feedback-${i}`).addClass('invalid-feedback').html(message)
                                })
                            }
                            form.addClass('was-validated')
                        },
                        done: function(){
                        }
                    })
                })
            });
        </script>
    </x-slot>

    <x-slot name="footerFiles">
    <script>
        $(document).ready(function () {
            var btn = $('.btn-submit');
            var form = $('#form-data');

            form.on('submit', function (e) {
                e.preventDefault();

                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var formData = form.serializeArray();
                formData.push({ name: '_token', value: csrfToken });

                $.ajax({
                    type: 'POST',
                    url: "{{ route('setting.category-on-galeri.store') }}",
                    dataType: 'json',
                    data: formData,
                    beforeSend: function () {
                        btn.html('<div class="spinner-border text-white me-2 align-self-center loader-sm "></div> Loading')
                            .attr('disabled', true);
                    },
                    success: function (res) {
                        main.notification(res.message, NOTIFICATION_COLOR.SUCCESS);
                        window.location.href = "{{ route('setting.category-on-galeri.index') }}";
                    },
                    error: function (res) {
                        var response = res.responseJSON;
                        btn.html('Simpan').attr('disabled', false);
                        main.notification(response.message, NOTIFICATION_COLOR.DANGER);

                        if (typeof response.errors === 'object') {
                            Object.keys(response.errors).map(function (i) {
                                var message = response.errors[i];
                                $('#feedback-' + i).addClass('invalid-feedback').html(message);
                            });
                        }

                        form.addClass('was-validated');
                    },
                    complete: function () {
                        // Handle completion if needed
                    }
                });
            });
        });
    </script>
</x-slot>

</x-base-layout>
