@extends($activeTemplate.'layouts.frontend')
    @section('content')

    <div class="pb-100">
        @include($activeTemplate.'partials.dashboardHeader')

        <div class="dashboard-area pt-50">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row justify-content-center py-3">
                                    <div class="col-md-6">
                                        <div class="card text-center">
                                            <div class="card-header card-header-bg bg--base">
                                                <h3 class="text-white">@lang('Payment Preview')</h3>
                                            </div>
                                            <div class="card-body text-center">
                                                <h4 class="my-2"> @lang('Please Send Exactly') <span class="text--base"> {{ $data->amount }}</span> {{__($data->currency)}}</h4>
                                                <h5 class="mb-2">@lang('To') <span class="text--base"> {{ $data->sendto }}</span></h5>
                                                <img src="{{$data->img}}" alt="@lang('Image')">
                                                <h4 class="text--base bold my-4">@lang('Scan To Send')</h4>
                                            </div>
                                        </div>
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
