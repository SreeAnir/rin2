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
            
            @if($notifications->count() > 0 )
            @foreach($notifications as $not)
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
              <strong> {{ $not->notificationTypeLabel($not->notification_type) }}</strong>  {{ $not->short }}
              <button id="{{ $not->id }}"  type="button" class="close set_read"  aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            @endforeach
            @endif
         </div>
     </div>
 @endsection
 @push('scripts')
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

 <script>
   $(document).ready(function () {
    $('body').on('click', '.set_read', function (e) {
            // $(document).('click',function () {
              let patent_wrapper = $(this).parents('.alert');
                $.ajax({
                        url:"{{ route('user.set_read') }}",
                        type: 'post',
                        data: {'notification_user' : $(this).attr('id')},
                        success: function(response) {
                            if (response.status == "success") {
                               $(patent_wrapper).fadeOut();
                            } else {
                                Swal.fire({
                                    title: response.message_title,
                                    text: response.message,
                                    icon: "error"
                                });
                            }

                        },
                        error: function(xhr, status, error) {
                            // Handle error response
                            Swal.fire({
                                title: "Unknown Error",
                                text: "",
                                icon: "error"
                            });
                        }
                    });
            });
     });
 </script>
 
  
  
 @endpush
