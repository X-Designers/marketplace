<!doctype html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


@include('partials.seo')



<!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
          integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'/css/bootstrap-fileinput.css')}}">
   @stack('style-lib')

    @stack('style')
</head>
<body>


<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{__($general->sitename)}}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="@lang('Toggle navigation')">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">



                <select class="langSel form-control" >
                    <option value="">@lang('Select One')</option>
                    @foreach($language as $item)
                        <option value="{{$item->code}}" @if(session('lang') == $item->code) selected  @endif>{{ __($item->name) }}</option>
                    @endforeach
                </select>



            @guest
                    @if (Route::has('contact'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('contact') }}">@lang('contact')</a>
                        </li>
                    @endif

                    @if (Route::has('user.login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.login') }}">@lang('login')</a>
                        </li>
                    @endif

                    @if (Route::has('user.register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.register') }}">@lang('register')</a>
                        </li>
                    @endif
                @endguest

                @auth
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            @lang('ticket') <span class="caret"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{route('ticket.open')}}">@lang('Create New')</a>
                            <a class="dropdown-item" href="{{route('ticket')}}">@lang('My Ticket')</a>
                        </div>
                    </li>


                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            @lang('Deposit') <span class="caret"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{route('user.deposit')}}">@lang('Deposit Money')</a>
                            <a class="dropdown-item" href="{{route('user.deposit.history')}}">@lang('Deposit Log')</a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            @lang('Withdraw') <span class="caret"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{route('user.withdraw')}}">@lang('Withdraw Money')</a>
                            <a class="dropdown-item" href="{{route('user.withdraw.history')}}">@lang('Withdraw Log')</a>
                        </div>
                    </li>




                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->fullname }} <span class="caret"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('user.change-password') }}">
                                @lang('Change Password')
                            </a>
                            <a class="dropdown-item" href="{{ route('user.profile-setting') }}">
                                @lang('Profile Setting')
                            </a>
                            <a class="dropdown-item" href="{{ route('user.twofactor') }}">
                                @lang('2FA Security')
                            </a>


                            <a class="dropdown-item" href="{{ route('user.logout') }}">
                                @lang('Logout')
                            </a>

                        </div>
                    </li>
                @endauth

            </ul>
        </div>
    </div>
</nav>


@yield('content')



<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

<script src="{{asset($activeTemplateTrue.'/js/bootstrap-fileinput.js')}}"></script>

@stack('script-lib')



@include('admin.partials.notify')

@include('partials.plugins')


@stack('script')


<script>
    "use strict";
    $(document).on("change", ".langSel", function() {
        window.location.href = "{{url('/')}}/change/"+$(this).val() ;

    });
</script>

</body>
</html>
