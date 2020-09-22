@extends('layouts.app')

@section('css')
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4 class="title text-center">تیکت ها</h4>
                        <hr>
                        <ul class="nav nav-tabs nav-justified">
                            <li class="active"><a id="active_tickets_nav" data-toggle="tab" href="#active_tickets">نیاز به پاسخ</a></li>
                            <li><a id="finish_nav" data-toggle="tab" href="#finish">پایان یافته</a></li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div id="active_tickets" class="tab-pane fade in active">
                            <div class="content table-responsive table-full-width" style="margin: 0">
                                <table id="active_table" class="table table-hover table-striped">
                                    <thead>
                                    <th>نام کاربری</th>
                                    <th>شناسه</th>
                                    <th>عنوان</th>
                                    <th>تاریخ</th>
                                    <th></th>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div id="finish" class="tab-pane fade">
                            <div class="content table-responsive table-full-width" style="margin: 0">
                                <table id="finish_table" class="table table-hover table-striped">
                                    <thead>
                                    <th>نام کاربری</th>
                                    <th>شناسه</th>
                                    <th>عنوان</th>
                                    <th>تاریخ</th>
                                    <th></th>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="footer">
                    </div>
                </div>
            </div>
        </div>
@endsection

@section('js')
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.js"></script>
    <script>
        $(function() {
            $('#active_table').DataTable({
                paging:   true,
                ordering: true,
                processing: true,
                serverSide: true,
                language: {
                    url: '/lang/DataTablePER2.txt'
                },
                ajax: {
                    url: '{{ route('admin.active_tickets_table') }}',
                    type: 'POST',
                    'headers': {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: [
                    { data: 'name', name: 'users.name' },
                    { data: 'ticket_id', name: 'ticket_id' },
                    { data: 'title', name: 'title' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
            $('#finish_nav').one('click', function () {
                $('#finish_table').DataTable({
                    paging:   true,
                    ordering: true,
                    processing: true,
                    serverSide: true,
                    language: {
                        url: '/lang/DataTablePER1.txt'
                    },
                    ajax: {
                        url: '{{ route('admin.finish_tickets_table') }}',
                        type: 'POST',
                        'headers': {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    },
                    columns: [
                        { data: 'name', name: 'users.name' },
                        { data: 'ticket_id', name: 'ticket_id' },
                        { data: 'title', name: 'title' },
                        { data: 'created_at', name: 'created_at' },
                        { data: 'action', name: 'action', orderable: false, searchable: false}
                    ]
                });
            })

        });
    </script>
@endsection

