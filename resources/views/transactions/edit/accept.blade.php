@if( $transaction->transAccept_id === 1 && $transaction->s_user_id == Auth::id() )
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <div class="row">
                    <h3 class="col-md-6">پاسخ به درخواست معامله</h3>
                    <h3>
                        <form method="POST" action="{{ route('transactions.update', $transaction->id) }}" class="col-md-3">
                            @method('PATCH')
                            @csrf
                            <input type="hidden" name="transAccept_id" value="reject">
                            <button type="submit" class="btn btn-danger">
                                رد درخواست
                            </button>
                        </form>
                    </h3>
                    <h3>
                        <form method="POST" action="{{ route('transactions.update' ,$transaction->id) }}" class="col-md-3">
                            @method('PATCH')
                            @csrf
                            <input type="hidden" name="transAccept_id" value="accept">
                            <button type="submit" class="btn btn-success">
                                قبول درخواست
                            </button>
                        </form>
                    </h3>
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
                            <td>ارزی که شما باید پرداخت کنید</td>
                            <td>{{ $transaction->s_currency->name }}</td>
                        </tr>
                        <tr>
                            <td>کشوری که در آن باید پرداخت کنید</td>
                            <td>{{ $transaction->s_country->name }}</td>
                        </tr>
                        <tr>
                            <td>مبلغی که توسط شما باید پرداخت شود</td>
                            <td>{{ number_format($transaction->s_amount, 2) }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="footer"></div>
            </div>
        </div>
    </div>
@elseif($transaction->transAccept_id === 1 && $transaction->b_user_id == Auth::id())
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h4>لطفا تا پاسخ دهی فروشنده به درخواست انجام معامله شکیبا باشید.</h4>
                </div>
                <div class="content">
                </div>
                <div class="footer"></div>
            </div>
        </div>
    </div>
@endif
