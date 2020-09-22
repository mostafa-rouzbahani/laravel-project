@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <div class="h3 row text-center">
                            تنظیمات سایت
                        </div>
                    </div>
                    <div class="content">
                        <div class="content table-responsive table-full-width">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <td>کلید</td>
                                        <td>مقدار</td>
                                        <td>نام</td>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($options as $option)
                                    <tr>
                                        <td>{{ $option->key }}</td>
                                        <td>{{ $option->value }}</td>
                                        <td>{{ $option->name }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="footer">
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="header">
                        <div class="h3 row text-center">
                            تغییر تنظیمات
                        </div>
                    </div>
                    <div class="content">
                        <form method="POST"  action="{{ route('admin.optionChange') }}">
                            @csrf
                            @method('PATCH')
                            <div class="form-group row">
                                <label for="key" class="col-md-6 col-md-offset-1 col-form-label text-md-right">
                                    کلید
                                </label>
                                <div class="col-md-4">
                                    <select  id="key" class="form-control @error('key') is-invalid @enderror" name="key" required>
                                        <option value="" disabled selected>انتخاب کلید</option>
                                        @foreach($options as $option)
                                            <option value="{{ $option->key }}">{{ $option->key }}</option>
                                        @endforeach
                                    </select>

                                    @error('key')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="value" class="col-md-6 col-md-offset-1 col-form-label text-md-right">
                                    مقدار
                                </label>
                                <div class="col-md-4">
                                    <input id="value" class="form-control @error('value') is-invalid @enderror" name="value" required autocomplete="value">

                                    @error('value')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-md-6 col-md-offset-1 col-form-label text-md-right">
                                    نام
                                </label>
                                <div class="col-md-4">
                                    <input id="name" class="form-control @error('name') is-invalid @enderror" name="name"  autocomplete="name">

                                    @error('name')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-wd btn-round btn-primary">
                                        انجام تغییر
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

@endsection
