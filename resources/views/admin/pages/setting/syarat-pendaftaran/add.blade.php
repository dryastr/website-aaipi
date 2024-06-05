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
                                <label for="title">Title</label>
                                <input type="text" class="form-control" name="title">
                                <div id="feedback-title" class=""></div>
                            </div>
                        </div>
                        <div class="row mb-4 form-lable">
                            <div class="form-group col-md-6">
                                <label for="label">Form Label</label>
                                <input type="text" class="form-control" name="label">
                                <div id="feedback-label" class=""></div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="form-group col-md-6">
                                <label for="name">Type</label>
                                <select name="type" class="form-select">
                                    <option value="text">Text</option>
                                    <option value="file">File</option>
                                    <option value="checklist">Checklist</option>
                                </select>
                                <div id="feedback-type" class=""></div>
                            </div>
                        </div>
                        <div class="row mb-4 file-requirement">
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th colspan="2">Ketentuan File</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Diwajibkan</td>
                                            <td>
                                                <select name="diwajibkan" class="form-select">
                                                    <option value="ya">Ya</option>
                                                    <option value="tidak">Tidak</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Type File</td>
                                            <td>
                                                <select name="type_file" class="form-select">
                                                    <option value="*">Semua</option>
                                                    <option value="jpeg,png">Gambar (jpg, jpeg, png)</option>
                                                    <option value="pdf">PDF</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Ukuran Maksimal File</td>
                                            <td>
                                                <div class="row p-0 m-0">
                                                    <div class="col-md-8 px-0">
                                                        <input type="text" name="max_file[size]" class="form-control">
                                                    </div>
                                                    <div class="col-md-4 px-0">
                                                        <select class="form-select" name="max_file[type]">
                                                            <option value="kb">KB</option>
                                                            <option value="mb">MB</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div id="feedback-max_file" class=""></div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <a href="{{route('setting.syarat-pendaftaran.index')}}" class="btn btn-danger">Kembali</a>
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
                var select = $('select[name="type"]');
                var label = $('input[name="label"]');
                var elmRequirement = $('.file-requirement');
                var elmLabel = $('.form-lable');
                changeHtml(select.val());

                select.on('change', function(e){
                    var value = e.target.value

                    changeHtml(value);
                })

                form.on('submit', function(e){
                    e.preventDefault();
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    var formData = form.serializeArray();
                    formData.push({name: '_token', value: csrfToken})
                    formData.push({name: 'parent_id', value: '{{$parent}}'})
                    $.ajax({
                        type: 'POST',
                        url: "{{route('setting.syarat-pendaftaran.store')}}",
                        dataType: 'json',
                        data: formData,
                        beforeSend: function(){
                            btn.html('<div class="spinner-border text-white me-2 align-self-center loader-sm "></div> Loading').attr('disabled', true)
                            $('.invalid-feedback').removeClass('invalid-feedback d-block').html('')
                        },
                        success: function(res){
                            main.notification(res.message, NOTIFICATION_COLOR.SUCCESS)
                            window.location.href = "{{route('setting.syarat-pendaftaran.index')}}";
                        },
                        error: function(res){
                            var response = res.responseJSON;
                            btn.html('Simpan').attr('disabled', false)
                            main.notification(response.message, NOTIFICATION_COLOR.DANGER)
                            if(typeof res.responseJSON.errors === 'object'){
                                Object.keys(response.errors).map((i) => {
                                    var message = response.errors[i];
                                    if(i == 'max_file.size'){
                                        $(`#feedback-max_file`).addClass('invalid-feedback d-block').html(message)
                                    }
                                    $(`#feedback-${i}`).addClass('invalid-feedback d-block').html(message)
                                })
                            }
                        },
                        done: function(){
                        }
                    })
                })

                function changeHtml(value){
                    if(value == 'file'){
                        elmRequirement.removeClass('d-none');
                    }else{
                        elmRequirement.addClass('d-none');
                    }

                    if(value == 'text'){
                        elmLabel.addClass('d-none');
                    }else{
                        elmLabel.removeClass('d-none');
                    }
                }
            });
        </script>
    </x-slot>
</x-base-layout>
