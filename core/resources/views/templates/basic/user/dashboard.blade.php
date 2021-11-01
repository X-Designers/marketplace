@extends($activeTemplate.'layouts.frontend')
@section('content')

<div class="pb-100">
    @include($activeTemplate.'partials.dashboardHeader')

    <!-- dashboard area start -->
    <div class="dashboard-area pt-50">
      <div class="container">
        <div class="row">
          <div class="col-lg-8">

            <div class="row gy-4">
              <div class="col-xl-4 col-sm-6">
                <div class="d-widget d-flex flex-wrap align-items-center rounded-3">
                  <div class="d-widget__content">
                    <h3 class="d-number">{{$general->cur_sym}}{{getAmount($user->balance)}}</h3>
                    <span class="caption">@lang('Balance')</span>
                  </div>
                  <div class="d-widget__icon rounded">
                    <i class="las la-money-bill text--base"></i>
                    <a href="{{route('user.transaction')}}" class="btn btn-sm btn--base py-1 text-center">@lang('View all')</a>
                  </div>
                </div><!-- d-widget end -->
              </div>
              <div class="col-xl-4 col-sm-6">
                <div class="d-widget d-flex flex-wrap align-items-center rounded-3">
                  <div class="d-widget__content">
                    <h3 class="d-number">{{getAmount($user->earning)}}</h3>
                    <span class="caption">@lang('Earning')</span>
                  </div>
                  <div class="d-widget__icon rounded">
                    <i class="las la-money-bill text--base"></i>
                    <a href="{{route('user.transaction')}}" class="btn btn-sm btn--base py-1 text-center">@lang('View all')</a>
                  </div>
                </div><!-- d-widget end -->
              </div>
              <div class="col-xl-4 col-sm-6">
                <div class="d-widget d-flex flex-wrap align-items-center rounded-3">
                  <div class="d-widget__content">
                    <h3 class="d-number">{{$uploadedProductCount}}</h3>
                    <span class="caption">@lang('Your Products')</span>
                  </div>
                  <div class="d-widget__icon rounded">
                    <i class="las la-upload text--base"></i>
                    <a href="{{route('user.product.all')}}" class="btn btn-sm btn--base py-1 text-center">@lang('View all')</a>
                  </div>
                </div><!-- d-widget end -->
              </div>
              <div class="col-xl-4 col-sm-6">
                <div class="d-widget d-flex flex-wrap align-items-center rounded-3">
                  <div class="d-widget__content">
                    <h3 class="d-number">{{$purchasedProductCount}}</h3>
                    <span class="caption">@lang('Purchased Product')</span>
                  </div>
                  <div class="d-widget__icon rounded">
                    <i class="las la-cart-arrow-down text--base"></i>
                    <a href="{{route('user.purchased.product')}}" class="btn btn-sm btn--base py-1 text-center">@lang('View all')</a>
                  </div>
                </div><!-- d-widget end -->
              </div>
              <div class="col-xl-4 col-sm-6">
                <div class="d-widget d-flex flex-wrap align-items-center rounded-3">
                  <div class="d-widget__content">
                    <h3 class="d-number">{{$transactionCount}}</h3>
                    <span class="caption">@lang('Transaction')</span>
                  </div>
                  <div class="d-widget__icon rounded">
                    <i class="las la-exchange-alt text--base"></i>
                    <a href="{{route('user.transaction')}}" class="btn btn-sm btn--base py-1 text-center">@lang('View all')</a>
                  </div>
                </div><!-- d-widget end -->
              </div>
              <div class="col-xl-4 col-sm-6">
                <div class="d-widget d-flex flex-wrap align-items-center rounded-3">
                  <div class="d-widget__content">
                    <h3 class="d-number">{{$totalSell}}</h3>
                    <span class="caption">@lang('Total Sell')</span>
                  </div>
                  <div class="d-widget__icon rounded">
                    <i class="las la-wallet text--base"></i>
                    <a href="{{route('user.product.all')}}" class="btn btn-sm btn--base py-1 text-center">@lang('View all')</a>
                  </div>
                </div><!-- d-widget end -->
              </div>
            </div><!-- row end -->

          </div>
          <div class="col-lg-4 ps-lg-4 mt-lg-0 mt-5">
            <div class="user-sidebar">
              <div class="user-widget">
                <h4 class="user-widget__title">@lang('Your Balance')</h4>
                <p>@lang('You Have') <b class="bg--base text-white px-2 py-1">{{getAmount($user->balance)}} {{$general->cur_text}}</b> @lang('in your Account')</p>
              </div><!-- user-widget end -->
              <div class="user-widget">
                <h4 class="user-widget__title">@lang('This Month\'s Stats')</h4>
                <ul class="caption-list">
                  <li>
                    <span class="caption">@lang('Released Products')</span>
                    <span class="value">{{$thisMonthRealeased}}</span>
                  </li>
                  <li>
                    <span class="caption">@lang('Purchased Products')</span>
                    <span class="value">{{$thisMonthPurchased}}</span>
                  </li>
                </ul>
              </div><!-- user-widget end -->
            </div><!-- user-sidebar end -->
          </div>

        </div>

        <div class="row justify-content-center mb-30-none mt-5">
            <div class="col-xl-12 col-md-12 col-sm-12 mb-30">
                <div class="chart-area">
                    <div class="chart-scroll">
                        <div class="chart-wrapper m-0">
                            <canvas id="myChart" width="400" height="150"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

      </div>
    </div>
    <!-- dashboard area end -->

  </div>
@endsection

@push('script')
<!--chart js-->
@php
    $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    $itr = 0;
@endphp

<script src="{{asset($activeTemplateTrue.'js/chart.js')}}"></script>
<script>
    'use strict';

    var config = {
        type: 'line',
        data: {
            labels: @php echo json_encode($months) @endphp,
            datasets: [{
                label: '@lang('Amount')',
                backgroundColor: '#{{$general->base_color}}',
                borderColor: '#{{$general->base_color}}',
                data: [
                    @foreach($months as $k => $month)
                        @if(@$sell_chart_data[$itr]['month'] == $month)
                            {{ @$sell_chart_data[$itr]['amount'] }},
                            @php $itr++; @endphp
                        @else
                            0,
                        @endif
                    @endforeach
                ],
                fill: false,
            }]
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: '@lang('Sell Data Monthly')'
            },
            scales: {
                yAxes: [{
                    ticks: {
                        // the data minimum used for determining the ticks is Math.min(dataMin, suggestedMin)
                        suggestedMin: 10,

                        // the data maximum used for determining the ticks is Math.max(dataMax, suggestedMax)
                        suggestedMax: 50
                    }
                }]
            }
        }
    };

    window.onload = function() {
        var ctx = document.getElementById('myChart').getContext('2d');
        window.myLine = new Chart(ctx, config);
    };
</script>
@endpush
