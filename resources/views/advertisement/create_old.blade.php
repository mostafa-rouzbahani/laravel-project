@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4 class="title">ثبت آگهی جدید</h4>
                        <p class="category"></p>
                    </div>
                    <div class="content">
                        <form method="POST" action="{{ route('advertisement.store') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="p_currency_id" class="col-md-8 col-form-label text-md-right">
                                    نوع ارزی را که می خواهید پرداخت کنید، اتنخاب کنید.
                                </label>

                                <div class="col-md-2">
                                    <select id="p_currency_id" class="form-control @error('p_currency_id') is-invalid @enderror"  name="p_currency_id" >
{{--                                    <select id="p_currency_id" class="form-control @error('p_currency_id') is-invalid @enderror"  name="p_currency_id" multiple="multiple" dir="rtl">--}}
                                        @foreach ($currency as $key => $value)
                                            <option value="{{ $key }}">
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('p_currency_id')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="p_country_id" class="col-md-8 col-form-label text-md-right">
                                    کشوری را که می توانید ارز را در آن پرداخت کنید، انتخاب نمایید.
                                </label>

                                <div class="col-md-2">
                                    <select id="p_country_id" class="form-control @error('p_country_id') is-invalid @enderror"  name="p_country_id">
                                        @foreach ($country as $key => $value)
                                            <option value="{{ $key }}">
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('p_country_id')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="amount_from" class="col-md-8 col-form-label text-md-right">
                                    کمترین مبلغ برای یک معامله را بر اساس نوع ارزی که در بالا انتخاب کردید، مشخص کنید.
                                </label>

                                <div class="col-md-2">
                                    <input id="amount_from" type="number" class="form-control @error('amount_from') is-invalid @enderror" name="amount_from" value="{{ old('amount_from') }}" required autocomplete="amount_from">

                                    @error('amount_from')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="amount_to" class="col-md-8 col-form-label text-md-right">
                                    بیشترین مبلغ برای یک معامله را بر اساس نوع ارزی که در بالا انتخاب کردید، مشخص کنید.
                                </label>

                                <div class="col-md-2">
                                    <input id="amount_to" type="number" class="form-control @error('amount_to') is-invalid @enderror" name="amount_to" value="{{ old('amount_to') }}" required autocomplete="amount_to">

                                    @error('amount_to')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="r_currency_id" class="col-md-8 col-form-label text-md-right">
                                    تمایل دارید چه نوع ارزی تحویل بگیرید؟
                                </label>

                                <div class="col-md-2">
                                    <select id="r_currency_id" class="form-control @error('r_currency_id') is-invalid @enderror"  name="r_currency_id">
                                        @foreach ($currency as $key => $value)
                                            <option value="{{ $key }}">
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('r_currency_id')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for=r_country_id" class="col-md-8 col-form-label text-md-right">
                                    تمایل دارید در چه کشوری ارز خود را تحویل بگیرید؟
                                </label>

                                <div class="col-md-2">
                                    <select id="r_country_id" class="form-control @error('r_country_id') is-invalid @enderror"  name="r_country_id">
                                        @foreach ($country as $key => $value)
                                            <option value="{{ $key }}">
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('r_country_id')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right"> </label>

                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-wd btn-round btn-primary">
                                        ثبت
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function(){
            $('#p_currency_id').change(function(e){
                if($(this).val() != '2'){
                    rcv_cur_on();
                }
                else {
                    rcv_cur_off();
                    pay_cur_on();
                    notify('ارز دریافتی و پرداختی باید متفاوت باشند.');
                }
            }).change();
            $('#p_country_id').change(function(e){
                if($(this).val() != '2'){
                    rcv_country_on();
                }
                else {
                    rcv_country_off();
                    pay_country_on();
                    notify('کشور دریافتی و پرداختی باید متفاوت باشند.');
                }
            }).change();
            $('#r_currency_id').change(function(e){
                if($(this).val() != '2'){
                    pay_cur_on();
                }
                else {
                    pay_cur_off();
                    rcv_cur_on();
                    notify('ارز دریافتی و پرداختی باید متفاوت باشند.');
                }
            }).change();
            $('#r_country_id').change(function(e){
                if($(this).val() != '2'){
                    pay_country_on();
                }
                else {
                    pay_country_off();
                    rcv_country_on();
                    notify('کشور دریافتی و پرداختی باید متفاوت باشند.');
                }
            }).change();


            function rcv_cur_on() {
                $("#r_currency_id option[value='2']").prop('selected',true);
                $("#r_currency_id").prop('disabled',true);
                $rcv_cur = 1;
            }
            function rcv_cur_off() {
                $("#r_currency_id option[value='2']").prop('selected',false);
                $("#r_currency_id").prop('disabled',false);
                $rcv_cur = 0;
            }
            function rcv_country_on() {
                $("#r_country_id option[value='2']").prop('selected',true);
                $("#r_country_id").prop('disabled',true);
                $rcv_country = 1;
            }
            function rcv_country_off() {
                $("#r_country_id option[value='2']").prop('selected',false);
                $("#r_country_id").prop('disabled',false);
                $rcv_country = 0;
            }
            function pay_cur_on() {
                $("#p_currency_id option[value='2']").prop('selected',true);
                $("#p_currency_id").prop('disabled',true);
                $pay_cur = 1;
            }
            function pay_cur_off() {
                $("#p_currency_id option[value='2']").prop('selected',false);
                $("#p_currency_id").prop('disabled',false);
                $pay_cur = 0;
            }
            function pay_country_on() {
                $("#p_country_id option[value='2']").prop('selected',true);
                $("#p_country_id").prop('disabled',true);
                $pay_country = 1;
            }
            function pay_country_off() {
                $("#p_country_id option[value='2']").prop('selected',false);
                $("#p_country_id").prop('disabled',false);
                $pay_country = 0;
            }

            $("form").submit(function() {
                if ($rcv_cur == 1) {$('<input>').attr({type: 'hidden', name: 'r_currency_id', value: '2'}).appendTo('form');}
                if ($rcv_country == 1) {$('<input>').attr({type: 'hidden', name: 'r_country_id', value: '2'}).appendTo('form');}
                if ($pay_cur == 1) {$('<input>').attr({type: 'hidden', name: 'p_currency_id', value: '2'}).appendTo('form');}
                if ($pay_country == 1) {$('<input>').attr({type: 'hidden', name: 'p_country_id', value: '2'}).appendTo('form');}
            });


            function notify (message){
                $.notify({
                    icon: 'fa fa-exclamation',
                    message: message
                },{
                    type: 'warning',
                    placement: {
                        from: "top",
                        align: "left"
                    },
                    delay: 4000,
                    template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
                        '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
                        '<span data-notify="icon"></span> ' +
                        '<span data-notify="title">{1}</span> ' +
                        '<span data-notify="message" style="direction: rtl;">{2}</span>' +
                        '<div class="progress" data-notify="progressbar">' +
                        '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
                        '</div>' +
                        '<a href="{3}" target="{4}" data-notify="url"></a>' +
                        '</div>'
                });

            }
        });
    </script>
@endsection
