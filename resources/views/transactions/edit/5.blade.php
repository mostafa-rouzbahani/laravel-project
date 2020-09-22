@if( $transaction->s_user_id == Auth::id() )
    @if($transaction->transLevel_id > 5)
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4>
                            {{ $transaction->b_user->name }}
                            دریافت پول را تایید کرده است.
                        </h4>
                    </div>
                    <div class="content">
                    </div>
                    <div class="footer"></div>
                </div>
            </div>
        </div>
    @elseif($transaction->transLevel_id == 5)
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4>
                            لطفا تا تایید دریافت پول توسط
                            {{ $transaction->b_user->name }}،
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
    @if($transaction->transLevel_id > 5)
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4>
                            {{ $transaction->b_user->name }}
                            دریافت پول را تایید کرده است.
                        </h4>
                    </div>
                    <div class="content">
                    </div>
                    <div class="footer"></div>
                </div>
            </div>
        </div>
    @elseif($transaction->transLevel_id == 5)
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4>
                            در صورتی که
                            {{ number_format($transaction->s_amount, 2).' '.$transaction->s_currency->name }}
                            توسط
                            {{ $transaction->s_user->name }}
                            به حساب معرفی شده توسط شما واریز شده است، با فشردن دکمه زیر آن را تایید نمایید.
                        </h4>
                        <div class="row">
                            <form method="POST" action="{{ route('transactions.update', $transaction->id) }}" class="col-md-3">
                                @method('PATCH')
                                @csrf
                                <button type="submit" class="btn btn-success">
                                    تایید دریافت پول
                                </button>
                            </form>
                        </div>
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
