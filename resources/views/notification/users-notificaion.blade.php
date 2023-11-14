{{-- <!DOCTYPE html>
<html>
<head>
    <title>Laravel 8|7 Datatables Tutorial</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"/>
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>
<body>
     --}}
@extends('layout.app')
@section('title', 'Welcome')
@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Notifications</h2>
    <!-- In your admin dashboard view -->
    
    <table class="table table-bordered yajra-datatable">
        <thead>
            <tr>
                <th>No</th>
                <th>Message</th>
                <th>Message type</th>
                <th>Read At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

@endsection

@push('styles')
<link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
@endpush
@push('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> 

<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>


<script>
  $(document).ready(function () {

    $('body').on('click', '.set_read', function (e) {
            // $(document).('click',function () {
              let __this = $(this);
                $.ajax({
                        url:"{{ route('user.set_read') }}",
                        type: 'post',
                        data: {'notification_user' : $(this).attr('id')},
                        success: function(response) {
                            if (response.status == "success") {
                                __this.after(response.time);
                                __this.remove();
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

    $(function () {
    
    var table = $('.yajra-datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('notification.list') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'note',},
            {data: 'notification_type'},
            {data: 'unread'},
            {
                data: 'action', 
                name: 'action', 
            },
        ]
    });
    
  });
    });
</script>

 
 
@endpush
