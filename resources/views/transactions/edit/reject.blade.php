@if( $transaction->transAccept_id === 2)
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <div class="row">
                    <h3 class="col-md-6" style="color: red">این درخواست رد شده است.</h3>
                    </div>
                </div>
                <div class="content">
                    <table class="table table-hover table-striped">
                        <thead>
                        </thead>
                        <tbody>
                        <tr>
                            <td>خریدار</td>
                            <td>{{ $transaction->b_user->name }}</td>
                        </tr>
                        <tr>
                            <td>ارز پرداختی توسط خریدار</td>
                            <td>{{ $transaction->b_currency->name }}</td>
                        </tr>
                        <tr>
                            <td>کشور پرداختی توسط خریدار</td>
                            <td>{{ $transaction->b_country->name }}</td>
                        </tr>
                        <tr>
                            <td>مبلغ پرداختی توسط خریدار</td>
                            <td>{{ number_format($transaction->b_amount, 2) }}</td>
                        </tr>
                        <tr>
                            <td>فروشنده</td>
                            <td>{{ $transaction->s_user->name }}</td>
                        </tr>
                        <tr>
                            <td>ارز پرداختی توسط فروشنده</td>
                            <td>{{ $transaction->s_currency->name }}</td>
                        </tr>
                        <tr>
                            <td>کشور پرداختی توسط فروشنده</td>
                            <td>{{ $transaction->s_country->name }}</td>
                        </tr>
                        <tr>
                            <td>مبلغ پرداختی توسط فروشنده</td>
                            <td>{{ number_format($transaction->s_amount, 2) }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="footer"></div>
            </div>
        </div>
    </div>
@endif
