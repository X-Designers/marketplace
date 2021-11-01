{{-- @extends($activeTemplate .'layouts.frontend')
@section('content')
@include($activeTemplate.'partials.breadcrumb')
    <section class="pt-100 pb-100 position-relative z-index">
        <div class="bottom-img"><img src="{{ getImage('assets/images/how-work.png','1915x1080') }}" alt="@lang('image')"></div>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <form class="account-form section--bg box--border box--shadow p-sm-5 p-3 rounded-3" method="POST" action="{{route('user.go2fa.verify')}}">
                    @csrf
                        <div class="text-center mb-5">
                            <span class="subtitle text--base fw-bold border-left">@lang('2FA Verification')</span>
                            <p>@lang('Current Time') : <b>{{\Carbon\Carbon::now()}}</b></p>
                            <h5 class="title">@lang('Google Authenticator Code')</h5>
                        </div>
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="las la-code fs-4"></i></span>
                                <input type="text" name="code[]" autocomplete="off" placeholder="@lang('Enter the code')" class="form--control">
                            </div>
                        </div>
                        <button type="submit" class="btn btn--base w-100 mt-3">@lang('Submit')</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection --}}



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
                    <h2 class="title text-white">{{__($page_title)}}</h2>
                    <p class="fs-14px text-white mt-4">@lang('Current Time') : <b>{{\Carbon\Carbon::now()}}</b></p>
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
        <form class="account-form" method="POST" action="{{route('user.go2fa.verify')}}">
            @csrf
                <div class="form-group">
                    <label class="text-white">@lang('Code') <sup class="text--danger">*</sup></label>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="las la-key fs-4"></i></span>
                        <input type="text" name="code[]" autocomplete="off" placeholder="@lang('Enter the code')" class="form--control">
                    </div>
                </div>
                <button type="submit" class="btn btn--base w-100 mt-3">@lang('Submit')</button>
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
        $('.header, .footer-section').addClass('d-none');
    </script>
@endpush

