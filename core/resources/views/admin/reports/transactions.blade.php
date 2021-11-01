@extends('admin.layouts.app')

@section('panel')
    <div class="row">

        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th scope="col">@lang('Date')</th>
                                <th scope="col">@lang('TRX')</th>
                                <th scope="col">@lang('Username')</th>
                                <th scope="col">@lang('Amount')</th>
                                <th scope="col">@lang('Charge')</th>
                                <th scope="col">@lang('Post Balance')</th>
                                <th scope="col">@lang('Detail')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($transactions as $trx)
                                <tr>
                                    <td data-label="@lang('Date')">{{ showDateTime($trx->created_at) }}</td>
                                    <td data-label="@lang('TRX')" class="font-weight-bold">{{ $trx->trx }}</td>
                                    <td data-label="@lang('Username')"><a href="{{ route('admin.users.detail', $trx->user_id) }}">{{ @$trx->user->username }}</a></td>
                                    <td data-label="@lang('Amount')" class="budget">
                                        <strong @if($trx->trx_type == '+') class="text-success" @else class="text-danger" @endif> {{($trx->trx_type == '+') ? '+':'-'}} {{getAmount($trx->amount)}} {{__($general->cur_text)}}</strong>
                                    </td>
                                    <td data-label="@lang('Charge')" class="budget">{{ __(__($general->cur_sym)) }} {{ getAmount($trx->charge) }} </td>
                                    <td data-label="@lang('Post Balance')">{{ getAmount($trx->post_balance) }} {{__($general->cur_text)}}</td>
                                    <td data-label="@lang('Detail')">{{ __($trx->details) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($empty_message) }}</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                <div class="card-footer py-4">
                    {{ $transactions->links('admin.partials.paginate') }}
                </div>
            </div><!-- card end -->
        </div>
    </div>



@endsection


@push('breadcrumb-plugins')
    @if(request()->routeIs('admin.users.transactions'))
        <form action="" method="GET" class="form-inline float-sm-right bg--white">
            <div class="input-group has_append">
                <input type="text" name="search" class="form-control" placeholder="@lang('TRX / Username')" value="{{ $search ?? '' }}">
                <div class="input-group-append">
                    <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>
    @else
        <form action="{{ route('admin.report.transaction.search') }}" method="GET" class="form-inline float-sm-right bg--white">
            <div class="input-group has_append">
                <input type="text" name="search" class="form-control" placeholder="@lang('TRX / Username')" value="{{ $search ?? '' }}">
                <div class="input-group-append">
                    <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>
    @endif
@endpush


