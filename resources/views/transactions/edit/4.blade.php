@if( $transaction->s_user_id == Auth::id() )
    @if($transaction->transLevel_id > 4)
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4>
                            {{ $transaction->s_user->name }}
                            تایید کرده است  که مبلغ
                            {{ number_format($transaction->s_amount, 2).' '.$transaction->s_currency->name }}
                            به حساب زیر واریز کرده است.
                        </h4>
                    </div>
                    <div class="content">
                        <table class="table table-hover table-striped">
                            <thead>
                            </thead>
                            <tbody>
                            <tr>
                                <td>نام بانک</td>
                                <td>{{ $transaction->b_bank_name }}</td>
                            </tr>
                            <tr>
                                <td>شماره حساب</td>
                                <td>{{ $transaction->b_account_number }}</td>
                            </tr>
                            <tr>
                                <td>نام صاحب حساب</td>
                                <td>{{ $transaction->b_account_name }}</td>
                            </tr>
                            @isset($transaction->b_description)
                                <tr>
                                    <td>توضیحات</td>
                                    <td>{{ $transaction->b_description }}</td>
                                </tr>
                            @endisset
                            </tbody>
                        </table>
                    </div>
                    <div class="footer"></div>
                </div>
            </div>
        </div>
    @elseif($transaction->transLevel_id == 4)
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4>
                            {{ $transaction->s_user->name }}،
                            لطفا مبلغ
                            {{ number_format($transaction->s_amount, 2).' '.$transaction->s_currency->name }}
                            به حساب زیر واریز نمایید.
                            بعد از واریز با فشردن دکمه زیر،
                            {{ $transaction->b_user->name }}
                            را مطلع کنید.
                        </h4>
                        <div class="row">
                            <form method="POST" action="{{ route('transactions.update', $transaction->id) }}" class="col-md-3">
                                @method('PATCH')
                                @csrf
                                <button type="submit" class="btn btn-success">
                                    تایید پرداخت پول
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="content">
                        <div class="row">
                            <table class="table table-hover table-striped">
                                <thead>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>نام بانک</td>
                                    <td>{{ $transaction->b_bank_name }}</td>
                                </tr>
                                <tr>
                                    <td>شماره حساب</td>
                                    <td>{{ $transaction->b_account_number }}</td>
                                </tr>
                                <tr>
                                    <td>نام صاحب حساب</td>
                                    <td>{{ $transaction->b_account_name }}</td>
                                </tr>
                                @isset($transaction->b_description)
                                    <tr>
                                        <td>توضیحات</td>
                                        <td>{{ $transaction->b_description }}</td>
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
    @if($transaction->transLevel_id > 4)
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4>
                            {{ $transaction->s_user->name }}
                            تایید کرده است  که مبلغ
                            {{ number_format($transaction->s_amount, 2).' '.$transaction->s_currency->name }}
                            به حساب زیر واریز کرده است.
                        </h4>
                    </div>
                    <div class="content">
                        <table class="table table-hover table-striped">
                            <thead>
                            </thead>
                            <tbody>
                            <tr>
                                <td>نام بانک</td>
                                <td>{{ $transaction->b_bank_name }}</td>
                            </tr>
                            <tr>
                                <td>شماره حساب</td>
                                <td>{{ $transaction->b_account_number }}</td>
                            </tr>
                            <tr>
                                <td>نام صاحب حساب</td>
                                <td>{{ $transaction->b_account_name }}</td>
                            </tr>
                            @isset($transaction->b_description)
                                <tr>
                                    <td>توضیحات</td>
                                    <td>{{ $transaction->b_description }}</td>
                                </tr>
                            @endisset
                            </tbody>
                        </table>
                    </div>
                    <div class="footer"></div>
                </div>
            </div>
        </div>
    @elseif($transaction->transLevel_id == 4)
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4>
                            لطفا تا پرداخت پول توسط
                            {{ $transaction->s_user->name }}،
                            شکیبا باشید.
                        </h4>
                    </div>
                    <div class="content">
                        <div class="row">
                        </div>
                    </div>
                    <div class="footer"></div>
                </div>
            </div>
        </div>
    @endif
@endif
