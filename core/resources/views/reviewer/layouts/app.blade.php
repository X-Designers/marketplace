@extends('reviewer.layouts.master')

@section('content')
    <!-- page-wrapper start -->
    <div class="page-wrapper default-version">
        @include('reviewer.partials.sidenav')
        @include('reviewer.partials.topnav')

        <div class="body-wrapper">
            <div class="bodywrapper__inner">

                @include('reviewer.partials.breadcrumb')

                @yield('panel')

            </div><!-- bodywrapper__inner end -->
        </div><!-- body-wrapper end -->
    </div>

@endsection
