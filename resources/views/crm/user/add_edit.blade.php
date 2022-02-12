<div class="modal-dialog modal-lg modal-right">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="myLargeModalLabel">{{ $modal_title }}</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-12" id="error">
                </div>
            </div>
            <form class="form-horizontal modal-body" id="users-form" method="POST" action="{{ route('users.save') }}" autocomplete="off">
                @csrf
                <input type="hidden" name="id" value="{{ $id ?? '' }}">
                
                <div class="row mb-3">
                    <label for="name" class="col-3 col-form-label">First Name <span class="text-danger">*</span></label>
                    <div class="col-9">
                        <input type="text" name="name" class="form-control" id="name" placeholder="Name" value="{{ $info->name ?? '' }}" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="last_name" class="col-3 col-form-label">Last Name </label>
                    <div class="col-9">
                        <input type="text" name="last_name" class="form-control" id="last_name" placeholder="Last Name" value="{{ $info->last_name ?? '' }}" >
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="email" class="col-3 col-form-label"> Email<span class="text-danger">*</span></label>
                    <div class="col-9">
                        <input type="text" name="email" class="form-control" id="email" placeholder="Email" value="{{ $info->email ?? '' }}" required>
                    </div>
                </div>
                @if(!isset($id))
                <div class="row mb-3">
                    <label for="password" class="col-3 col-form-label"> Password<span class="text-danger">*</span></label>
                    <div class="col-9">
                        <input type="password" name="password" class="form-control" id="password" placeholder="Password" value="{{ $info->password ?? '' }}" required>
                    </div>
                </div>
                @endif
                <div class="row mb-3">
                    <label for="mobile_no" class="col-3 col-form-label">Mobile Number <span class="text-danger">*</span></label>
                    <div class="col-9">
                        <input type="text" name="mobile_no" class="form-control" id="mobile_no" placeholder="Mobile Number" value="{{ $info->mobile_no ?? '' }}" required>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label for="mobile_no" class="col-3 col-form-label">Role <span class="text-danger">*</span></label>
                    <div class="col-9">
                        <select name="role_id" id="role_id" class="form-control">
                            <option value="">--select--</option>
                            @if( isset($roles) && !empty($roles))
                                @foreach ($roles as $item)
                                    <option value="{{ $item->id }}" @if( isset($info->role_id) && $info->role_id == $item->id) selected @endif>{{ $item->role }}</option>
                                @endforeach
                            @endif
                        </select>
                        {{-- <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                            <select name="role_id" id="role_id" class="form-control"></select>
                            <span class="input-group-btn input-group-append">
                                <button class="btn btn-primary bootstrap-touchspin-up" type="button">+</button>
                            </span>
                        </div> --}}
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label for="description" class="col-3 col-form-label">Status</label>
                    <!-- Success Switch-->
                    <div class="col-9">
                        <input type="checkbox" name="status" id="switch3" {{ (isset($info->status) && $info->status == '1' )  ? 'checked' : '' }} data-switch="success"/>
                        <label for="switch3" data-on-label="" data-off-label=""></label>
                    </div>
               </div>
                <div class=" row">
                    <div class="col-12 text-end">
                        <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal" aria-label="Close"> Cancel</button>
                        <button type="submit" class="btn btn-info" id="save">Save</button>
                    </div>
                </div>
            </form> 
        </div>
    </div><!-- /.modal-content -->
</div>

<script>
        $("#users-form").validate({
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
                            response.error.forEach(display_errors);
                            setTimeout(function(){
                                $('#Mymodal').modal('hide');
                            },100);
                            ReloadDataTableModal('users-datatable');
                        }
                    }            
                });
            }
        });

        
</script>