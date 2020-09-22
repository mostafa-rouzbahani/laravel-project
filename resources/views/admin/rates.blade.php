@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <div class="h3 row text-center">
                            نرخ ارزهای سایت
                        </div>
                    </div>
                    <div class="content">
                        <div class="content table-responsive table-full-width">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>نام ارز</th>
                                        <th>تبدیل به دلار</th>
                                        <th>تاریخ تبدیل به دلار</th>
                                        <th>دلار به ریال</th>
                                        <th>تاریخ دلار به ریال</th>
                                        <th>ارز به ریال</th>
                                        <th>تاریخ ارز به ریال</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($currencies as $currency)
                                    <tr>
                                        <td>{{ $currency->name }}</td>
                                        <td>{{ number_format($currency->usd_rate, 2) }}</td>
                                        <td>{{ $currency->usd_rate_date->format('h:i - Y/m/d') }}</td>
                                        <td>{{ number_format($currency->irr_rate, 2) }}</td>
                                        <td>{{ $currency->irr_rate_date->format('h:i - Y/m/d') }}</td>
                                        <td>{{ number_format($currency->exchange, 2) }}</td>
                                        <td>{{ $currency->exchange_date->format('h:i - Y/m/d') }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="footer">
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="header">
                        <div class="h3 row text-center">
                            تعیین نرخ دلار به ریال
                        </div>
                    </div>
                    <div class="content">
                        <form method="POST"  action="{{ route('admin.rateChange') }}">
                            @csrf
                            <div class="form-group row">
                                <label for="irr_rate" class="col-md-6 col-md-offset-1 col-form-label text-md-right">
                                    نرخ دلار
                                </label>
                                <div class="col-md-4">
                                    <input id="irr_rate" class="form-control @error('irr_rate') is-invalid @enderror" name="irr_rate" value="{{ $currencies->first()->irr_rate }}"  required autocomplete="irr_rate">

                                    @error('irr_rate')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-wd btn-round btn-primary">
                                        تغییر نرخ
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection
