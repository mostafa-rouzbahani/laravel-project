@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/smart_wizard_all.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-fluid">
        @include('transactions.edit.accept')
        @include('transactions.edit.reject')
        @if( $transaction->transAccept_id === 3 && ($transaction->transState_id === 1 || $transaction->transState_id === 2) && $transaction->cancel_flag != 1 )
            <div class="row">
                <div class="col-md-12">
                    <div class="card" style="padding-top: 5%">
                        <div id="smartwizard">
                            <ul class="nav">
                                @foreach($transLevels as $transLevel)
                                    <li>
                                        <a class="nav-link" href="#step-{{ $transLevel->id }}">
                                            {{ $transLevel->id }}.{{ $transLevel->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>

                            <div class="tab-content">
                                @foreach($transLevels as $transLevel)
                                    <div id="step-{{ $transLevel->id }}" class="tab-pane" role="tabpanel">
                                        @include('transactions.edit.'.$transLevel->id)
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel-group" id="accordion">
                        @include('transactions.edit.details')
                        @include('transactions.edit.cancelRequest')
                    </div>
                </div>
            </div>
        @endif
        @if( $transaction->transAccept_id === 3 && $transaction->cancel_flag === 1 && $transaction->transState_id === 4)
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <div class="h3 row" style="padding-bottom: 2%">
                                معامله لغو شده است.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel-group" id="accordion">
                        @include('transactions.edit.details')
                    </div>
                </div>
            </div>
            @elseif( $transaction->transAccept_id === 3 && $transaction->cancel_flag === 1 && $transaction->transState_id != 4)
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <div class="h3 row" style="padding-bottom: 2%">
                                    لغو معامله در حال بررسی است.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel-group" id="accordion">
                            @include('transactions.edit.details')
                        </div>
                    </div>
                </div>
        @endif
@endsection

@section('js')
        <script src="{{ asset('js/jquery.smartWizard.js') }}"></script>
        <script>

            $(document).ready(function(){
                $('#smartwizard').smartWizard({
                    selected: @isset($currentLevel) {{ $currentLevel - 1 }} @else 0 @endisset,
                    theme: 'dots',
                    enableURLhash: false,
                    transition: {
                        animation: 'slide-horizontal', // Effect on navigation, none/fade/slide-horizontal/slide-vertical/slide-swing
                    },
                    toolbarSettings: {
                        toolbarPosition: 'none'
                    },
                    keyboardSettings: {
                        keyNavigation: false // Enable/Disable keyboard navigation(left and right keys are used if enabled)

                    }
                });
            });
        </script>
@endsection
@section('modal')
    @if( $transaction->transAccept_id === 3 && $transaction->transLevel_id < 7 && $transaction->b_user_id == Auth::id() && $transaction->cancel_flag != 2)
    <!-- Modal -->
        <div id="CancelModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content" style="direction: rtl;">
                    <div class="modal-header">
                        <button type="button" class="close" style="float: left" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">لغو معامله</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <p>آیا از لغو معامله اطمینان دارید؟</p>
                            </div>
                            <div class="col-md-12">
                                <h3>
                                    <form method="POST" action="{{ route('transactions.cancel', $transaction->id)  }}" class="col-md-3">
                                        @method('PATCH')
                                        @csrf
                                        <input type="hidden" name="transCancel" value="true">
                                        <button type="submit" class="btn btn-warning">
                                            معامله را لغو کن!
                                        </button>
                                    </form>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    @endif
@endsection


