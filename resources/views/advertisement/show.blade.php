@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-6">
                <div class="card">
                    <div class="header">
                        <div class="h3 row text-center">
                            مشخصات فروشنده
                        </div>
                    </div>
                    <div class="content" style="text-align: right">
                        <div class="content table-responsive table-full-width">
                            <table class="table table-hover table-striped">
                                <thead>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>نام کاربری</td>
                                    <td>{{ $advertisement->user->name }}</td>
                                </tr>
                                <tr>
                                    <td>تاریخ عضویت در سایت</td>
                                    <td>{{ $advertisement->user->created_at->format('Y-m-d') }}</td>
                                </tr>
                                <tr>
                                    <td>تعداد کل معاملات </td>
                                    <td>{{ $advertisement->user->s_transactions_accept->count() }}</td>
                                </tr>
                                <tr>
                                    <td> معاملات
                                        @foreach($transStates as $transState)
                                            <span class="@if($transState->id == 1) text-primary @elseif($transState->id == 2) text-success @elseif($transState->id == 3) text-danger @else() text-warning @endif ">
                                               / {{ $transState->name }}
                                            </span>
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach($transStates as $transState)
                                            <span class="@if($transState->id == 1) text-primary @elseif($transState->id == 2) text-success @elseif($transState->id == 3) text-danger @else() text-warning @endif ">
                                                / {{ $advertisement->user->s_transactions->where('transState_id', $transState->id)->count() }}
                                            </span>
                                        @endforeach
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="footer">
                            <hr>
                            <div class="legend">
                                @foreach($transStates as $transState)
                                    <i class="fa fa-circle @if($transState->id == 1) text-primary @elseif($transState->id == 2) text-success @elseif($transState->id == 3) text-danger @else() text-warning @endif "></i>
                                        {{ $transState->desc }}
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="header">
                        <div class="h3 row text-center">
                            مشخصات آگهی
                        </div>
                    </div>
                    <div class="content" style="text-align: center">
                        <div class="content table-responsive table-full-width">
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
                            <div class="stats" style="margin-left: 10px">
                                <i class="fa fa-history"> </i>
                                <span>ایجاد شده:</span>&nbsp;&nbsp;&nbsp;
                                <span style="float: left">{{ $advertisement->created_at->format('Y/m/d') }}</span>
                            </div>
                            <div class="stats">
                                <i class="fa fa-refresh"> </i>
                                <span>ویرایش شده:</span>&nbsp;&nbsp;&nbsp;
                                <span style="float: left">{{ $advertisement->updated_at->format('Y/m/d') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @if( Auth::user()->id != $advertisement->user->id )
                    <div class="card">
                    <div class="header">
                        <div class="h3 row text-center">
                             خرید
                        </div>
                    </div>
                    <div class="content">
                        <form method="POST" class="subConf" action="{{ route('transactions.store') }}">
                            @csrf
                            <input type="hidden" name="advertisement_id" value="{{ $advertisement->id }}">
                            <div class="form-group row">
                                <label for="s_amount" class="col-md-6 col-md-offset-1 col-form-label text-md-right">
                                    چه میزان
                                    {{ $advertisement->p_currency->name }}
                                    می خواهید؟
                                    <span id="arz" style="color: blue; font-size: 10px;"></span>
                                </label>
                                <div class="col-md-4">
                                    <input id="s_amount" class="form-control @error('s_amount') is-invalid @enderror" name="s_amount" value="{{ $advertisement->amount_from }}"  required autocomplete="s_amount">

                                    @error('s_amount')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="b_amount" class="col-md-6 col-md-offset-1 col-form-label text-md-right">
                                    معادل
                                    {{ $advertisement->r_currency->name }}
                                    آن می شود:
                                    (گرد شده به بالا)
                                    <span id="rial" style="color: blue; font-size: 10px;"></span>
                                </label>
                                <div class="col-md-4">
                                    <input id="b_amount"  class="form-control @error('b_amount') is-invalid @enderror" name="b_amount" value="{{ old('b_amount') }}" required autocomplete="b_amount" readonly>

                                    @error('b_amount')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="wage" class="col-md-6 col-md-offset-1 col-form-label text-md-right">
                                    نرخ کارمزد به ریال ایران
                                </label>
                                <div class="col-md-4">
                                    <input id="wage" class="form-control @error('wage') is-invalid @enderror" name="wage" value="{{ number_format($wage->value,0) }}" required autocomplete="wage" readonly>

                                    @error('wage')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="exchange" style="color: green" class="col-md-3 col-md-offset-1 col-form-label text-md-right">
                                    نرخ تبدیل =
                                </label>
                                <label for="exchange" style="color: blue" class="col-md-3  col-form-label text-md-right">
                                    {{ $advertisement->p_currency->name }}
                                    به دلار *
                                </label>
                                <label for="exchange" style="color: black" class="col-md-3  col-form-label text-md-right">
                                    دلار به
                                    {{ $advertisement->r_currency->name }}
                                </label>
                                <label for="exchange" style="color: green" class="col-md-3 col-md-offset-1 col-form-label text-md-right">
                                    {{ number_format($rates->exchange, 2) }} =
                                </label>
                                <label for="exchange" style="color: blue" class="col-md-3  col-form-label text-md-right">
                                    {{ number_format(1/$rates->usd_rate, 2) }} *
                                </label>
                                <label for="exchange" style="color: black" class="col-md-3  col-form-label text-md-right">
                                    {{ number_format($rates->irr_rate, 2) }}
                                </label>
                                <input type="hidden"  id="exchange"  name="exchange" value="{{ $rates->exchange }}">
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-wd btn-round btn-primary">
                                        ارسال درخواست معامله
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @endif
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="header">
                        <div class="h3 row text-center">
                            شرایط فروشنده
                        </div>
                    </div>
                    <div class="content" style="text-align: center">
                        <p> به زودی</p>
                    </div>
                </div>
                <div class="card">
                    <div class="header">
                        <div class="h3 row text-center">
                            نکات مهم
                        </div>
                    </div>
                    <div class="content" style="text-align: center">
                        <p> به زودی</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('js/num2persian-min.js') }}" defer></script>
    <script>
        $(document).ready(function(){
            $(".subConf").on("submit", function(){
                return confirm("آیا از ارسال درخواست اطمینان دارید؟");
            });
        });
        $('#s_amount').change(function(e){
            if (parseFloat($('#s_amount').val()) <= {{ $advertisement->amount_from }} || !$.isNumeric($('#s_amount').val()))
                $(this).val({{ $advertisement->amount_from }});
            if (parseFloat($('#s_amount').val()) > {{ $advertisement->amount_to }})
                $(this).val({{ $advertisement->amount_to }});
            $("#b_amount").val(Math.ceil({{ $rates->exchange }} * parseFloat($('#s_amount').val())));
            $("#arz").text(Num2persian($('#s_amount').val()));
            $("#rial").text(Num2persian($('#b_amount').val()));
        }).change();
    </script>
@endsection
