@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <div class="h3 row">
                            عنوان:
                            {{ $ticket->title }}
                            <span class="h5 row text-center" style="color: gray">
                                ایجاد شده توسط
                                {{ $ticket->user->name }}
                                 در تاریخ
                                {{ $ticket->created_at->format('yy-m-d') }}
                            </span>
                        </div>
                    <hr>
                    <div class="content" style="text-align: right">
                        @if ($ticket->status == 1)
                            <div class="row">
                                <div class="col-md-12">
                                    <form method="POST" action="{{ route('tickets.update', $ticket->id)  }}">
                                        @csrf
                                        @method('PATCH')
                                        <div class="form-group row">
                                            <label for="message" class="col-md-2 col-form-label text-md-right">
                                                نوشتن پیام جدید
                                            </label>

                                            <div class="col-md-5">
                                                <textarea id="message"  rows="3" cols="5" class="form-control @error('message') is-invalid @enderror" name="message" required autocomplete="message"></textarea>
                                                @error('message')
                                                <span class="invalid-feedback text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-success">
                                            ارسال پیام
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endif
                        <hr>
                        <ul style="list-style: none">
                                @foreach($messages as $message)
                                    @if($message->admin == 0)
                                        <li style="margin-top: 1%">
                                            <div class="container" style="position: relative">
                                                <div style="background-color: lightblue; min-height: 50px; max-width: 50%; border-radius: 10px; padding: 15px 15px 30px 15px; word-break: break-all;">
                                                    <p> {{ $message->message }} </p>
                                                </div>
                                                <span style="position: absolute; left: 51%; bottom: 5%; color: gray; font-size: 12px;"> {{ $message->created_at->diffForHumans() }} </span>
                                            </div>
                                        </li>
                                    @else
                                        <li style="margin-top: 1%">
                                            <div class="container" style="position: relative; margin-right: 10%;">
                                                <div style="background-color: lightgoldenrodyellow; min-height: 50px; max-width: 50%; border-radius: 10px; padding: 15px 15px 30px 15px; word-break: break-all;">
                                                    <p> {{ $message->message }} </p>
                                                </div>
                                                <span style="position: absolute; left: 51%; bottom: 5%; color: gray; font-size: 12px;"> {{ $message->created_at->diffForHumans() }} </span>
                                            </div>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
@endsection
