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
                        <h4 class="title">آگهی های موجود در سایت</h4>
                        <p class="category">برای انجام معامله، آگهی مورد نظر را انتخاب کنید.</p>
                    </div>
                    <div class="content table-responsive table-full-width" style="margin: 0">
                        <table id="ad_table" class="table table-hover table-striped">
                            <thead>
                            <th>کاربر</th>
                            <th>کشور پرداختی</th>
                            <th>ارز پرداختی</th>
                            <th>از مبلغ</th>
                            <th>تا مبلغ</th>
                            <th>کشور دریافتی</th>
                            <th>ارز دریافتی</th>
                            <th></th>
                            </thead>
{{--                            <tbody>--}}
{{--                            @foreach($advertisements as $advertisement)--}}
{{--                                <tr>--}}
{{--                                    <td>{{ $advertisement->user->name }}</td>--}}
{{--                                    <td>{{ $advertisement->p_currency->name }}</td>--}}
{{--                                    <td>{{ $advertisement->p_country->name }}</td>--}}
{{--                                    <td>{{ $advertisement->amount_from }}</td>--}}
{{--                                    <td>{{ $advertisement->amount_to }}</td>--}}
{{--                                    <td>{{ $advertisement->r_currency->name }}</td>--}}
{{--                                    <td>{{ $advertisement->r_country->name }}</td>--}}
{{--                                </tr>--}}
{{--                            @endforeach--}}
{{--                            </tbody>--}}
                        </table>

                    </div>
                </div>
            </div>
    </div>
@endsection

@section('js')
            <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.js"></script>
            <script>
                $(function() {
                    $('#ad_table').DataTable({
                        paging:   true,
                        ordering: true,
                        processing: true,
                        serverSide: true,

                        language: {
                            url: '/lang/DataTablePER.txt'
                        },
                        ajax: {
                            url: '{{ route('advertisement.datatable') }}',
                            type: 'POST',
                            'headers': {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        },
                        columns: [
                            { data: 'name', name: 'users.name' },
                            { data: 'p_country', name: 'c.name' },
                            { data: 'p_currency', name: 'c1.name' },
                            { data: 'amount_from', name: 'amount_from' },
                            { data: 'amount_to', name: 'amount_to' },
                            { data: 'r_country', name: 'countries.name' },
                            { data: 'r_currency', name: 'currencies.name' },
                            { data: 'action', name: 'action', orderable: false, searchable: false}
                        ]
                    });
                });
            </script>
@endsection

