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
                                <th>@lang('TRX')</th>
                                <th>@lang('Amount')</th>
                                <th>@lang('Charge')</th>
                                <th>@lang('Post Balance')</th>
                                <th>@lang('Details')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($transactions as $trx)
                                <tr>
                                    <td data-label="@lang('Date')">
                                        <b>{{ showDateTime($trx->created_at,'d-m-Y') }}</b>
                                    </td>
                                    <td data-label="@lang('TRX')">
                                        <b>{{ $trx->trx }}</b>
                                    </td>
                                    <td data-label="@lang('Amount')">
                                        <strong @if($trx->trx_type == '+') class="text--primary" @else class="text--danger" @endif> {{($trx->trx_type == '+') ? '+':'-'}} {{getAmount($trx->amount)}} {{__($general->cur_text)}}</strong>
                                    </td>
                                    <td data-label="@lang('Charge')">
                                        <b>{{ __(__($general->cur_sym)) }} {{ getAmount($trx->charge) }}</b>
                                    </td>
                                    <td data-label="@lang('Post Balance')">
                                        <b>{{ getAmount($trx->post_balance) }} {{__($general->cur_text)}}</b>
                                    </td>
                                    <td data-label="@lang('Details')">
                                        {{ __($trx->details) }}
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
                            {{$transactions->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
