@if( $transaction->s_user_id == Auth::id() )
    @if($transaction->transLevel_id > 7)
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4>
                            مبلغ
                            {{ number_format($transaction->b_amount, 2).' '.$transaction->b_currency->name }}
                            برای
                            {{ $transaction->s_user->name }}
                            ارسال شد.
                        </h4>
                    </div>
                    <div class="content">
                    </div>
                    <div class="footer"></div>
                </div>
            </div>
        </div>
    @elseif($transaction->transLevel_id == 7)
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4>
                            سایت در حال ارسال  مبلغ
                            {{ number_format($transaction->b_amount, 2).' '.$transaction->b_currency->name }}
                            به
                            {{ $transaction->s_user->name }}
                            می باشد.
                        </h4>
                    </div>
                    <div class="content">
                        <div class="row">
                            <table class="table table-hover table-striped">
                                <thead>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>نام بانک</td>
                                    <td>{{ $transaction->s_bank_name }}</td>
                                </tr>
                                <tr>
                                    <td>شماره حساب</td>
                                    <td>{{ $transaction->s_account_number }}</td>
                                </tr>
                                <tr>
                                    <td>نام صاحب حساب</td>
                                    <td>{{ $transaction->s_account_name }}</td>
                                </tr>
                                @isset($transaction->s_description)
                                    <tr>
                                        <td>توضیحات</td>
                                        <td>{{ $transaction->s_description }}</td>
                                    </tr>
                                @endisset
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="footer"></div>
                </div>
            </div>
        </div>
    @endif
@elseif( $transaction->b_user_id == Auth::id())
    @if($transaction->transLevel_id > 7)
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4>
                            مبلغ
                            {{ number_format($transaction->b_amount, 2).' '.$transaction->b_currency->name }}
                            برای
                            {{ $transaction->s_user->name }}
                            ارسال شد.
                        </h4>
                    </div>
                    <div class="content">
                    </div>
                    <div class="footer"></div>
                </div>
            </div>
        </div>
    @elseif($transaction->transLevel_id == 7)
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4>
                            سایت در حال ارسال  مبلغ
                            {{ number_format($transaction->b_amount, 2).' '.$transaction->b_currency->name }}
                            به
                            {{ $transaction->s_user->name }}
                            می باشد.
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
