@extends($activeTemplate.'layouts.frontend')
    @section('content')

    <div class="pb-100">
        @include($activeTemplate.'partials.dashboardHeader')

        <div class="dashboard-area pt-50">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xxl-7 col-lg-6 pe-xxl-5">
                        <div class="withdraw-preview-sidebar">
                            <div class="withdraw-preview-sidebar__header">
                                <div class="thumb">
                                    <img src="{{ $data->gateway_currency()->methodImage() }}" alt="@lang('image')">
                                </div>
                                <div class="content">
                                    <h5 class="title text-white">{{ __($data->gateway->name) }}</h5>
                                </div>
                            </div>

                            <ul class="caption-list mt-4">
                                <li>
                                    <div class="caption">@lang('Request Amount')</div>
                                    <div class="value">{{getAmount($data->amount)}} {{__($general->cur_text)}}</div>
                                </li>
                                <li class="text--danger">
                                    <div class="caption">@lang('Deposit Charge')</div>
                                    <div class="value">{{getAmount($data->charge)}} {{__($general->cur_text)}}</div>
                                </li>
                                <li class="text--info">
                                    <div class="caption">@lang('Payable')</div>
                                    <div class="value">{{getAmount($data->amount + $data->charge)}}</strong> {{__($general->cur_text)}}</div>
                                </li>
                                <li>
                                    <div class="caption">@lang('Conversion Rate')</div>
                                    <div class="value">1 {{__($general->cur_text)}} = {{getAmount($data->rate)}}  {{__($data->baseCurrency())}}</div>
                                </li>
                                <li class="text--success">
                                    <div class="caption">@lang('In') : {{$data->baseCurrency()}}</div>
                                    <div class="value">{{getAmount($data->final_amo)}}</div>
                                </li>
                                @if($data->gateway->crypto==1)
                                    <li class="text--info">
                                        <div class="caption">@lang('Conversion with') <b>{{ __($data->method_currency) }}</b> @lang('and final value will Show on next step')</div>
                                    </li>
                                @endif
                            </ul>

                            <div class="text-end mt-4">
                                @if( 1000 >$data->method_code)
                                    <a href="{{route('user.deposit.confirm')}}" class="btn btn--base w-100">@lang('Confirm')</a>
                                @else
                                    <a href="{{route('user.deposit.manual.confirm')}}" class="btn btn--base w-100">@lang('Confirm')</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop


