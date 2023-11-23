@extends('layout.app')
@section('title', 'Welcome')
@section('content')

    <div class="card bg-light p-4">
        <form action="{{ route('update.user.settings') }}" method="POST">
            @csrf
            @method('put')
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
            <input type="hidden"  
            value="{{ @$user->phone_number != null ? @$user->phone_number : old('phone_number') }}"
            id="existing_phone_number" name="existing_phone_number"  >
            <input type="hidden"  
            value="{{ @$user->id != null ? @$user->id : old('user_id') }}"
            id="user_id" name="user_id"  >
            <div class="form-group row">
                <div class="col-sm-6">
                    <div> Update Notification Set up.You will recieve on screen notificaiton only if this is enabled.</div>
                </div>
                <div class="col-sm-3">

                    <div class="custom-control custom-switch">
                        <input type="checkbox" name="notification_switch" class="custom-control-input" id="enableSwitch" 
                        @if(@$user->notification_switch== 1) checked @endif >
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
    <script>
        let  send_otp_url = "{{ route('send.otp') }}" ;
        let verify_otp ='{{ route('verify.otp') }}';
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
    <script src="{{ asset('js/settings.js')}}"></script>

    
    <script>
        
    </script>

    @include('profile.otp-verify')
@endpush
