@extends($activeTemplate.'layouts.frontend')
    @section('content')

    <div class="pb-100">
        @include($activeTemplate.'partials.dashboardHeader')

        <div class="dashboard-area pt-50">
            <div class="container">
                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="deposit-confirm-card  rounded-sm">
                                    <div class="thumb">
                                        <img src="{{$deposit->gateway_currency()->methodImage()}}" alt="@lang('Image')"/>
                                    </div>
                                    <div class="content">
                                        <h3>@lang('Please Pay') <b class="text--base">{{getAmount($deposit->final_amo)}} {{__($deposit->method_currency)}}</b></h3>
                                        <h3>@lang('To Get') <b class="text--base">{{getAmount($deposit->amount)}}  {{__($general->cur_text)}}</b></h3>
                                        <button type="button" class="btn btn-lg btn--base mt-4" id="btn-confirm" onClick="payWithRave()">@lang('Pay Now')</button>
                                        <script src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
                                        <script>
                                            var btn = document.querySelector("#btn-confirm");
                                            btn.setAttribute("type", "button");
                                            const API_publicKey = "{{$data->API_publicKey}}";

                                            function payWithRave() {
                                                var x = getpaidSetup({
                                                    PBFPubKey: API_publicKey,
                                                    customer_email: "{{$data->customer_email}}",
                                                    amount: "{{$data->amount }}",
                                                    customer_phone: "{{$data->customer_phone}}",
                                                    currency: "{{$data->currency}}",
                                                    txref: "{{$data->txref}}",
                                                    onclose: function () {
                                                    },
                                                    callback: function (response) {
                                                        var txref = response.tx.txRef;
                                                        var status = response.tx.status;
                                                        var chargeResponse = response.tx.chargeResponseCode;
                                                        if (chargeResponse == "00" || chargeResponse == "0") {
                                                            window.location = '{{ url('ipn/flutterwave') }}/' + txref + '/' + status;
                                                        } else {
                                                            window.location = '{{ url('ipn/flutterwave') }}/' + txref + '/' + status;
                                                        }
                                                            // x.close(); // use this to close the modal immediately after payment.
                                                        }
                                                    });
                                            }
                                        </script>
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
