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
    <div class="container mt-5">
        <a class="btn btn-primary" role="button" href="{{ route('notifications.create')}}">New Notification</a>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button class="btn btn-secondary" type="submit">Logout</button>
        </form>
    </div>
<div class="container mt-5"> --}}
@extends('layout.admin')
@section('title', 'List Users')
{{-- @section('header_buttons') --}}

{{-- @endsection --}}
@section('content')
    <div class="card pt-3">
        <div class="card-body pt-3">


            <h2 class="mb-4">Notifications
                <a class="btn btn-sm btn-success" href="{{ route('notifications.create') }}"> + New</a>
            </h2>
            <!-- In your admin dashboard view -->


            <table class="table table-bordered yajra-datatable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Message</th>
                        <th>Message type</th>
                        <th>Recipients</th>
                        <th>Created at</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
@endsection
@push('styles')
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
@endpush
@push('scripts')
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript">
        $(function() {
            var table = $('.yajra-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.notification.list') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'note'
                    },
                    {
                        data: 'notification_type_label'
                    },
                    {
                        data: 'recipients'
                    },
                    {
                        data: 'created_at_format',
                        name: 'created_at_format'
                    },
                ]
            });

        });
    </script>
@endpush

</html>
