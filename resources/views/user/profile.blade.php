 @extends('layout.app')
 @section('title', 'Welcome')
 @section('content')
     <div class="card pt-3">
         <div class="card-body pt-3">

             <h2 class="mb-4">Welcome {{ @$user->name }}</h2>
             <!-- In your admin dashboard view -->
             <div class="alert alert-primary" role="alert">
             <h5> You can update your email ,phone and notification settings from  <a role="button" class="text-info" action="{{ route('user.settings') }}"> here</a> </h5>
            </div>
            <div class="alert alert-success" role="alert">
              This is a secondary alert—check it out!
            </div>
            @if($notifications->count() > 0 )
            @foreach($notifications as $notificaion)
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
              <strong>Warning!</strong> This is a dismissible alert. Click the close button to dismiss it.
              <button id="{{ $notificaion }}"  type="button" class="close set_read" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            @endforeach
            @endif

         </div>
     </div>
 @endsection

