@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <a href="{{ route('admin.transactions') }}">
                    <div class="card text-center">
                        <div class="header">
                            <h4 class="title">معاملات سایت</h4>
                            <p class="category">مشاهده معاملات و ارسال تاییده</p>
                        </div>
                        <div class="content" style="text-align: center">
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('admin.rates') }}">
                    <div class="card text-center">
                        <div class="header">
                            <h4 class="title">نرخ ارز</h4>
                            <p class="category">مشاهده و تنظیمات نرخ ارز</p>
                        </div>
                        <div class="content" style="text-align: center">
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('admin.tickets') }}">
                    <div class="card text-center">
                        <div class="header">
                            <h4 class="title">تیکت ها</h4>
                            <p class="category">پاسخ به مشتریان</p>
                        </div>
                        <div class="content" style="text-align: center">
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('admin.options') }}">
                    <div class="card text-center">
                        <div class="header">
                            <h4 class="title">تنظیمات</h4>
                            <p class="category">تنظیمات سیستم</p>
                        </div>
                        <div class="content" style="text-align: center">
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection
