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
                    <p class="fs-14px text-white mt-4">@lang('Please check including your Junk/Spam Folder. if not found, you can') <a href="{{ route('user.password.request') }}" class="text--base">@lang('Try to send again')</a></p>
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
        <form class="account-form" method="POST" action="{{ route('user.password.verify-code') }}">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
                <div class="form-group">
                    <label class="text-white">@lang('Verifaction Code') <sup class="text--danger">*</sup></label>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="las la-at fs-4"></i></span>
                        <input type="text" name="code[]" autocomplete="off" placeholder="@lang('Enter the code')" class="form--control">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn--base w-100 mt-3">@lang('Verify Code')</button>
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

