@extends($activeTemplate.'layouts.frontend')

@section('content')
    @include($activeTemplate.'partials.dashboardHeader')

    <div class="pb-100">
        <div class="dashboard-area pt-50">
            <div class="container">
                <div class="row justify-content-center mt-4">
                    
                    <div class="col-xl-8">
                        <div class="qr-code-card">
                            @if(Auth::user()->ts)
                                <div class="row gy-4 align-items-center">
                                    <div class="col-md-4 mt-lg-3">
                                        <div class="qr-code-thumb">
                                            <p class="fs-14px mt-2">@lang('Use Google Authentication App to scan the QR code.') <a class="text--base" href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en" target="_blank">@lang('App Link')</a></p>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="qr-code-content">
                                            <p class="mb-2">@lang('Disable 2FA Security')</p>
                                            <form action="{{route('user.twofactor.disable')}}" method="POST"  class="qr-code-form">
                                                @csrf
                                                <input type="text" class="form-control" name="code" placeholder="@lang('Enter Google Authenticator Code')">
                                                <button type="submit" class="qr-code-form__btn bg--base rounded-2">@lang('Verify')</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="row gy-4 align-items-center">
                                    <div class="col-md-4">
                                        <div class="qr-code-thumb">
                                            <img class="mx-auto" src="{{$qrCodeUrl}}">
                                            <p class="fs-14px mt-2">@lang('Use Google Authentication App to scan the QR code.') <a class="text--base" href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en" target="_blank">@lang('App Link')</a></p>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="qr-code-content">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <input type="text" name="key" value="{{$secret}}" class="form--control form-control-lg" id="referralURL" readonly>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text copytext h-100 px-3" id="copyBoard" onclick="myFunction()"> <i class="fa fa-copy"></i> </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="mb-4">@lang('If you have any problem with scanning the QR code enter this code manually into the APP.')</p>
                                            <form action="{{route('user.twofactor.enable')}}" method="POST" class="qr-code-form">
                                                @csrf
                                                <input type="hidden" name="key" value="{{$secret}}">
                                                <input type="text" class="form--control" name="code" placeholder="@lang('Enter Google Authenticator Code')">
                                                <button type="submit" class="qr-code-form__btn bg--base rounded-2">@lang('Verify')</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        "use strict";
        function myFunction() {
            var copyText = document.getElementById("referralURL");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            /*For mobile devices*/
            document.execCommand("copy");
            iziToast.success({message: "Copied: " + copyText.value, position: "topRight"});
        }
    </script>
@endpush


