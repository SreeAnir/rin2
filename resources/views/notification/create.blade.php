@extends('layout.admin')
@section('title', 'List Users')
{{-- @section('header_buttons') --}}

{{-- @endsection --}}
@section('content')
<div class="card pt-3"> 
    <div class="card-body pt-3"> 
<form action="{{ route('notification.store') }}" id="new_notification" method="POST">
    @csrf
    <h4 class="h3 mb-3 fw-normal">Create New Notification</h4>

    <div class="form-group row">
        <label for="email" class="col-sm-2 col-form-label">Notification Tyoe</label>
        <div class="col-sm-6">
          
             
              <select  name="notification_type" class="custom-select">
                <option value="">Choose</option>
                @foreach($notification_types as $key => $ntype)
                <option value="{{ @$key }}">{{ @$ntype }}</option>
                @endforeach
              </select>
            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>


    <div class="form-group row">
        <label for="phone" class="col-sm-2 col-form-label">Message</label>
        <div class="col-sm-6">
            <textarea class="form-control" name="note" maxlength="150" rows="3"></textarea>
            @error('phone')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    
    <div class="form-group row">
        <label for="phone" class="col-sm-2 col-form-label">Message</label>
        <div class="col-sm-6">
            <input type="text" class="form-control datepicker" id="expired_on" name="expired_on" autocomplete="off">
            @error('phone')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    

    <div class="form-group row">
        <label for="phone" class="col-sm-2 col-form-label">Users</label>
        <div class="col-sm-6">
            <select class="select2-multiple form-control" name="users[]" multiple="multiple"
            id="users">
            @foreach($users as $user)
             <option value="{{ @$user->id }}">{{ @$user->name }}</option>
            @endforeach
           </select>
            @error('phone')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    {{-- <label for="phone" class="col-sm-6 col-form-label">Switch on-screen notifications on/off</label> --}}
    <div class="form-group row  ">
        <div class="col-sm-2">
        </div>
        <div class="col-sm-6 d-flex justify-content-start">
    <button class="float-right btn btn-lg btn-info" type="submit">Send Notification</button>

        </div>
    </div>
    </div>
</form>
</div>
</div>

@endsection

@push('scripts')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

 

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {

        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd', // Adjust the format as needed
            autoclose: true
        });
        $('#users').select2({
            placeholder: "Select",
            allowClear: true
        });
        $('#users').prepend('<option value="all" selected="selected">Select All</option>');
        $('#users').on('select2:select', function (e) { 
            if (e.params.data.id === 'all') {  
                $('#users').val(null).trigger('change');
            }else{
                if( $('#users option[value="all"]').prop('selected')){
                    $('#users option[value="all"]').prop('selected', false);
                    $('#users').trigger('change');
                 }
            }
        });

        $('#new_notification').validate({
                rules: {
                    notification_type: {
                    required: true,
                },
                note: {
                    maxlength:150
                },
                },
                messages: {
                notification_type: {
                    required: "Select Notification Type",
                },
                note: {
                    maxlength: "Message cannot be more than 30 characters"
                },
                
            },
                submitHandler: function(form) {
                    // Serialize form data
                    var formData = $(form).serialize();

                    // Perform AJAX request to submit form data
                    $.ajax({
                        url: $(form).attr('action'),
                        type: $(form).attr('method'),
                        data: formData,
                        success: function(response) {
                            if( response.status =="success"){
                            Swal.fire({
                                title:  response.message_title,
                                text:  response.message,
                                icon: "success"
                                });
                            }else{
                                Swal.fire({
                                title:  response.message_title,
                                text:  response.message,
                                icon: "error"
                                });
                            }

                        },
                        error: function(xhr, status, error) {
                            // Handle error response
                            Swal.fire({
                                title:  "Unknown Error",
                                text: "",
                                icon: "error"
                                });
                        }
                    });
                }
            });
       

    });
</script>

@endpush

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
    
    label.error{
        color:red;
    }
</style>
@endpush
