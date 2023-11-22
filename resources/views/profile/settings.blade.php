@extends('layout.app')
@section('title', 'Welcome')
@section('content')

    <div class="card bg-light p-4">
        <form action="{{ route('update.user.settings') }}" method="POST">
            @csrf
            <h1 class="h3 mb-3 fw-normal">Hello , {{ @$user->name }}</h1>
            <h4 class="h3 mb-3 fw-normal">Update your settings</h4>


            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-6">
                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                        value="{{ @$user->email != null ? @$user->email : old('email') }}" id="email" name="email"
                        placeholder="name@example.com">
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>


            <div class="form-group row">
                <label for="phone" class="col-sm-2 col-form-label">Phone</label>
                <div class="col-sm-3">
                    <input type="phone" class="mask-phone form-control @error('phone') is-invalid @enderror"
                        value="{{ @$user->phone_number != null ? @$user->phone_number : old('phone_number') }}"
                        id="phone_number" name="phone_number" placeholder="+XXXXXXXXXXXX">
                    @error('phone_number')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <input type="hidden" value="true" name="otp_validated"  id="otp_validated" />
            <div class="form-group row">
                <div class="col-sm-6">
                    <div> Update Notification Set up.You will recieve on screen notificaiton only if this is enabled.</div>
                </div>
                <div class="col-sm-3">

                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="enableSwitch" checked>
                        <label class="custom-control-label" for="enableSwitch">Enable</label>
                    </div>

                    {{-- <label for="phone" class="col-sm-6 col-form-label">Switch on-screen notifications on/off</label> --}}

                </div>
            </div>
            <div class="form-group row">


                <div class="col-sm-8">
                    {{-- <button class="float-right btn btn-lg btn-info mx-2" type="submit">Go to User</button> --}}
                    <button class="float-right btn btn-lg btn-info" type="submit">Update Settings</button>
                </div>
        </form>
    </div>
@endsection
@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>   --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7/jquery.inputmask.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>

    {{-- <script src=
"https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7/jquery.inputmask.min.js">
	</script> --}}
    <script>
        $(document).ready(function() {
          
          $('#resendOtp').click(function() {

            $(this).hide();
            sendOtp();

          });
            $('#confirmOtp').click(function() {

                $(this).attr('disabled', true);

                confirmOtp();
            });

            $('#enableSwitch').change(function() {
                var isEnabled = $(this).prop('checked');
                if (isEnabled) {
                    // Enable logic (if needed)
                    console.log('Enabled');
                } else {
                    // Disable logic (if needed)
                    console.log('Disabled');
                }
            });
            // $(".mask-phone").inputmask("+99-9999999999");
            var options = {
                onComplete: function(cep) {
                  sendOtp();
                },
                onInvalid: function(val, e, f, invalid, options) {
                    var error = invalid[0];
                    console.log("Digit: ", error.v, " is invalid for the position: ", error.p,
                        ". We expect something like: ", error.e);
                }
            };

            $('.mask-phone').mask('+99-9999999999', options);

            var optionsOtp = {
                onComplete: function(otp) {
                    console.log("Verify Phone number");
                    $('#confirmOtp').removeAttr('disabled');
                },
                onInvalid: function(val, e, f, invalid, optionsOtp) {
                    var error = invalid[0];
                    console.log("Digit: ", error.v, " is invalid for the position: ", error.p,
                        ". We expect something like: ", error.e);
                }
            };

            $('#otp').mask('0 - 0 - 0 - 0 - 0 - 0', optionsOtp);

        });
        
        let handleResend = () => {
          $('#resendOtp').show();
          $('#confirmOtp').hide();
          $('#otp').val('');
          $('#otp_validated').val(false);
        }
        function sendOtp(){
          $('#confirmOtp').show();
          $('#otp_validated').val(false);
                    $.ajax({
                        url: '{{ route('send.otp') }}', // Replace with your actual endpoint
                        method: 'POST',
                        data: {
                            phone_number: $(".mask-phone").val()
                        }, // Sending the entered phone number to the server
                        success: function(response) {

                            // Handle the response from the server
                            if (response.status == "success") {
                                // If the server response indicates success, show the modal
                                $('#otpModal').modal('show');
                            } else {
                                // If the server response indicates failure, handle accordingly
                                Swal.fire({
                                    title: response.message_title,
                                    text: response.message,
                                    icon: "error"
                                });
                            }
                        },
                        error: function(response) {
                            // Handle AJAX errors
                            console.log('Error making AJAX request');
                            Swal.fire({
                                    title: "Failed",
                                    text: "Failed to Send the code",
                                    icon: "error"
                                });
                        }
                    });
        }
        function confirmOtp() {
            $.ajax({
                url: '{{ route('verify.otp') }}', // Replace with your actual endpoint
                method: 'POST',
                data: {
                    phone_number: $(".mask-phone").val(),
                    otp_code: $('#otp').val()
                }, // Sending the entered phone number to the server
                success: function(response) {
                    $('#confirmOtp').removeAttr('disabled');

                    // Handle the response from the server
                    if (response.status == "success") {
                      $('#otp_validated').val(true);
                      $('#otpModal').modal('hide');
                        Swal.fire({
                            title: response.message_title,
                            text: response.message,
                            icon: "success"
                        });

                    } else {
                       handleResend();
                        Swal.fire({
                            title: response.message_title,
                            text: response.message,
                            icon: "error"
                        });
                    }
                },
                error: function(response) {
                    // Handle AJAX errors
                    $('#confirmOtp').removeAttr('disabled');
                    handleResend();
                    console.log('Error making AJAX request');
                    Swal.fire({
                        title: "Failed the verification",
                        text: "Failed to verify the code.Please resend the otp.",
                        icon: "error"
                    });
                }
            });
        }
    </script>

    @include('profile.otp-verify')
@endpush
