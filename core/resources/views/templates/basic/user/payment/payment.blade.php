@extends($activeTemplate.'layouts.frontend')
    @section('content')

    <div class="pb-100">
        @include($activeTemplate.'partials.dashboardHeader')

        <div class="dashboard-area pt-50">
            <div class="container">
                <div class="row gy-4 justify-content-center">
                    @foreach($gatewayCurrency as $data)
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <form action="{{route('user.payment.insert')}}" method="POST">
                                @csrf
                                <input type="hidden" name="currency" value="{{ $data->currency }}">
                                <input type="hidden" name="method_code"  value="{{ $data->method_code }}">
                                <input type="hidden" name="amount"  value="{{$totalPrice}}">

                                <div class="withdraw-card">
                                    <div class="withdraw-card__header">
                                    <div class="thumb">
                                        <img src="{{$data->methodImage()}}" alt="@lang('image')">
                                    </div>
                                    <div class="content">
                                        <h5 class="title text-white">{{__($data->name)}}</h5>
                                    </div>
                                    </div>
                                    <div class="withdraw-card__body">
                                        <ul class="withdraw-info-list text-center">
                                            <li>@lang('Total') : <b>{{getAmount($totalPrice)}} {{$general->cur_text}}</b></li>
                                            <li>@lang('Charge') : <b>{{ getAmount($data->fixed_charge) }} {{$general->cur_text}} @if($data->percent_charge > 0)+ {{ getAmount($data->percent_charge) }}% @endif</b></li>
                                        </ul>
                                        <button type="submit" class="btn btn-md btn--base w-100 mt-4 btn--capsule">@lang('Pay Now')</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@stop
