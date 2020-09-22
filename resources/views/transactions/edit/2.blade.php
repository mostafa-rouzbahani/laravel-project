@if( $transaction->s_user_id == Auth::id() )
    @if($transaction->transLevel_id > 2)
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4>
                            سایت پرداخت مبلغ
                            {{ number_format($transaction->b_amount, 2).' '.$transaction->b_currency->name }}
                            توسط
                            {{ $transaction->b_user->name }}
                            را به همراه کارمزد تایید می کند.
                        </h4>
                    </div>
                    <div class="content">
                    </div>
                    <div class="footer"></div>
                </div>
            </div>
        </div>
    @elseif($transaction->transLevel_id == 2)
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4>
                            سایت در حال بررسی پرداخت مبلغ
                            {{ number_format($transaction->b_amount, 2).' '.$transaction->b_currency->name }}
                            به همراه کارمزد توسط
                            {{ $transaction->b_user->name }}
                            می باشد. لطفا صبور باشید.
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
    @if($transaction->transLevel_id > 2)
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4>
                            سایت پرداخت مبلغ
                            {{ number_format($transaction->b_amount, 2).' '.$transaction->b_currency->name }}
                            توسط
                            {{ $transaction->b_user->name }}
                            را به همراه کارمزد تایید می کند.
                        </h4>
                    </div>
                    <div class="content">
                    </div>
                    <div class="footer"></div>
                </div>
            </div>
        </div>
    @elseif($transaction->transLevel_id == 2)
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4>
                            سایت در حال بررسی پرداخت مبلغ
                            {{ number_format($transaction->b_amount, 2).' '.$transaction->b_currency->name }}
                            به همراه کارمزد توسط
                            {{ $transaction->b_user->name }}
                            می باشد. لطفا صبور باشید.
                        </h4>
                    </div>
                    <div class="content">
                    </div>
                    <div class="footer"></div>
                </div>
            </div>
        </div>
    @endif
@endif
