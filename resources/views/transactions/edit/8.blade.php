@if( $transaction->s_user_id == Auth::id() )
    @if($transaction->transLevel_id > 8)
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4>
                            {{ $transaction->s_user->name }}
                            دریافت پول را تایید کرده است.
                        </h4>
                    </div>
                    <div class="content">
                    </div>
                    <div class="footer"></div>
                </div>
            </div>
        </div>
    @elseif($transaction->transLevel_id == 8)
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4>
                            در صورتی که
                            {{ number_format($transaction->b_amount, 2).' '.$transaction->b_currency->name }}
                            توسط سایت
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
                    </div>
                    <div class="footer"></div>
                </div>
            </div>
        </div>
    @endif
@elseif( $transaction->b_user_id == Auth::id())
    @if($transaction->transLevel_id > 8)
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4>
                            {{ $transaction->s_user->name }}
                            دریافت پول را تایید کرده است.
                        </h4>
                    </div>
                    <div class="content">
                    </div>
                    <div class="footer"></div>
                </div>
            </div>
        </div>
    @elseif($transaction->transLevel_id == 8)
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4>
                            {{ $transaction->s_user->name }}
                            در حال تایید دریافت پول می باشد.
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
