<div class="modal-dialog modal-lg modal-right">
    <style>
        .custom-scroll {
            max-height: 675px;
            overflow-y: auto;
        }
    </style>
    <div class="modal-content">
        <div class="modal-header px-3" id="myLargeModalLabel">{{ $modal_title }}</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form class="form-horizontal modal-body" id="customers-form" method="POST" action="{{ route('customers.save') }}" autocomplete="off">

        <div class="modal-body d-flex justify-content-center align-items-center h-100 p-3 custom-scroll">
            <div class="w-100">
                <div class="row">
                    <div class="col-12" id="error"></div>
                </div>
                <div class="row">
                    <input type="hidden" name="id" value="{{ $info->id ?? '' }}">
                    <div class="col-md-6 mb-3"> 
                        <label for="first_name" class="col-form-label">First Name <span class="text-danger">*</span></label>                   
                        <input type="text" name="first_name" class="form-control" id="first_name" placeholder="Type here.." value="{{ $info->first_name ?? '' }}" required>        
                    </div>     
                    <div class="col-md-6 mb-3">
                        <label for="last_name" class="col-form-label">Last Name  </label>                   
                        <input type="text" name="last_name" class="form-control" id="last_name" value="{{ $info->last_name ?? '' }}" placeholder="Type here.." >        
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="name" class="col-form-label">Organization </label>                   
                        <input type="text" name="organization" id="organization" value="{{ $info->company->name ?? '' }}" class="form-control" autocomplete="off">
                        <input type="hidden" name="organization_id" id="organization_id" value="{{ $info->organization_id ?? '' }}">
                        <div id="result" class="typeahead-custom"></div>
                    </div>
                    <div class="col-6 mb-4">
                        <label for="email" class="col-form-label"> Phone Number </label>
                        <input type="number" name="mobile_no" id="mobile_no" value="{{ $info->mobile_no ?? '' }}" class="form-control" autocomplete="off">

                        <div class="mt-3">
                            <div id="phoneRow">
                                @if(isset($info->secondary_mobile) && !empty($info->secondary_mobile))
                                    @foreach ($info->secondary_mobile as $item)
                                        <div id="inputPhoneFormRow">
                                            <div class="input-group mb-3">
                                                <input type="text" name="secondary_phone[]" value="{{ $item->mobile_no ?? '' }}" class="form-control m-input" placeholder="Enter Phone no" autocomplete="off">
                                                <div class="input-group-append">
                                                    <button id="removePhoneRow" type="button" class="btn btn-danger">Remove</button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <button id="addPhoneRow" type="button" class="btn btn-info">Add Secondary Phone no</button>
                        </div>
                    </div>
                    <div class="col-6 mb-4">
                        <label for="email" class="col-form-label"> Email Id </label>
                        <input type="email" name="email" id="email" value="{{ $info->email ?? '' }}" class="form-control" autocomplete="off">
                        <div class="mt-3">
                            <div id="emailRow">
                                @if(isset($info->secondary_email) && !empty($info->secondary_email))
                                    @foreach ($info->secondary_email as $item)
                                        <div id="inputEmailFormRow">
                                            <div class="input-group mb-3">
                                                <input type="text" name="secondary_email[]" value="{{ $item->email ?? '' }}" class="form-control m-input" placeholder="Enter Phone no" autocomplete="off">
                                                <div class="input-group-append">
                                                    <button id="removeEmailRow" type="button" class="btn btn-danger">Remove</button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <button id="addemailRow" type="button" class="btn btn-info">Add Secondary Emails</button>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <label for="description" class="col-form-label me-2">Status</label>
                            <div>
                                <input type="checkbox" name="status" id="switch3" {{ (isset($info->status) && $info->status == '1' )  ? 'checked' : '' }} data-switch="primary">
                                <label for="switch3" data-on-label="" data-off-label=""></label>
                            </div>  
                        </div>
                    </div>
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
    $("#addPhoneRow").click(function () {
        var html = '';
        html += '<div id="inputPhoneFormRow">';
        html += '<div class="input-group mb-3">';
        html += '<input type="text" name="secondary_phone[]" class="form-control m-input" placeholder="Enter Phone no" autocomplete="off">';
        html += '<div class="input-group-append">';
        html += '<button id="removePhoneRow" type="button" class="btn btn-danger">Remove</button>';
        html += '</div>';
        html += '</div>';

        $('#phoneRow').append(html);
    });

    // remove row
    $(document).on('click', '#removePhoneRow', function () {
        $(this).closest('#inputPhoneFormRow').remove();
    });


    $("#addemailRow").click(function () {
            var html = '';
            html += '<div id="inputEmailFormRow">';
            html += '<div class="input-group mb-3">';
            html += '<input type="text" name="secondary_email[]" class="form-control m-input" placeholder="Enter email" autocomplete="off">';
            html += '<div class="input-group-append">';
            html += '<button id="removeEmailRow" type="button" class="btn btn-danger">Remove</button>';
            html += '</div>';
            html += '</div>';

            $('#emailRow').append(html);
        });

    // remove row
    $(document).on('click', '#removePhoneRow', function () {
        $(this).closest('#inputPhoneFormRow').remove();
    });

    $(document).on('click', '#removeEmailRow', function () {
        $(this).closest('#inputEmailFormRow').remove();
    });
        $('#result').hide();

        $('#organization').keyup(function(){
            var inputs = this.value;
            $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
            $.ajax({
                    url: "{{ route('autocomplete_org') }}",
                    method:'POST',
                    data: {org:inputs},
                    success:function(response){
                        $('#result').html(response);
                        $('#result').show();
                    }      
                });
        })

        $("#customers-form").validate({
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
                            ReloadDataTableModal('customers-datatable');
                        }
                    }            
                });
            }
        });

        
</script>