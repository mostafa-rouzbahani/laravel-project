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
                        <h4 class="title text-center">معاملات شما</h4>
                        <hr>
                        <ul class="nav nav-tabs nav-justified">
                            <li class="active"><a data-toggle="tab" href="#active_b">خرید (در حال انجام)</a></li>
                            <li><a id="s_nav" data-toggle="tab" href="#active_s">فروش (در حال انجام)</a></li>
                            <li><a id="f_nav" data-toggle="tab" href="#active_f">پایان یافته</a></li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div id="active_b" class="tab-pane fade in active">
                            <div class="content table-responsive table-full-width" style="margin: 0">
                                <table id="active_b_table" class="table table-hover table-striped">
                                    <thead>
                                    <th>فروشنده</th>
                                    <th>کشور</th>
                                    <th>ارز</th>
                                    <th>مبلغ</th>
                                    <th>تاریخ</th>
                                    <th>کد رهگیری</th>
                                    <th>وضعیت</th>
                                    <th>مرحله</th>
                                    <th></th>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div id="active_s" class="tab-pane fade">
                            <div class="content table-responsive table-full-width" style="margin: 0">
                                <table id="active_s_table" class="table table-hover table-striped">
                                    <thead>
                                    <th>خریدار</th>
                                    <th>کشور</th>
                                    <th>ارز</th>
                                    <th>مبلغ</th>
                                    <th>تاریخ</th>
                                    <th>کد رهگیری</th>
                                    <th>وضعیت</th>
                                    <th>مرحله</th>
                                    <th></th>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div id="active_f" class="tab-pane fade">
                            <div class="content table-responsive table-full-width" style="margin: 0">
                                <table id="active_f_table" class="table table-hover table-striped">
                                    <thead>
                                    <th>کد رهگیری</th>
                                    <th>نوع</th>
                                    <th>ارز</th>
                                    <th>تاریخ</th>
                                    <th>وضعیت</th>
                                    <th>حالت</th>
                                    <th></th>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="footer">
                        <hr>
                        <div class="legend">
                            <h5 style="margin-right: 20px"> وضعیت</h5>
                            <ul>
                                @foreach($transAccepts as $transAccept)
                                    <li> <strong>{{ $transAccept->name }}</strong> :   {{ $transAccept->desc }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="legend">
                            <h5 style="margin-right: 20px"> حالت</h5>
                            <ul>
                                @foreach($transStates as $transState)
                                    <li> <strong>{{ $transState->name }}</strong> :   {{ $transState->desc }}</li>
                                @endforeach
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

@section('js')
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.js"></script>
    <script>
        $(function() {
            $('#active_b_table').DataTable({
                paging:   true,
                ordering: true,
                processing: true,
                serverSide: true,
                language: {
                    url: '/lang/DataTablePER1.txt'
                },
                ajax: {
                    url: '{{ route('transactions.b_table') }}',
                    type: 'POST',
                    'headers': {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: [
                    { data: 'name', name: 'users.name' },
                    { data: 'country', name: 'countries.name' },
                    { data: 'currency', name: 'currencies.name' },
                    { data: 's_amount', name: 'transactions.s_amount' },
                    { data: 'date', name: 'transactions.created_at' },
                    { data: 'transaction_id', name: 'transaction_id' },
                    { data: 'accept', name: 'trans_accepts.name' },
                    { data: 'level', name: 'trans_levels.name' },
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
            $('#s_nav').one('click', function () {
                $('#active_s_table').DataTable({
                    paging:   true,
                    ordering: true,
                    processing: true,
                    serverSide: true,
                    language: {
                        url: '/lang/DataTablePER1.txt'
                    },
                    ajax: {
                        url: '{{ route('transactions.s_table') }}',
                        type: 'POST',
                        'headers': {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    },
                    columns: [
                        { data: 'name', name: 'users.name' },
                        { data: 'country', name: 'countries.name' },
                        { data: 'currency', name: 'currencies.name' },
                        { data: 'b_amount', name: 'transactions.b_amount' },
                        { data: 'date', name: 'transactions.created_at' },
                        { data: 'transaction_id', name: 'transaction_id' },
                        { data: 'accept', name: 'trans_accepts.name' },
                        { data: 'level', name: 'trans_levels.name' },
                        { data: 'action', name: 'action', orderable: false, searchable: false}
                    ]
                });
            })
            $('#f_nav').one('click', function () {
                $('#active_f_table').DataTable({
                    paging:   true,
                    ordering: true,
                    processing: true,
                    serverSide: true,
                    language: {
                        url: '/lang/DataTablePER1.txt'
                    },
                    ajax: {
                        url: '{{ route('transactions.f_table') }}',
                        type: 'POST',
                        'headers': {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    },
                    columns: [
                        { data: 'transaction_id', name: 'transaction_id' },
                        { data: 'buyOrSell', name: 'buyOrSell' },
                        { data: 'currency', name: 'currency' },
                        { data: 'date', name: 'date' },
                        { data: 'accept', name: 'accept' },
                        { data: 'state', name: 'state' },
                        { data: 'action', name: 'action', orderable: false, searchable: false}
                    ]
                });
            })

        });
    </script>
@endsection

