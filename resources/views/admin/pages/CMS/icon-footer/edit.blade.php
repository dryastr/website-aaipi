<x-base-layout :title="$title">
    <div class="row layout-top-spacing">
        <div class="col-md-12 layout-spacing">
            <div class="widget widget-table-one">
                <div class="widget-heading">
                    <h5 class="">{{$title}}</h5>
                </div>
                <div class="widget-content">
                    <form id="form-data" method="POST" enctype="multipart/form-data" novalidate>
                    <div class="row mb-4">
                            <div class="form-group col-md-6">
                                <label for="title">Judul</label>
                                <input type="text" class="form-control" name="title" value="{{$item->title}}" required>
                                <div id="feedback-name" class=""></div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="form-group col-md-6">
                                <label for="link">URL</label>
                                <input type="text" class="form-control" name="link" value="{{$item->link}}" required>
                                <div id="feedback-name" class=""></div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="form-group col-md-6">
                                <label for="sosmed_icon">Icon</label>
                                <input type="text" class="form-control" name="sosmed_icon" value="{{$item->sosmed_icon}}" required>
                                <div id="feedback-description" class=""></div>
                            </div>
                        </div>

                        <a href="{{route('CMS.icon-footer.index')}}" class="btn btn-danger">Kembali</a>
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
    var form = $('#form-data');
    
    form.on('submit', function(e){
        e.preventDefault();
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var formData = new FormData(form[0]);
        
        // Tambahkan token CSRF dan _method ke FormData
        formData.append('_token', csrfToken);
        formData.append('_method', 'PUT');

        $.ajax({
            type: 'POST', // Tetap gunakan POST
            url: "{{ route('CMS.icon-footer.update', $item->id) }}",
            dataType: 'json',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function(){
                btn.html('<div class="spinner-border text-white me-2 align-self-center loader-sm "></div> Loading').attr('disabled', true)
            },
            success: function(res){
                main.notification(res.message, NOTIFICATION_COLOR.SUCCESS)
                window.location.href = "{{ route('CMS.icon-footer.index') }}";
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
            complete: function(){
                //...
            }
        });
    });
});
    </script>
</x-slot>

</x-base-layout>
