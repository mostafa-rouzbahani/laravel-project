@extends('layouts.app')

@section('css')

@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <div class="row">
                            <div class="col-md-2 text-center">
                                کد رهگیری:
                                {{ $transaction->transaction_id }}
                            </div>
                            <div class="col-md-2 text-center">
                                شماره آگهی:
                                @isset($transaction->advertisement_id){{ $transaction->advertisement_id }}@endisset
                            </div>
                            <div class="col-md-2 text-center">
                                وضعیت معامله:
                                @isset($transaction->transAccept_id){{ $transaction->transAccept->name }}@endisset
                            </div>
                            <div class="col-md-2 text-center">
                                حالت معامله:
                                @isset($transaction->transState_id){{ $transaction->transState->name }}@endisset
                            </div>
                            <div class="col-md-2 text-center">
                                مرحله معامله:
                                @isset($transaction->transLevel_id){{ $transaction->transLevel->id.' - '.$transaction->transLevel->name }}@endisset
                            </div>
                            <div class="col-md-2 text-center">
                                درخواست لغو معامله:
                                {{ $transaction->cancel_flag }}
                            </div>
                        </div>
                        <div class="row" style="margin-top: 3%;">
                            <div class="col-md-2 text-center">
                                تاریخ ایجاد معامله:
                                @isset($transaction->created_at){{ $transaction->created_at->format('Y-m-d') }}@endisset
                            </div>
                            <div class="col-md-2 text-center">
                                تاریخ آخرین ویرایش:
                                @isset($transaction->updated_at){{ $transaction->updated_at->format('Y-m-d') }}@endisset
                            </div>
                            <div class="col-md-2 text-center">
                                تاریخ وضعیت معامله:
                                @isset($transaction->transAccept_date){{ $transaction->transAccept_date->format('Y-m-d') }}@endisset
                            </div>
                            <div class="col-md-2 text-center"></div>
                            <div class="col-md-2 text-center"></div>
                            <div class="col-md-2 text-center">
                                تاریخ درخواست لغو:
                                @isset($transaction->cancel_flag_date){{ $transaction->cancel_flag_date->format('Y-m-d') }}@endisset
                            </div>
                        </div>
                        <div class="row" style="margin-top: 3%;">
                            <div class="col-md-2 text-center">
                                نرخ تبدیل:
                                @isset($transaction->exchange){{ number_format($transaction->exchange, 2) }}@endisset
                            </div>
                            <div class="col-md-2 text-center"></div>
                            <div class="col-md-2 text-center"></div>
                            <div class="col-md-2 text-center"></div>
                            <div class="col-md-2 text-center"></div>
                            <div class="col-md-2 text-center"></div>
                        </div>
                        <hr>
                    </div>
                    <div class="content" style="text-align: right">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="content table-responsive table-full-width">
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
                                                <td>کارمزد</td>
                                                <td>{{ number_format($transaction->wage, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <td>نام بانک</td>
                                                <td>@isset($transaction->b_bank_name){{ $transaction->b_bank_name }}@endisset</td>
                                            </tr>
                                            <tr>
                                                <td>شماره حساب</td>
                                                <td>@isset($transaction->b_account_number){{ $transaction->b_account_number }}@endisset</td>
                                            </tr>
                                            <tr>
                                                <td>نام صاحب حساب</td>
                                                <td>@isset($transaction->b_account_name){{ $transaction->b_account_name }}@endisset</td>
                                            </tr>
                                            <tr>
                                                <td>توضیحات</td>
                                                <td>@isset($transaction->b_description){{ $transaction->b_description }}@endisset</td>
                                            </tr>
                                            <tr>
                                                <td>تاییدیه ارسال پول به سایت</td>
                                                <td style="color: green">@isset($transaction->admin_money_flag)دارد @endisset</td>
                                            </tr>
                                            <tr>
                                                <td>تاریخ ارسال پول به سایت</td>
                                                <td>@isset($transaction->admin_money_date){{ $transaction->admin_money_date->format('Y-m-d') }}@endisset</td>
                                            </tr>
                                            <tr>
                                                <td>تاییدیه دریافت پول</td>
                                                <td style="color: green">@isset($transaction->b_money_flag)دارد@endisset</td>
                                            </tr>
                                            <tr>
                                                <td>تاریخ دریافت پول</td>
                                                <td>@isset($transaction->b_money_date){{ $transaction->b_money_date->format('Y-m-d') }}@endisset</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="footer"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="content table-responsive table-full-width">
                                    <table class="table table-hover table-striped">
                                        <thead>
                                        </thead>
                                        <tbody>
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
                                        <tr>
                                            <td>نام بانک</td>
                                            <td>@isset($transaction->s_bank_name){{ $transaction->s_bank_name }}@endisset</td>
                                        </tr>
                                        <tr>
                                            <td>شماره حساب</td>
                                            <td>@isset($transaction->s_account_number){{ $transaction->s_account_number }}@endisset</td>
                                        </tr>
                                        <tr>
                                            <td>نام صاحب حساب</td>
                                            <td>@isset($transaction->s_account_name){{ $transaction->s_account_name }}@endisset</td>
                                        </tr>
                                        <tr>
                                            <td>توضیحات</td>
                                            <td>@isset($transaction->s_description){{ $transaction->s_description }}@endisset</td>
                                        </tr>
                                        <tr>
                                            <td>تاییدیه دریافت پول</td>
                                            <td style="color: green">@isset($transaction->s_money_flag)دارد@endisset</td>
                                        </tr>
                                        <tr>
                                            <td>تاریخ دریافت پول</td>
                                            <td>@isset($transaction->s_money_date) {{ $transaction->s_money_date->format('Y-m-d') }} @endisset</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="footer"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection

