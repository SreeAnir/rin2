 
@extends('layout.admin')
@section('title', 'List Users')

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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

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
