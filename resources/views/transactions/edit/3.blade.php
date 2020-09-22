@if( $transaction->s_user_id == Auth::id() )
    @if($transaction->transLevel_id > 3)
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4>
                            اطلاعات بانکی
                            {{ $transaction->b_user->name }}
                            مربوط به کشور
                            {{ $transaction->s_country->name }}.
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
                            <tr>
                                <td>توضیحات</td>
                                <td>{{ $transaction->b_description }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="footer"></div>
                </div>
            </div>
        </div>
    @elseif($transaction->transLevel_id == 3)
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4>
                            در حال دریافت اطلاعات بانکی
                            {{ $transaction->b_user->name }}.
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
    @if($transaction->transLevel_id > 3)
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4>
                            اطلاعات بانکی
                            {{ $transaction->b_user->name }}
                            مربوط به کشور
                            {{ $transaction->s_country->name }}.
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
    @elseif($transaction->transLevel_id == 3)
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4>
                            لطفا اطلاعات بانکی مربوط به کشور
                            {{ $transaction->s_country->name }}
                             را با دقت وارد نمایید.
                        </h4>
                    </div>
                    <div class="content">
                        <div class="row">
                            <form method="POST" action="{{ route('transactions.update', $transaction->id) }}" class="col-md-12">
                                @method('PATCH')
                                @csrf
                                <div class="col-md-4 col-md-offset-1">
                                    <div class="form-group row">
                                        <label for="b_bank_name" class="col-md-8 col-form-label text-md-right">
                                            نام بانک
                                        </label>

                                        <div class="col-md-12">
                                            <input id="b_bank_name" type="text" maxlength="30" class="form-control @error('b_bank_name') is-invalid @enderror" name="b_bank_name" value="{{ old('b_bank_name') }}" required autocomplete="b_bank_name">

                                            @error('b_bank_name')
                                            <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="b_account_number" class="col-md-8 col-form-label text-md-right">
                                            شماره حساب
                                        </label>

                                        <div class="col-md-12">
                                            <input id="b_account_number" type="text" maxlength="30" class="form-control @error('b_account_number') is-invalid @enderror" name="b_account_number" value="{{ old('b_account_number') }}" required autocomplete="b_account_number">

                                            @error('b_account_number')
                                            <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="b_account_name" class="col-md-8 col-form-label text-md-right">
                                            نام صاحب حساب
                                        </label>

                                        <div class="col-md-12">
                                            <input id="b_account_name" type="text" maxlength="30" class="form-control @error('b_account_name') is-invalid @enderror" name="b_account_name" value="{{ old('b_account_name') }}" required autocomplete="b_account_name">

                                            @error('b_account_name')
                                            <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-4 col-form-label text-md-right"> </label>

                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-success">
                                                ثبت اطلاعات
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="b_description" class="col-md-8 col-form-label text-md-right">
                                            توضیحات
                                        </label>

                                        <div class="col-md-12">
                                        <textarea id="b_description" rows="4" cols="10" class="form-control @error('b_description') is-invalid @enderror" name="b_description"  autocomplete="b_description"></textarea>

                                            @error('b_description')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="footer"></div>
                </div>
            </div>
        </div>
    @endif
@endif
