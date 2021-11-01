<!DOCTYPE html>

<html lang="en" itemscope itemtype="http://schema.org/WebPage">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('partials.seo')
    <!-- bootstrap 5  -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/bootstrap.min.css')}}">
    <!-- fontawesome 5  -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/all.min.css')}}">

    <!-- line-awesome webfont -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/line-awesome.min.css')}}">

    <!-- image and videos view on page plugin -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/lightcase.css')}}">

    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/animate.min.css')}}">
    <!-- custom select css -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/nice-select.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/select2.min.css')}}">
    <!-- slick slider css -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/slick.css')}}">
    <!-- dashdoard main css -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/main.css')}}">
    <!-- Custom css -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/custom.css')}}">
    <!-- site color -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/color.php?color1='.$general->base_color.'&color2='.$general->secondary_color)}}">

    @stack('style-lib')

    @stack('style')
</head>

<body>

    <div class="preloader">
        <div class="preloader-container">
            <span class="animated-preloader"></span>
        </div>
  </div>

    <!-- scroll-to-top start -->
    <div class="scroll-to-top">
        <span class="scroll-icon">
            <i class="las la-angle-double-up"></i>
        </span>
    </div>
    <!-- scroll-to-top end -->

  <div class="page-wrapper">
    @include($activeTemplate.'partials.header')
        @yield('content')
    @include($activeTemplate.'partials.footer')
  </div>

    @php
        $cookie = App\Frontend::where('data_keys','cookie.data')->first();
    @endphp

    @if(@$cookie->data_values->status && !session('cookie_accepted'))
        <div class="cookie-remove">
            <div class="cookie__wrapper">
                <div class="container">
                <div class="d-flex flex-wrap align-items-center justify-content-between">
                    <p class="txt my-2">
                        @php echo @$cookie->data_values->description @endphp<br>
                        <a href="{{ @$cookie->data_values->link }}" target="_blank" class="text--base mt-2">@lang('Read Policy')</a>
                    </p>
                    <button class="btn btn--base my-2 policy cookie">@lang('Accept')</button>
                </div>
                </div>
            </div>
        </div>
    @endif


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->

    <!-- jQuery library -->
    <script src="{{asset($activeTemplateTrue.'js/jquery-3.5.1.min.js')}}"></script>
    <!-- bootstrap js -->
    <script src="{{asset($activeTemplateTrue.'js/bootstrap.bundle.min.js')}}"></script>
    <!-- lightcase plugin -->
    <script src="{{asset($activeTemplateTrue.'js/lightcase.js')}}"></script>
    <!-- custom select js -->
    <script src="{{asset($activeTemplateTrue.'js/jquery.nice-select.min.js')}}"></script>
    <script src="{{asset($activeTemplateTrue.'js/select2.min.js')}}"></script>
    <!-- slick slider js -->
    <script src="{{asset($activeTemplateTrue.'js/slick.min.js')}}"></script>
    <!-- scroll animation -->
    <script src="{{asset($activeTemplateTrue.'js/wow.min.js')}}"></script>
    <!-- dashboard custom js -->
    <script src="{{asset($activeTemplateTrue.'js/app.js')}}"></script>

    @stack('script-lib')

    @stack('script')

    @include('partials.plugins')

    @include($activeTemplate.'partials.notify')


    <script>
        (function ($) {
            "use strict";
            $(document).on("change", ".langSel", function() {
                window.location.href = "{{url('/')}}/change/"+$(this).val() ;
            });

            $('.cookie').on('click',function () {

                var url = "{{ route('cookie.accept') }}";

                $.get(url,function(response){

                    if(response.success){
                    notify('success',response.success);
                    $('.cookie-remove').html('');
                    }
                });
            });
        })(jQuery);
    </script>

</body>
</html>
