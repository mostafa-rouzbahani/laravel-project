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
                        <h4 class="title text-center">معاملات سایت</h4>
                        <hr>
                        <ul class="nav nav-tabs nav-justified">
                            <li class="active"><a data-toggle="tab" href="#verify">تاییدیه</a></li>
                            <li><a id="active_trans_nav" data-toggle="tab" href="#active_trans">در حال انجام</a></li>
                            <li><a id="finish_nav" data-toggle="tab" href="#finish">پایان یافته</a></li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div id="verify" class="tab-pane fade in active">
                            <div class="content table-responsive table-full-width" style="margin: 0">
                                <table id="verify_table" class="table table-hover table-striped">
                                    <thead>
                                    <th>کد رهگیری</th>
                                    <th>مبلغ</th>
                                    <th>خریدار</th>
                                    <th>فروشنده</th>
                                    <th>تاریخ</th>
                                    <th>وضعیت</th>
                                    <th>حالت</th>
                                    <th>مرحله</th>
                                    <th>شماره مرحله</th>
                                    <th>ارسال تاییدیه</th>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div id="active_trans" class="tab-pane fade">
                            <div class="content table-responsive table-full-width" style="margin: 0">
                                <table id="active_table" class="table table-hover table-striped">
                                    <thead>
                                    <th>کد رهگیری</th>
                                    <th>مبلغ</th>
                                    <th>خریدار</th>
                                    <th>فروشنده</th>
                                    <th>تاریخ</th>
                                    <th>وضعیت</th>
                                    <th>حالت</th>
                                    <th>مرحله</th>
                                    <th>شماره مرحله</th>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div id="finish" class="tab-pane fade">
                            <div class="content table-responsive table-full-width" style="margin: 0">
                                <table id="finish_table" class="table table-hover table-striped">
                                    <thead>
                                    <th>کد رهگیری</th>
                                    <th>مبلغ</th>
                                    <th>خریدار</th>
                                    <th>فروشنده</th>
                                    <th>تاریخ</th>
                                    <th>وضعیت</th>
                                    <th>حالت</th>
                                    <th>مرحله</th>
                                    <th>شماره مرحله</th>
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
            $('#verify_table').DataTable({
                paging:   true,
                ordering: true,
                processing: true,
                serverSide: true,
                language: {
                    url: '/lang/DataTablePER1.txt'
                },
                ajax: {
                    url: '{{ route('admin.verify_table') }}',
                    type: 'POST',
                    'headers': {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: [
                    { data: 'transaction_id', name: 'transaction_id' },
                    { data: 'b_amount', name: 'transactions.b_amount' },
                    { data: 'buyer', name: 'buyer.name' },
                    { data: 'seller', name: 'seller.name' },
                    { data: 'date', name: 'transactions.created_at' },
                    { data: 'accept', name: 'trans_accepts.name' },
                    { data: 'state', name: 'trans_levels.name' },
                    { data: 'level', name: 'trans_levels.name' },
                    { data: 'transLevel_id', name: 'transLevel_id' },
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
            $('#active_trans_nav').one('click', function () {
                $('#active_table').DataTable({
                    paging:   true,
                    ordering: true,
                    processing: true,
                    serverSide: true,
                    language: {
                        url: '/lang/DataTablePER1.txt'
                    },
                    ajax: {
                        url: '{{ route('admin.active_table') }}',
                        type: 'POST',
                        'headers': {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    },
                    columns: [
                        { data: 'transaction_id', name: 'transaction_id' },
                        { data: 'b_amount', name: 'transactions.b_amount' },
                        { data: 'buyer', name: 'buyer.name' },
                        { data: 'seller', name: 'seller.name' },
                        { data: 'date', name: 'transactions.created_at' },
                        { data: 'accept', name: 'trans_accepts.name' },
                        { data: 'state', name: 'trans_levels.name' },
                        { data: 'level', name: 'trans_levels.name' },
                        { data: 'transLevel_id', name: 'transLevel_id' }
                    ]
                });
            })
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
                        url: '{{ route('admin.finish_table') }}',
                        type: 'POST',
                        'headers': {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    },
                    columns: [
                        { data: 'transaction_id', name: 'transaction_id' },
                        { data: 'b_amount', name: 'transactions.b_amount' },
                        { data: 'buyer', name: 'buyer.name' },
                        { data: 'seller', name: 'seller.name' },
                        { data: 'date', name: 'transactions.created_at' },
                        { data: 'accept', name: 'trans_accepts.name' },
                        { data: 'state', name: 'trans_levels.name' },
                        { data: 'level', name: 'trans_levels.name' },
                        { data: 'transLevel_id', name: 'transLevel_id' }
                    ]
                });
            })

        });
    </script>
@endsection

