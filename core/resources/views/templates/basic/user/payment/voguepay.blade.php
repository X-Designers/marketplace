@extends($activeTemplate.'layouts.frontend')

@section('content')

    <div class="pb-100">
        @include($activeTemplate.'partials.dashboardHeader')

        <div class="dashboard-area pt-50">
            <div class="container">
                <div class="card">
                    <div class="card-body py-5 px-2">

                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="deposit-confirm-card rounded-sm">
                                    <div class="thumb">
                                        <img src="{{$deposit->gateway_currency()->methodImage()}}" alt="@lang('Image')"/>
                                    </div>
                                    <div class="content">

                                            <h3>@lang('Please Pay') <b class="text--base">{{getAmount($deposit->final_amo)}} {{__($deposit->method_currency)}}</b></h3>
                                            <h3>@lang('To Get') <b class="text--base">{{getAmount($deposit->amount)}}  {{__($general->cur_text)}}</b></h3>
                                            <button type="button" class="btn btn-md btn--base mt-4" id="btn-confirm">@lang('Pay Now')</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('script')
    <script src="//voguepay.com/js/voguepay.js"></script>
    <script>

        closedFunction = function() {
        }
        successFunction = function(transaction_id) {
            window.location.href = '{{ route(gatewayRedirectUrl()) }}';
        }
        failedFunction=function(transaction_id) {
            window.location.href = '{{ route(gatewayRedirectUrl()) }}' ;
        }

        function pay(item, price) {
            //Initiate voguepay inline payment
            Voguepay.init({
                v_merchant_id: "{{ $data->v_merchant_id}}",
                total: price,
                notify_url: "{{ $data->notify_url }}",
                cur: "{{$data->cur}}",
                merchant_ref: "{{ $data->merchant_ref }}",
                memo:"{{$data->memo}}",
                recurrent: true,
                frequency: 10,
                developer_code: '5af93ca2913fd',
                store_id:"{{ $data->store_id }}",
                custom: "{{ $data->custom }}",

                closed:closedFunction,
                success:successFunction,
                failed:failedFunction
            });
        }

        $(document).ready(function () {
            $(document).on('click', '#btn-confirm', function (e) {
                e.preventDefault();
                pay('Buy', {{ $data->Buy }});
            });
        });
    </script>
@endpush
