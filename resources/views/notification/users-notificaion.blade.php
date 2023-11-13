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
    <h2 class="mb-4">Users</h2>
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
@push('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> 

<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>


<script>
  $(document).ready(function () {
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
