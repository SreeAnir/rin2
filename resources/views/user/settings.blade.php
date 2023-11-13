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
        <input type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" id="email" name="email" placeholder="name@example.com">
        @error('email')
        <div class="invalid-feedback">
        {{ $message }}
        </div>
        @enderror
      </div>
    </div>
    

    <div class="form-group row">
      <label for="phone" class="col-sm-2 col-form-label">Phone</label>
      <div class="col-sm-6">
        <input type="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" id="phone" name="phone" placeholder="+XXXXXXX">
        @error('phone')
        <div class="invalid-feedback">
        {{ $message }}
        </div>
        @enderror
      </div>
    </div>
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
  <script>
        $(document).ready(function () {
            $('#enableSwitch').change(function () {
                var isEnabled = $(this).prop('checked');
                if (isEnabled) {
                    // Enable logic (if needed)
                    console.log('Enabled');
                } else {
                    // Disable logic (if needed)
                    console.log('Disabled');
                }
            });
        });
    </script>
  
@endpush
