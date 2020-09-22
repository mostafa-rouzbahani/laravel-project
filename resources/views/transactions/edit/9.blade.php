@if( $transaction->s_user_id == Auth::id() )
    @if($transaction->transLevel_id >= 9)
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4>
                            {{ $transaction->transState->desc }}
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
    @if($transaction->transLevel_id >= 9)
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4>
                            {{ $transaction->transState->desc }}
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
