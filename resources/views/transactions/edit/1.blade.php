@if( $transaction->s_user_id == Auth::id() )
    @if($transaction->transLevel_id > 1)
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4>
                            {{ $transaction->b_user->name }}
                            پرداخت پول را تایید کرده است.
                        </h4>
                    </div>
                    <div class="content">
                    </div>
                    <div class="footer"></div>
                </div>
            </div>
        </div>
    @elseif($transaction->transLevel_id == 1)
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4>
                            لطفا تا پرداخت پول توسط
                            {{ $transaction->b_user->name }}
                            شکیبا باشید.
                        </h4>
                    </div>
                    <div class="content">
                    </div>
                    <div class="footer"></div>
                </div>
            </div>
        </div>
    @endif
@elseif( $transaction->b_user_id == Auth::id())
    @if($transaction->transLevel_id > 1)
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4>
                            {{ $transaction->b_user->name }}
                             تایید کرده است  که مبلغ
                            {{ number_format($transaction->b_amount, 2).' '.$transaction->b_currency->name }}
                            به همراه کارمزد پرداخت کرده است.
                        </h4>
                    </div>
                    <div class="content">
                    </div>
                    <div class="footer"></div>
                </div>
            </div>
        </div>
    @elseif($transaction->transLevel_id == 1)
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4>
                            لطفا فیش زیر را پرداخت نمایید. بعد از واریز با فشردن دکمه زیر، سایت را مطلع کنید.
                        </h4>
                    </div>
                    <div class="content">
                        <div class="row">
                            <form method="POST" action="{{ route('transactions.update', $transaction->id) }}" class="col-md-3">
                                @method('PATCH')
                                @csrf
                                <button type="submit" class="btn btn-success">
                                    تایید پرداخت پول
                                </button>
                            </form>
                        </div>
                        <div class="row" style="padding: 5%;">
                            <div class="col-md-6">
                                <table class="table table-hover table-striped">
                                    <thead>
                                    </thead>
                                    <tbody>
                                    @foreach( $options as $option )
                                        <tr>
                                            <td>{{ $option->name }}</td>
                                            <td>{{ $option->value }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6" style="border-width: 1px; border-style: solid; padding: 1% 5% 1% 5%;">
                                <div class="row">
                                    قیمت تبدیل ارز
                                    <span style="float: left;">{{ number_format($transaction->b_amount, 2).' '.$transaction->b_currency->name }}</span>
                                </div>
                                <div class="row">
                                    + کارمزد
                                    <span style="float: left;">{{ number_format($transaction->wage, 2).' '.$transaction->b_currency->name }}</span>
                                </div>
                                <hr>
                                <div class="row">
                                    مبلغ پرداختی
                                    <span style="float: left;color: green;">{{ number_format($transaction->b_amount + $transaction->wage, 2).' '.$transaction->b_currency->name }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endif
