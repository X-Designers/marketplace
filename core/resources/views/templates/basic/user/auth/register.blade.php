@extends($activeTemplate.'layouts.frontend')
@section('content')

    @php
        $authenticationContent = getContent('authentication.content',true);
        $topAuthors = \App\User::where('status', 1)->where('top_author',1)->limit(12)->get(['image','username']);
    @endphp

      <!-- account section start -->
      <div class="account-area style--two">
        <div class="account-area-bg bg_img" style="background-image: url({{ getImage('assets/images/frontend/authentication/'. @$authenticationContent->data_values->image,'1920x1080') }});"></div>
        <div class="account-area-left style--two">
            <div class="account-area-left-inner">
                <div class="text-center mb-5">
                    <span class="subtitle text--base fw-bold border-left">@lang('Welcome to') {{__($general->sitename)}}</span>
                    <h2 class="title text-white">@lang('Create an Account')</h2>
                    <p class="fs-14px text-white mt-4">@lang('Already you have an account?') <a href="{{route('user.login')}}" class="text--base">@lang('Sign in now')</a></p>
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
        <div class="account-wrapper style--two">
            <div class="account-logo text-center">
                <a class="site-logo" href="{{route('home')}}"><img src="{{getImage(imagePath()['logoIcon']['path'] .'/logo.png')}}" alt="@lang('site-logo')"></a>
            </div>
            <form class="account-form" action="{{ route('user.register') }}" method="POST" onsubmit="return submitUserForm();">
                @csrf

                <div class="row">

                @if(session()->get('reference') != null)
                    <div class="form-group col-lg-6">
                        <label>@lang('Reference By') <sup class="text--danger">*</sup></label>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="las la-user fs-4"></i></span>
                            <input type="text" name="referBy" autocomplete="off" value="{{session()->get('reference')}}" class="form--control">
                        </div>
                    </div>
                @endif

                <div class="form-group col-lg-6">
                    <label class="text-white">@lang('First Name') <sup class="text--danger">*</sup></label>
                    <div class="custom-icon-field">
                        <i class="las la-user fs-4"></i>
                        <input type="text" name="firstname" value="{{ old('firstname') }}" autocomplete="off" placeholder="@lang('Enter first name')" class="form--control" required>
                    </div>
                </div>
                <div class="form-group col-lg-6">
                    <label class="text-white">@lang('Last Name') <sup class="text--danger">*</sup></label>
                    <div class="custom-icon-field">
                        <i class="las la-user fs-4"></i>
                        <input type="text" name="lastname" value="{{ old('lastname') }}" autocomplete="off" placeholder="@lang('Enter last name')" class="form--control" required>
                    </div>
                </div>
                <div class="form-group col-lg-6">
                    <label class="text-white">@lang('Username') <sup class="text--danger">*</sup></label>
                    <div class="custom-icon-field">
                        <i class="las la-user fs-4"></i>
                        <input type="text" name="username" autocomplete="off" placeholder="@lang('Enter username')" class="form--control" required>
                    </div>
                </div>
                <div class="form-group col-lg-6">
                    <label class="text-white">@lang('Mobile') <sup class="text--danger">*</sup></label>
                    <div class="input-group mb-3">
                        <select name="country_code" class="bg--base input-group-text">
                            @include('partials.country_code')
                        </select>
                        <input type="text" name="mobile" autocomplete="off" placeholder="@lang('Mobile number')"  class="form--control" required>
                    </div>
                </div>
                <div class="form-group col-lg-6">
                    <label class="text-white">@lang('Country') <sup class="text--danger">*</sup></label>
                    <div class="custom-icon-field">
                        <i class="las la-flag fs-4"></i>
                        <input type="text" name="country" autocomplete="off"  class="form--control" required readonly>
                    </div>
                </div>
                <div class="form-group col-lg-6">
                    <label class="text-white">@lang('Email') <sup class="text--danger">*</sup></label>
                    <div class="custom-icon-field">
                    <i class="las la-envelope fs-4"></i>
                    <input type="email" name="email" autocomplete="off" placeholder="@lang('Enter email address')" class="form--control" required>
                    </div>
                </div>

                <div class="form-group col-lg-6">
                    <label class="text-white">@lang('Password') <sup class="text--danger">*</sup></label>
                    <div class="custom-icon-field">
                    <i class="las la-key fs-4"></i>
                    <input type="password" name="password" placeholder="@lang('Enter password')" class="form--control" required>
                    </div>
                </div>
                <div class="form-group col-lg-6">
                    <label class="text-white">@lang('Confirm Password') <sup class="text--danger">*</sup></label>
                    <div class="custom-icon-field">
                    <i class="las la-key fs-4"></i>
                    <input type="password" name="password_confirmation" placeholder="@lang('Re-enter password')" class="form--control" required>
                    </div>
                </div>

                <div class="form-group google-captcha col-lg-12">
                    @php echo recaptcha() @endphp
                </div>
                <div class="form-group col-lg-12">
                    @include($activeTemplate.'partials.custom-captcha')
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn--base w-100">@lang('Sign up now')</button>
                </div>
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
      @if($country_code)
        var t = $(`option[data-code={{ $country_code }}]`).attr('selected','');
      @endif
        $('select[name=country_code]').change(function(){
            $('input[name=country]').val($('select[name=country_code] :selected').data('country'));
        }).change();
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
