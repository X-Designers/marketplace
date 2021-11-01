@extends($activeTemplate.'layouts.frontend')

@section('content')
    @php
        $authenticationContent = getContent('authentication.content',true);
        $topAuthors = \App\User::where('status', 1)->where('top_author',1)->limit(12)->get(['image','username']);
    @endphp

    <!-- account section start -->
    <div class="account-area">
        <div class="account-area-bg bg_img" style="background-image: url({{ getImage('assets/images/frontend/authentication/'. @$authenticationContent->data_values->image,'1920x1080') }});"></div>
        <div class="account-area-left">
            <div class="account-area-left-inner">
                <div class="text-center mb-5">
                    <span class="subtitle text--base fw-bold border-left">@lang('Welcome Back')</span>
                    <h2 class="title text-white">@lang('Sign in to your account')</h2>
                    <p class="fs-14px text-white mt-4">@lang('Don\'t have an account?') <a href="{{route('user.register')}}" class="text--base">@lang('Sign up now')</a></p>
                </div>

                @if (count($topAuthors) > 0)
                    <h5 class="text-white text-center mt-5 mb-3">@lang('Our Top Authors')</h5>
                    <div class="top-author-slider">
                        @foreach ($topAuthors as $item)
                            <div class="single-slide">
                                <a href="{{route('username.search',strtolower($item->username))}}" class="s-top-author">
                                    <img src="{{ getImage(imagePath()['profile']['user']['path'].'/'. $item->image,imagePath()['profile']['user']['size']) }}" alt="image">
                                </a>
                            </div>
                        @endforeach
                    </div><!-- top-author-slider end -->
                @endif
            </div>
        </div>
        <div class="account-wrapper">
        <div class="account-logo text-center">
        <a class="site-logo" href="{{route('home')}}"><img src="{{getImage(imagePath()['logoIcon']['path'] .'/logo.png')}}" alt="@lang('site-logo')"></a>
        </div>
        <form class="account-form" method="POST" action="{{ route('user.login')}}"
        onsubmit="return submitUserForm();">
            @csrf
            <div class="form-group">
                <label class="text-white">@lang('Username') <sup class="text--danger">*</sup></label>
                <div class="custom-icon-field">
                    <i class="las la-user fs-4"></i>
                    <input type="text" name="username" value="{{ old('username') }}" autocomplete="off" placeholder="@lang('Enter Username')" class="form--control">
                </div>
            </div>
            <div class="form-group">
                <label class="text-white">@lang('Password') <sup class="text--danger">*</sup></label>
                <div class="custom-icon-field">
                    <i class="las la-key fs-4"></i>
                    <input type="password" name="password" placeholder="@lang('Enter password')" class="form--control">
                </div>
            </div>
            <div class="form-group google-captcha">
                @php echo recaptcha() @endphp
            </div>
            <div class="form-group">
                @include($activeTemplate.'partials.custom-captcha')
            </div>
            <button type="submit" class="btn btn--base w-100 mt-3">@lang('Sign in now')</button>
            <div class="mt-3 d-flex flex-wrap justify-content-between">
                <p class="fs-14px text-white"><i class="las la-lock"></i> <a href="{{route('user.password.request')}}" class="text--base">@lang('Forgot password?')</a></p>
            </div>
        </form>
        <div class="account-footer text-center">
            <span class="text-white">© @lang('copyright 2021 by')</span> <a href="{{route('home')}}" class="text--base">{{__($general->sitename)}}</a>
        </div>
        </div>
    </div>
    <!-- account section end -->
@endsection

@push('script')
    <script>
        "use strict";
        function submitUserForm() {
            var response = grecaptcha.getResponse();
            if (response.length == 0) {
                document.getElementById('g-recaptcha-error').innerHTML = '<span style="color:red;">@lang("Captcha field is required.")</span>';
                return false;
            }
            return true;
        }
        function verifyCaptcha() {
            document.getElementById('g-recaptcha-error').innerHTML = '';
        }

        $('.header, .footer-section').addClass('d-none');
    </script>
@endpush
