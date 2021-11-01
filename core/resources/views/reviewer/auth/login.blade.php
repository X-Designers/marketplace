@extends('reviewer.layouts.master')

@section('content')
<div class="page-wrapper default-version">
    <div class="form-area bg_img" data-background="{{asset('assets/reviewer/images/1.jpg')}}">
        <div class="form-wrapper">
            <h4 class="logo-text mb-15">@lang('Welcome to') <strong>{{$general->sitename}}</strong></h4>
            <p>{{$page_title}} @lang('to Dashboard')</p>
            <form action="{{ route('reviewer.login') }}" method="POST" class="cmn-form mt-30" onsubmit="return submitUserForm();">
                @csrf
                <div class="form-group">
                    <label for="email">@lang('Username')</label>
                    <input type="text" name="username" class="form-control b-radius--capsule" id="username" value="{{ old('username') }}"
                           placeholder="@lang('Enter your username')">
                    <i class="las la-user input-icon"></i>
                </div>
                <div class="form-group">
                    <label for="pass">@lang('Password')</label>
                    <input type="password" name="password" class="form-control b-radius--capsule"
                           placeholder="@lang('Enter your password')">
                    <i class="las la-lock input-icon"></i>
                </div>
                <div class="form-group google-captcha">

                    @php echo recaptcha() @endphp

                </div>

                @include('reviewer.partials.customCaptcha')
                <div class="form-group d-flex justify-content-between align-items-center mt-1">
                    <a href="{{route('reviewer.password.reset')}}" class="text-muted text--small"><i class="las la-lock"></i> @lang('Forgot password?')</a>
                </div>
                <div class="form-group">
                    <button type="submit" class="submit-btn mt-25 b-radius--capsule">@lang('Login') <i
                            class="las la-sign-in-alt"></i></button>
                </div>
            </form>
        </div>
    </div><!-- login-area end -->
</div>
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
    </script>
@endpush

