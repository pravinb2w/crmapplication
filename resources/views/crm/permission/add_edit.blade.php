<div class="modal-dialog modal-lg modal-right">
    <style>
        .custom-scroll {
            max-height: 600px;
            overflow-y: auto;
        }
    </style>
    <div class="modal-content custom-content">
        <div class="modal-header px-3" id="myLargeModalLabel">{{ $modal_title }}</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form class="form-horizontal modal-body" id="permissions-form" method="POST" action="{{ route('permissions.save') }}" autocomplete="off">

        <div class="modal-body justify-content-center align-items-center h-100 p-3 custom-scroll">
            <div class="w-100">
                <div class="row">
                    <div class="col-12" id="error"></div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="role_id"> Role <span class="text-danger">*</span></label>
                            <select name="role_id" id="role_id" class="form-control" required>
                                <option value="">--select--</option>
                                @if( isset( $role ) && !empty($role))
                                    @foreach ($role as $item)
                                        <option value="{{ $item->id }}" @if( isset($info->role_id) && $info->role_id == $item->id) selected @endif>{{ $item->role }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <table class="table table-borderd ">
                            <thead>
                                <tr>
                                    <th>Menu</th>
                                    <th>Permission</th>
                                </tr>
                                
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td>
                                        <div class="d-flex w-100">
                                            <div class="w-20">
                                                <input type="checkbox" name="visible_all" id="visible_all">
                                                <label class="px-2" for="visible_all">All </label>
                                            </div>
                                            <div class="w-20">

                                                <input type="checkbox" name="edit_all" id="edit_all">
                                                <label class="px-2" for="edit_all">All </label>
                                            </div>
                                            <div class="w-20">

                                                <input type="checkbox" name="delete_all" id="delete_all">
                                                <label class="px-2" for="delete_all">All </label>
                                            </div>
                                            <div class="w-20">

                                                <input type="checkbox" name="assign_all" id="assign_all">
                                                <label class="px-2" for="assign_all">All </label>
                                            </div>
                                            <div class="w-20">

                                                <input type="checkbox" name="export_all" id="export_all">
                                                <label class="px-2" for="export_all">All </label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @php
                                    // print_r( $info->permission);
                                @endphp
                                @if( isset($id) && !empty($id) )
                                @foreach ($info->permission as $item)
                                    
                                <tr>
                                    <td>
                                        {{ str_replace('_', ' ', ucwords($item->menu) ) }}
                                    </td>
                                    <td>
                                        <div class="mt-2">
                                            <div class="form-check form-check-inline">
                                                <input type="checkbox" class="form-check-input visible" @if( isset($item->is_view) && $item->is_view == 'on' ) checked @endif name="visible_{{ $item->menu }}" id="visible_{{ $item->menu }}">
                                                <label class="form-check-label" for="visible_{{ $item->menu }}">Visible</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="checkbox" name="editable_{{ $item->menu }}"  @if(isset($item->is_edit) && $item->is_edit == 'on' ) checked @endif class="edit form-check-input" id="editable_{{ $item->menu }}">
                                                <label class="form-check-label" for="editable_{{ $item->menu }}">Edit</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="checkbox" name="delete_{{ $item->menu }}" @if(isset($item->is_delete) && $item->is_delete == 'on' ) checked @endif  class="delete form-check-input" id="delete_{{ $item->menu }}">
                                                <label class="form-check-label" for="delete_{{ $item->menu }}">Delete</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="checkbox" name="assign_{{ $item->menu }}" @if( isset($item->is_assign) && $item->is_assign == 'on' ) checked @endif  class="assign form-check-input" id="assign_{{ $item->menu }}">
                                                <label class="form-check-label" for="assign_{{ $item->menu }}">Assign</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="checkbox" name="export_{{ $item->menu }}" @if( isset($item->is_export) && $item->is_export == 'on' ) checked @endif  class="export form-check-input" id="export_{{ $item->menu }}">
                                                <label class="form-check-label" for="export_{{ $item->menu }}">Export</label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach

                                @else
                                    @foreach( config('constant.role_menu') as $item )
                                    <tr>
                                        <td>
                                            {{ str_replace('_', ' ', ucwords($item) ) }}
                                        </td>
                                        <td>
                                            <div class="mt-2">
                                                <div class="form-check form-check-inline">
                                                    <input type="checkbox" class="form-check-input visible" name="visible_{{ $item }}" id="visible_{{ $item }}">
                                                    <label class="form-check-label" for="visible_{{ $item }}">Visible</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input type="checkbox" name="editable_{{ $item }}" class="edit form-check-input" id="editable_{{ $item }}">
                                                    <label class="form-check-label" for="editable_{{ $item }}">Edit</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input type="checkbox" name="delete_{{ $item }}" class="delete form-check-input" id="delete_{{ $item }}">
                                                    <label class="form-check-label" for="delete_{{ $item }}">Delete</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input type="checkbox" name="assign_{{ $item }}" class="assign form-check-input" id="assign_{{ $item }}">
                                                    <label class="form-check-label" for="assign_{{ $item }}">Assign</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input type="checkbox" name="export_{{ $item }}" class="export form-check-input" id="export_{{ $item }}">
                                                    <label class="form-check-label" for="export_{{ $item }}">Export</label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif

                            </tbody>
                        </table>
                    </div>
                    
                    <input type="hidden" name="id" value="{{ $info->id ?? '' }}">
                    
                </div>  
            </div>
        </div>
        <div class="modal-footer px-3">
            <div class="col-12 text-end">
                <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal" aria-label="Close"> Cancel</button>
                <button type="submit" class="btn btn-primary" id="save">Save</button>
            </div>
        </div>
    </div><!-- /.modal-content -->
</div>

<script>
   $("#permissions-form").validate({
            submitHandler:function(form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    beforeSend: function() {
                        $('#error').removeClass('alert alert-danger');
                        $('#error').html('');
                        $('#error').removeClass('alert alert-success');
                        $('#save').html('Loading...');
                    },
                    success: function(response) {
                        $('#save').html('Save');
                        if(response.error.length > 0 && response.status == "1" ) {
                            $('#error').addClass('alert alert-danger');
                            response.error.forEach(display_errors);
                        } else {
                            $('#error').addClass('alert alert-success');
                            setTimeout(function(){
                                $('#Mymodal').modal('hide');
                                
                            },100);
                            ReloadDataTableModal('permissions-datatable');
                        }
                    }            
                });
            }
        });

    $('#visible_all' ).click(function(){
        if( $(this).is(":checked")){
            $('.visible').attr('checked', true);
        } else {
            $('.visible').attr('checked', false);
        }
    }); 
    
    $('#edit_all' ).click(function(){
        if( $(this).is(":checked")){
            $('.edit').attr('checked', true);
        } else {
            $('.edit').attr('checked', false);
        }
    }); 

    $('#delete_all' ).click(function(){
        if( $(this).is(":checked")){
            $('.delete').attr('checked', true);
        } else {
            $('.delete').attr('checked', false);
        }
    }); 

    $('#assign_all' ).click(function(){
        if( $(this).is(":checked")){
            $('.assign').attr('checked', true);
        } else {
            $('.assign').attr('checked', false);
        }
    }); 

    $('#export_all' ).click(function(){
        if( $(this).is(":checked")){
            $('.export').attr('checked', true);
        } else {
            $('.export').attr('checked', false);
        }
    }); 
     
     
</script>