<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
{{--    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">--}}
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/pe-icon-7-stroke.css') }}" rel="stylesheet" />

    <!-- Styles -->
{{--    <link href="{{ asset('css/app.css') }}" rel="stylesheet">--}}
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/light-bootstrap-dashboard.css') }}" rel="stylesheet">
{{--    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">--}}
    @yield('css')

</head>
<div class="wrapper">
    <div class="sidebar" data-color="purple" data-image="{{ asset('img/sidebar-5.jpg') }}">

        <!--

            Tip 1: you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple"
            Tip 2: you can also add an image using data-image tag

        -->

        <div class="sidebar-wrapper">
            <div class="logo">
                <a href="{{ url('/') }}" class="simple-text">
                    {{ config('app.name', 'Laravel') }}
                </a>
            </div>

            <ul class="nav">
                @if(Auth::user()->isAdmin())
                    <li @if(str_starts_with(Route::currentRouteName(),'admin'))class="active" @endif>
                        <a href="{{ route('admin') }}">
                            <i class="pe-7s-key"></i>
                            <p>ادمین</p>
                        </a>
                    </li>
                @endif
                <li @if(str_starts_with(Route::currentRouteName(),'home'))class="active" @endif>
                    <a href="{{ route('home') }}">
                        <i class="pe-7s-graph"></i>
                        <p>داشبورد</p>
                    </a>
                </li>
                @if(!Auth::user()->isAdmin())
                    <li @if(str_starts_with(Route::currentRouteName(),'transactions'))class="active" @endif>
                        <a href="{{route('transactions.index')}}">
                            <i class="pe-7s-cash"></i>
                            <p>معاملات</p>
                            <p></p>
                        </a>
                    </li>
                    <li @if(str_starts_with(Route::currentRouteName(),'advertisement'))class="active" @endif>
                        <a href="{{route('advertisement.index')}}">
                            <i class="pe-7s-note2"></i>
                            <p>آگهی ها</p>
                            <p></p>
                        </a>
                    </li>
                    <li @if(str_starts_with(Route::currentRouteName(),'tickets'))class="active" @endif>
                        <a href="{{route('tickets.index')}}">
                            <i class="pe-7s-mail"></i>
                            <p>پشتیبانی</p>
                            <p></p>
                        </a>
                    </li>
                    <li>
                        <a href="user.html">
                            <i class="pe-7s-user"></i>
                            <p>User Profile</p>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>

    <div class="main-panel">
        <nav class="navbar navbar-default navbar-fixed">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
{{--                    <a class="navbar-brand" href="#">--}}

{{--                    </a>--}}
                </div>
                <div class="collapse navbar-collapse">


                    <ul class="nav navbar-nav navbar-right">

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-globe"></i>
                                @if(Auth::user()->unreadNotifications->count() != 0)
                                    <span class="notification hidden-sm hidden-xs">
                                        {{ Auth::user()->unreadNotifications->count() }}
                                    </span>
                                    <p class="hidden-lg hidden-md" style="direction: rtl;">
                                        پیام
                                        ({{ Auth::user()->unreadNotifications->count() }})
                                        <b class="caret"></b>
                                    </p>
                                @else()
                                    <p class="hidden-lg hidden-md" style="direction: rtl;">
                                        پیام
                                    </p>
                                @endif
                            </a>
                            <ul class="dropdown-menu" style="padding-bottom: 10px">
                                @if(Auth::user()->unreadNotifications->count() != 0)
                                    @foreach(Auth::user()->unreadNotifications as $unreadNotification)
                                        <li class="hidden-lg hidden-md" style="direction: rtl"><a href="@if(Auth::user()->isAdmin()) {{ route('admin.transactions') }} @else {{   route('transactions.edit', $unreadNotification->data['transaction_id']) }} @endif">{{ $unreadNotification->data['message']}}</a></li>
                                        <li class="hidden-lg hidden-md" style=" direction:rtl; text-align: right; font-size: 12px; padding: 0px 15px; margin: 0px 15px;">{{ $unreadNotification->created_at->diffForHumans()}}</li>
                                        <li class="hidden-sm hidden-xs" style="text-align: right"><a href="@if(Auth::user()->isAdmin()) {{ route('admin.transactions') }} @else {{   route('transactions.edit', $unreadNotification->data['transaction_id']) }} @endif">{{ $unreadNotification->data['message']}}</a></li>
                                        <li class="hidden-sm hidden-xs" style="color: #9A9A9A; text-align: right; font-size: 12px; padding: 0px 16px">{{ $unreadNotification->created_at->diffForHumans()}}</li>
                                    @endforeach
                                @else
                                    <li class="hidden-sm hidden-xs"><a>شما پیام جدیدی ندارید.</a></li>
                                @endif
                            </ul>
                        </li>
                        <li>
                            <a href="">
                                <i class="hidden-lg hidden-md pe-7s-user"></i>
                                <p>{{ Auth::user()->name }}</p>
                            </a>
                        </li>
{{--                        <li class="dropdown">--}}
{{--                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">--}}
{{--                                <p>--}}
{{--                                    Dropdown--}}
{{--                                    <b class="caret"></b>--}}
{{--                                </p>--}}

{{--                            </a>--}}
{{--                            <ul class="dropdown-menu">--}}
{{--                                <li><a href="#">Action</a></li>--}}
{{--                                <li><a href="#">Another action</a></li>--}}
{{--                                <li><a href="#">Something</a></li>--}}
{{--                                <li><a href="#">Another action</a></li>--}}
{{--                                <li><a href="#">Something</a></li>--}}
{{--                                <li class="divider"></li>--}}
{{--                                <li><a href="#">Separated link</a></li>--}}
{{--                            </ul>--}}
{{--                        </li>--}}


                    </ul>

                    <ul class="nav navbar-nav navbar-left">
                        {{--<li>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-dashboard"></i>
                                <p class="hidden-lg hidden-md">Dashboard</p>
                            </a>
                        </li>--}}
                        <li>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                                <i class="hidden-lg hidden-md pe-7s-close-circle"></i>
                                <p>خروج</p>
                            </a>
                        </li>
                        {{--                        <li>--}}
                        {{--                            <a href="">--}}
                        {{--                                <i class="fa fa-search"></i>--}}
                        {{--                                <p class="hidden-lg hidden-md">Search</p>--}}
                        {{--                            </a>--}}
                        {{--                        </li>--}}
                        <li class="separator hidden-lg"></li>
                    </ul>
                </div>
            </div>
        </nav>


        <div class="content">
            @yield('content')
        </div>


        <footer class="footer">
            <div class="container-fluid">
                <nav class="pull-left">
                    <ul>
                        <li>
                            <a href="#">
                                Home
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Company
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Portfolio
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Blog
                            </a>
                        </li>
                    </ul>
                </nav>
                <p class="copyright pull-right">
                    &copy; <script>document.write(new Date().getFullYear())</script> <a href="http://www.creative-tim.com">Creative Tim</a>, made with love for a better web
                </p>
            </div>
        </footer>

    </div>

</div>

    <!-- Scripts -->
    {{--    <script src="{{ asset('js/app.js') }}" defer></script>--}}
    <script src="{{ asset('js/jquery.3.2.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}" defer></script>
    <script src="{{ asset('js/chartist.min.js') }}" defer></script>
    <script src="{{ asset('js/bootstrap-notify.js') }}" defer></script>
    <script src="{{ asset('js/light-bootstrap-dashboard.js') }}" defer></script>
{{--    <script src="{{ asset('js/select2.min.js') }}" defer></script>--}}
    <!--  Google Maps Plugin    -->
    {{--    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>--}}
    @if (session('status'))
        <script type="text/javascript">
            $(document).ready(function(){
                $.notify({
                    icon: 'fa fa-check',
                    message: "{{ session('status') }}"
                },{
                    type: 'success',
                    placement: {
                        from: "top",
                        align: "left"
                    },
                    timer: 4000,
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
            });
        </script>
    @endif

    @if (session('warning'))
        <script type="text/javascript">
            $(document).ready(function(){
                $.notify({
                    icon: 'fa fa-check',
                    message: "{{ session('warning') }}"
                },{
                    type: 'warning',
                    placement: {
                        from: "top",
                        align: "left"
                    },
                    timer: 4000,
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
            });
        </script>
    @endif

    @yield('js')
    @yield('modal')

</html>
