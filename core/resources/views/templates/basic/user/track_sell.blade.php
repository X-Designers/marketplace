@extends($activeTemplate.'layouts.frontend')

@section('content')

<div class="pb-100">
    @include($activeTemplate.'partials.dashboardHeader')
    <div class="dashboard-area pt-50">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-8">
                    <form class="hero-search-form wow fadeInUp" method="POST" action="{{route('user.track.sell.search')}}">
                        @csrf
                        <input type="text" name="code" id="hero-search-field" class="form--control" placeholder="@lang('Enter Purchase Code')">
                        <button type="submit" class="hero-search-btn"><i class="fa fa-search"></i></button>
                    </form>
                </div>
            </div><!-- row end -->
            @if($result)
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive--md mt-4">
                        <table class="table custom--table">
                        <thead>
                            <tr>
                                <th>@lang('Date')</th>
                                <th>@lang('Code')</th>
                                <th>@lang('Product')</th>
                                <th>@lang('Licence Type')</th>
                                <th>@lang('Support Time')</th>
                                <th>@lang('Product Price')</th>
                                <th>@lang('Support Fee')</th>
                                <th>@lang('Amount')</th>
                            </tr>
                        </thead>
                        <tbody>
                                <tr>
                                    <td data-label="@lang('Date')">
                                        <b>{{ showDateTime($result->created_at,'d-m-Y') }}</b>
                                    </td>
                                    <td data-label="@lang('Code')">
                                        <b>{{ $result->code }}</b>
                                    </td>
                                    <td data-label="@lang('Product')">
                                        <b>{{ $result->product->name }}</b>
                                    </td>
                                    <td data-label="@lang('Licence Type')">
                                        @if ($result->license == 1)
                                            <b>@lang('Regular')</b>
                                        @elseif ($result->license == 2)
                                            <b>@lang('Extended')</b>
                                        @endif
                                    </td>
                                    <td data-label="@lang('Support Time')">
                                        @if ($result->support_time)
                                            <b>{{$result->support_time}}</b>
                                        @else
                                            <b>@lang('No support')</b>
                                        @endif
                                    </td>
                                    <td data-label="@lang('Product Price')">
                                        <b>{{$general->cur_sym}}{{getAmount($result->product_price)}}</b>
                                    </td>
                                    <td data-label="@lang('Support Fee')">
                                        <b>{{$general->cur_sym}}{{getAmount($result->support_fee)}}</b>
                                    </td>
                                    <td data-label="@lang('Product Price')">
                                        <b>{{$general->cur_sym}}{{getAmount($result->total_price)}}</b>
                                    </td>
                                </tr>
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
