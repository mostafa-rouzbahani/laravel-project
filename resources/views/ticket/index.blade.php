@extends('layouts.app')

@section('css')
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="container-fluid">
         <div class="row">
             <div class="col-md-4">
                 <div class="card text-center" style="box-shadow: none;">

                         <button type="button"  class="btn btn-info btn-block" data-toggle="modal" data-target="#TicketModal">ارسال تیکت جدید</button>

                 </div>
             </div>
         </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4 class="title">تیکت های باز شده توسط شما
                        </h4>
                    </div>
                    <div class="content table-responsive table-full-width" style="margin: 0">
                        <table id="ticket_table" class="table table-hover table-striped">
                            <thead>
                            <th>شناسه</th>
                            <th>عنوان</th>
                            <th>وضعیت</th>
                            <th>تاریخ</th>
                            <th></th>
                            </thead>
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
                    $('#ticket_table').DataTable({
                        paging:   true,
                        ordering: true,
                        processing: true,
                        serverSide: true,

                        language: {
                            url: '/lang/DataTablePER2.txt'
                        },
                        ajax: {
                            url: '{{ route('tickets.datatable') }}',
                            type: 'POST',
                            'headers': {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        },
                        columns: [
                            { data: 'ticket_id', name: 'ticket_id' },
                            { data: 'title', name: 'title' },
                            { data: 'status', name: 'status' },
                            { data: 'created_at', name: 'created_at' },
                            { data: 'action', name: 'action', orderable: false, searchable: false}
                        ]
                    });
                });
            </script>
@endsection

@section('modal')
        <!-- Modal -->
            <div id="TicketModal" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content" style="direction: rtl;">
                        <div class="modal-header">
                            <button type="button" class="close" style="float: left" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">تیکت جدید</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <form method="POST" action="{{ route('tickets.store')  }}">
                                        @csrf
                                        <div class="form-group row">
                                            <label for="title" class="col-md-3 col-form-label text-md-right">
                                                عنوان
                                            </label>

                                            <div class="col-md-9">
                                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title">

                                                @error('title')
                                                <span class="invalid-feedback text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="message" class="col-md-3 col-form-label text-md-right">
                                                پیام
                                            </label>

                                            <div class="col-md-9">
                                                <textarea id="message"  rows="4" cols="5" class="form-control @error('message') is-invalid @enderror" name="message" required autocomplete="message"></textarea>
                                                @error('message')
                                                <span class="invalid-feedback text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-success" style="float: left">
                                            ثبت تیکت
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
@endsection

