@extends($activeTemplate.'layouts.frontend')

@section('content')

    @php
        $contactContent = getContent('contact_us.content',true);
        $contactElements = getContent('contact_us.element',false);
    @endphp

    @include($activeTemplate.'partials.breadcrumb')

    <section class="pt-100 pb-100 bg--gradient">
        <!-- <div class="bottom-img"><img src="{{ getImage('assets/images/how-work.png','1915x1080') }}" alt="@lang('image')"></div> -->
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="section-header text-center">
                        <span class="subtitle fw-bold text--base font-size--18px border-left">{{__(@$contactContent->data_values->sub_heading)}}</span>
                        <h2 class="section-title">{{__(@$contactContent->data_values->heading)}}</h2>
                    </div>
                </div>
            </div>
            <div class="row gy-4">
                <div class="col-lg-7">
                    <form class="contact-form"  method="post" action="">
                        @csrf
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label>@lang('Name') <sup class="text--danger">*</sup></label>
                                <div class="custom-icon-field">
                                    <i class="las la-user"></i>
                                    <input type="text" name="name" value="{{ old('name') }}" placeholder="@lang('Full name')" autocomplete="off" class="form--control">
                                </div>
                            </div>
                            <div class="form-group col-lg-6">
                                <label>@lang('Email') <sup class="text--danger">*</sup></label>
                                <div class="custom-icon-field">
                                    <i class="las la-envelope"></i>
                                    <input type="email" name="email" autocomplete="off" value="{{ old('email') }}" placeholder="@lang('Email address')" class="form--control">
                                </div>
                            </div>
                            <div class="form-group col-lg-12">
                                <label>@lang('Subject') <sup class="text--danger">*</sup></label>
                                <div class="custom-icon-field">
                                    <i class="las la-clipboard-list"></i>
                                    <input type="text" name="subject" value="{{ old('subject') }}" placeholder="@lang('Write your subject')" autocomplete="off" class="form--control">
                                </div>
                            </div>
                            <div class="form-group col-lg-12">
                                <label>@lang('Message') <sup class="text--danger">*</sup></label>
                                <div class="custom-icon-field">
                                    <textarea name="message" placeholder="@lang('Your message')" class="form--control">{{old('message')}}</textarea>
                                    <i class="las la-sms"></i>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn--base">@lang('Submit Now')</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-5 ps-lg-4">
                    <div class="map-area">
                        <iframe src = "https://maps.google.com/maps?q={{__(@$contactContent->data_values->latitude)}},{{__(@$contactContent->data_values->longitude)}}&hl=es;z=14&amp;output=embed"></iframe>
                    </div>
                </div>
            </div>
            <div class="row gy-4 mt-lg-5 mt-4">
                @foreach($contactElements as $item)
                    <div class="col-md-4">
                        <div class="single-info d-flex flex-wrap align-items-center">
                            <div class="single-info__icon text-white d-flex justify-content-center align-items-center rounded-3">
                                <i class="las la-map-marked-alt"></i>
                            </div>
                            <div class="single-info__content">
                                <h4 class="title">{{__(@$item->data_values->heading)}}</h4>
                                <p class="mt-2">{{__(@$item->data_values->details)}}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
  </section>
@endsection
