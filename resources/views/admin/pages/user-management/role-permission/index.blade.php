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
                    <div class="row mb-4">
                        <div class="form-group col-md-4">
                            <select type="text" class="form-select" name="role_id" id="role_id">
                                <option value="">Pilih Role</option>
                                @foreach($roles as $role)
                                <option value="{{$role->id}}">{{$role->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <form id="form-data">
                            <table id="table-role-permission" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Permission</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary btn-submit">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <x-slot name="footerFiles">
    <script>
        function generateTable(data = [], additional = ''){
            var html = '';
            var html = data.reduce((result, item) => {
                let checkChildren = item.childrens;
                let chekPermission = item.permissions
                result += `<tr>
                    <td ${checkChildren && !chekPermission ? 'colspan="2"' : ''}>${additional + ' ' +item.title}</td>
                    ${checkChildren ?
                        ''
                        :
                        `<td>
                        ${ item.permissions === null ?  '-' : item.permissions.reduce((r, i) => {
                            r += `
                            <div class="form-check form-check-primary">
                                <input class="form-check-input" name="permission_id" type="checkbox" ${i.has_permissions ? 'checked="checked"' : ''} value="${i.id}" id="form-check-${i.id}">
                                <label class="form-check-label ps-1 pe-2" for="form-check-${i.id}"> ${i.name}</label>
                            </div>
                            `;
                            return r;
                        } , '')}
                        </td>`
                    }
                    </tr>`
                result += generateTable(item.childrens, additional + '-');
                return result;
            }, '');
            return html;
        }


        $(document).ready(function(){
            var elmTable = '#table-role-permission';
            var btn = $('.btn-submit');
            $('#role_id').change(function(e){
                var value = e.target.value ? e.target.value : null;
                sendData(value)
            })

            sendData();

            function sendData(id = null){
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var url = "{{route('user-management.role-permission.view', ':id')}}".replace(':id', id);
                $.ajax({
                    method: 'GET',
                    url: url,
                    beforeSend: function(){
                        $(elmTable + ' tbody').html('<tr><td colspan="2" class="text-center">Loading...</td></tr>')
                    },
                    success: function(res){
                        let html = generateTable(res);
                        $(elmTable + ' tbody').html(html);
                    }
                });
            }

            $('#form-data').on('submit', function(e){
                e.preventDefault();
                var role_id = $('#role_id').val();
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var formData = [];
                var elmChecklist = []
                $('input[name="permission_id"]').each(item => {
                    elmChecklist.push({
                        'check': $(this[item]).is(':checked'),
                        'value': $(this[item]).val()
                    })
                })
                formData.push({name: '_token', value: csrfToken})
                formData.push({name: 'role_id', value: role_id})
                formData.push({name: 'permission_id', value: JSON.stringify(elmChecklist)})

                $.ajax({
                    url: "{{route('user-management.role-permission.store')}}",
                    method: 'POST',
                    type: 'json',
                    data: formData,
                    beforeSend: function(){
                        btn.html('<div class="spinner-border text-white me-2 align-self-center loader-sm "></div> Loading').attr('disabled', true)
                    },
                    success: function(){
                        btn.html('Simpan').attr('disabled', false);
                        sendData($('#role_id').val());
                    }
                });
            })
        });



    </script>
    </x-slot>
</x-base-layout>
