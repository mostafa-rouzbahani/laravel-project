<div class="card">
    <div class="panel-heading">
        <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#details">
                <i class="pe-7s-angle-left-circle"></i>
            جزییات معامله
            </a>
        </h4>
    </div>
    <div id="details" class="content collapse ">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-hover table-striped">
                    <thead>
                    </thead>
                    <tbody>
                    <tr>
                        <td>کد رهگیری</td>
                        <td>{{ $transaction->transaction_id }}</td>
                    </tr>
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
                        <td>کارمزد معامله</td>
                        <td>{{ number_format($transaction->wage, 2) }}</td>
                    </tr>
                    @isset($transaction->b_bank_name)
                        <tr>
                            <td>نام بانک</td>
                            <td>{{ $transaction->b_bank_name }}</td>
                        </tr>
                    @endisset
                    @isset($transaction->b_account_number)
                        <tr>
                            <td>شماره حساب</td>
                            <td>{{ $transaction->b_account_number }}</td>
                        </tr>
                    @endisset
                    @isset($transaction->b_account_name)
                        <tr>
                            <td>نام صاحب حساب</td>
                            <td>{{ $transaction->b_account_name }}</td>
                        </tr>
                    @endisset
                    @isset($transaction->b_description)
                        <tr>
                            <td>توضیحات</td>
                            <td>{{ $transaction->b_description }}</td>
                        </tr>
                    @endisset
                    @isset($transaction->admin_money_flag)
                        <tr>
                            <td>تاییدیه ارسال پول به سایت</td>
                            <td style="color: green">دارد</td>
                        </tr>
                    @endisset
                    @isset($transaction->admin_money_date)
                        <tr>
                            <td>تاریخ ارسال پول به سایت</td>
                            <td>{{ $transaction->admin_money_date->format('Y-m-d') }}</td>
                        </tr>
                    @endisset
                    @isset($transaction->b_money_flag)
                        <tr>
                            <td>تاییدیه دریافت پول</td>
                            <td style="color: green">دارد</td>
                        </tr>
                    @endisset
                    @isset($transaction->b_money_date)
                        <tr>
                            <td>تاریخ دریافت پول</td>
                            <td>{{ $transaction->b_money_date->format('Y-m-d') }}</td>
                        </tr>
                    @endisset
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-hover table-striped">
                    <thead>
                    </thead>
                    <tbody>
                    <tr>
                        <td>حالت معامله</td>
                        <td>{{ $transaction->transState->name }}</td>
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
                    @isset($transaction->s_money_flag)
                        <tr>
                            <td>تاییدیه دریافت پول</td>
                            <td style="color: green">دارد</td>
                        </tr>
                    @endisset
                    @isset($transaction->s_money_date)
                        <tr>
                            <td>تاریخ دریافت پول</td>
                            <td>{{ $transaction->s_money_date->format('Y-m-d') }}</td>
                        </tr>
                    @endisset
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

