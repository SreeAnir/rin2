

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>{{ env('APP_NAME') }} | @yield('title', 'Test')</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> 

  @stack('styles')
  <style>
    .notification-icon {
        position: relative;
        display: inline-block;
    }

    .notification-icon svg {
        width: 24px;
        height: 24px;
        fill: #333; /* Change the color as needed */
    }

    .notification-count {
      position: absolute;
      top: 0;
      right: 0;
      background-color: rgb(19 66 199);
      color: white;
      border-radius: 50%;
      padding: 1px 6px;
      font-size: 12px;
    }
</style>
</head>

<body>

<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-ligh bg-light">
  <a class="navbar-brand" href="{{ route('user.notifications')}}">TEST</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    @include('layout.common.app-header')

    
  </div>
</nav>

<div class="container mt-3">
  @include('layout.common.session_messages')
    @yield('content')
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
@stack('scripts')
<script>
  $.ajaxSetup({headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'}});

  </script>
</body>
</html>
