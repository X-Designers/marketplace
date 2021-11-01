@extends($activeTemplate.'layouts.frontend')

@section('content')

<div class="pb-100">
    @include($activeTemplate.'partials.dashboardHeader')
    <div class="dashboard-area pt-50">
        <div class="container">
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
                            @forelse ($sells as $item)
                                <tr>
                                    <td data-label="@lang('Date')">
                                        <b>{{ showDateTime($item->created_at,'d-m-Y') }}</b>
                                    </td>
                                    <td data-label="@lang('Code')">
                                        <b>{{ $item->code }}</b>
                                    </td>
                                    <td data-label="@lang('Product')">
                                        <b>{{ $item->product->name }}</b>
                                    </td>
                                    <td data-label="@lang('Licence Type')">
                                        @if ($item->license == 1)
                                            <b>@lang('Regular')</b>
                                        @elseif ($item->license == 2)
                                            <b>@lang('Extended')</b>
                                        @endif
                                    </td>
                                    <td data-label="@lang('Support Time')">
                                        @if ($item->support_time)
                                            <b>{{$item->support_time}}</b>
                                        @else
                                            <b>@lang('No support')</b>
                                        @endif
                                    </td>
                                    <td data-label="@lang('Product Price')">
                                        <b>{{$general->cur_sym}}{{getAmount($item->product_price)}}</b>
                                    </td>
                                    <td data-label="@lang('Support Fee')">
                                        <b>{{$general->cur_sym}}{{getAmount($item->support_fee)}}</b>
                                    </td>
                                    <td data-label="@lang('Product Price')">
                                        <b>{{$general->cur_sym}}{{getAmount($item->total_price)}}</b>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="100%">{{__($empty_message)}}</td>
                                </tr>
                            @endforelse
                        </tbody>
                        </table>
                        <div class="pagination--sm justify-content-end">
                            {{$sells->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
