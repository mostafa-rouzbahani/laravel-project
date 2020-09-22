@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
{{--            <div class="col-md-4">--}}
{{--                <div class="card">--}}

{{--                    <div class="header">--}}
{{--                        <h4 class="title">آگهی جدید</h4>--}}
{{--                        <p class="category">برای ایجاد آگهی جدید کلیک کنید.</p>--}}
{{--                    </div>--}}
{{--                    <div class="content" style="text-align: center">--}}
{{--                        <a href="{{ route('advertisement.create') }}" class="create">--}}
{{--                            <img src="{{ asset('img/create.png') }}">--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
            <div class="col-md-4">
                <div class="card text-center" style="box-shadow: none;">
                    <a href="{{ route('advertisement.create') }}">
                        <button type="button"  class="btn btn-success btn-block" data-toggle="modal" data-target="#TicketModal">ارسال آکهی جدید</button>
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card text-center" style="padding: 1%;">
                    <h4>
                    آگهی های ارسال شده توسط شما
                    </h4>
                </div>
            </div>
            @foreach($advertisements as $advertisement)
            <div class="col-md-4">
                <div class="card">
                    <div class="header">
                        <div class="row text-center">
                            <div class="col-sm-6">
                                <a href="advertisement/{{ $advertisement->id }}/edit">
                                    <button type="button" class="btn btn-warning btn-block">
                                        ویرایش
                                    </button>
                                </a>
                            </div>
                            <div class="col-sm-6">
                                <form method="POST" action="{{ url('advertisement/' . $advertisement->id) }}" class="deleteConf">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-block">
                                        حذف
                                    </button>
                                </form>
                            </div>
                        </div>
                        <hr>
                        <h4 class="title">متن آگهی</h4>
                        <p class="category">
                            {{ 'من '.Auth::user()->name.' می توانم در '. $advertisement->p_country->name }}
                            {{ ' از مبلغ '.$advertisement->amount_from.' تا '.$advertisement->amount_to.' ' }}
                            {{ $advertisement->p_currency->name . ' پرداخت کنم. در ازای آن ' }}
                            {{ $advertisement->r_currency->name . ' در کشور ' . $advertisement->r_country->name }}
                            {{ ' دریافت می  کنم.' }}
                        </p>
                    </div>
                    <div class="content" style="text-align: right">
                        <button type="button" style="margin-bottom: 5%" class="btn btn-info btn-block" data-toggle="collapse" data-target="#ad{{ $advertisement->id }}">جزییات</button>
                        <div id="ad{{ $advertisement->id }}" class="content table-responsive table-full-width collapse">
                            <table class="table table-hover table-striped">
                                <thead>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>ارز پرداختی</td>
                                    <td>{{ $advertisement->p_currency->name }}</td>
                                </tr>
                                <tr>
                                    <td>کشور پرداختی</td>
                                    <td>{{ $advertisement->p_country->name }}</td>
                                </tr>
                                <tr>
                                    <td>از مبلغ</td>
                                    <td>{{ $advertisement->amount_from }}</td>
                                </tr>
                                <tr>
                                    <td>تا مبلغ</td>
                                    <td>{{ $advertisement->amount_to }}</td>
                                </tr>
                                <tr>
                                    <td>ارز دریافتی</td>
                                    <td>{{ $advertisement->r_currency->name }}</td>
                                </tr>
                                <tr>
                                    <td>کشور دریافتی</td>
                                    <td>{{ $advertisement->r_country->name }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="footer">
                            <hr>
                            <div class="stats">
                                <i class="fa fa-history"> </i>
                                <span>ایجاد شده:</span>&nbsp;&nbsp;&nbsp;
                                <span style="float: left">{{ $advertisement->created_at }}</span>
                            </div>
                            <div class="stats">
                                <i class="fa fa-refresh"> </i>
                                <span>ویرایش شده:</span>&nbsp;&nbsp;&nbsp;
                                <span style="float: left">{{ $advertisement->updated_at }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function(){
            $(".deleteConf").on("submit", function(){
                return confirm("آیا از حذف این آگهی اطمینان دارید؟");
            });
        });
    </script>
@endsection
